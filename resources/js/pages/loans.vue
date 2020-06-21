<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-card>
        <v-card-title>
          Prestamos
          <formLoan
          v-model="loan"
          @submit = "choose"
          :openModal="openModal"
          @changeModal="changeModal"
          @changeEditing="changeEditing"
          >
          </formLoan>
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="loans"
          class="elevation-1"
          > 
          <template v-slot:top>
            
          </template>
          <template v-slot:item.name="{ item }">
            {{ item.client.name }}
          </template>
            <template v-slot:item.Actions="{ item }">
              <div class="my-2">
                <v-btn color="error" 
                fab x-small dark
                @click="deleteItem(item)"
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
                <v-btn color="primary" 
                fab x-small dark
                @click="findLoan(item)"
                >
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
              </div> 
            </template>
          </v-data-table>
      </v-card>
  </v-container>
</template>

<script>
  import { mapState } from 'vuex'
  import Swal from 'sweetalert2'
  import formLoan from '@/js/components/FormLoan.vue'
  const axios = require("axios");
  export default {
    name: 'loans',
    components: {
      formLoan
    },
    data: function () {
      return {
        editing: false,
        openModal: false,
        loan: {
          client_id: '',
          amount: '',
          payments_number: '',
          fee: '',
          ministry_date: '',
          due_date: ''
        },
        headers: [
          { text: 'id', value: 'id' },
          { text: 'Nombre', value: 'name' },
          { text: 'Cantidad', value: 'amount' },
          { text: 'Número de pagos ', value: 'payments_number' },
          { text: 'Cuota ', value: 'fee' },
          { text: 'Fecha de ministración ', value: 'ministry_date' },
          { text: 'Fecha de vencimiento', value: 'due_date' },
          { text: 'Acciones', value: 'Actions' },
        ],
      }
    },
    computed: {
        ...mapState({
            loans: state=>state.loans,
            clientsNames: state=>state.clientsNames,
            LoanSelected: state=>state.loan
        })
    },
    mounted () {
      this.getLoans();
      this.fillSelectClient();
    },
    methods: {
      changeModal (flag){
        this.openModal = flag;
      },
      choose (){
        if(this.editing)
          this.edit()
        else
          this.save()
      },
      edit (){
        axios.post('/api/loans/edit/' + this.loan.id, this.loan)
          .then(response => {
            this.getLoans();
            this.editing = false
            this.openModal = false
            this.$store.dispatch('setSnackbar',{
                text: 'El cliente ha sido actualizado correctamente'
              })
          })
          .catch(error => {
            this.editing = false
            this.openModal = false
            this.$store.dispatch('setSnackbar',{
                text: 'Ocurrió un error al actualizar el prestamo',
                color: 'red'
              })
            console.log(error.data)  
          })
      },
      save (){
        axios.post('/api/loan', this.loan)
          .then( response => {
            this.getLoans();
            this.$store.dispatch('setSnackbar',{
                  text: 'El prestamo ha sido añadido'
                })
          })
          .catch(error => {
            console.log('Catch error', error);
            this.editing = false;
            this.openModal = false
          })
      },
      getLoans (){
          this.$store.dispatch('getLoans');
      },
      fillSelectClient (){
      this.$store.dispatch('fillSelectClient');
      },
      deleteItem(item){
        Swal.fire({
        title: '¿Seguro desea eliminar el prestamo?',
        text: "No podrá revertir está acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar'
          }).then((result) => {
            if (result.value) {
              const index = this.loans.indexOf(item)
              const id = this.loans[index].id;
              axios.post('/api/loan/delete/' + id)
                .then(response => {
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                  this.getLoans();
                })
                .catch(error => {
                  Swal.fire(
                    'Ocurrió un error',
                    'El prestamo no ha podido ser borrado',
                    'error'
                  )
                })
            }
          })
      },
      async findLoan (item){
        this.editing = true;
        const index = this.loans.indexOf(item)
        const id = this.loans[index].id;
        console.log(id);
        await this.$store.dispatch('getLoan', id);
          this.loan = Object.assign({}, this.loan, this.LoanSelected)
            this.openModal = true;
      },
      changeEditing: function (value){
        this.editing = value;
      }
    }
  }
</script>
