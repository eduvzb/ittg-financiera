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
          >
          </formLoan>
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="loans"
          class="elevation-1"
          > 
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
                @click="findClient(item)"
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
  import formLoan from '@/js/components/FormLoan.vue'
  const axios = require("axios");
  export default {
    name: 'payments',
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
        })
    },
    mounted () {
      this.getPaymentsIndex();
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
        //
      },
      save (){
        //
      },  
      getPaymentsIndex (){
          this.$store.dispatch('getPaymentsIndex');
      },
      deleteItem(item){
        //
      }
    }
  }
</script>
