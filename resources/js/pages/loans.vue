<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-card>
        <v-card-title>
            Prestamos
            <formLoan>
            </formLoan>
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="loans"
          class="elevation-1"
          > 
            <template v-slot:item.Actions="{ item }">
                <div class="my-2">
                  <v-btn color="error" 
                  fab x-small dark
                  @click="deleteItem(item)"
                  >
                <v-icon>mdi-delete</v-icon>
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
    name: 'clients',
    components: {
      formLoan
    },
    data: function () {
      return {
        client: {
          name: '',
          phone: '',
          address: ''
        },
        headers: [
          { text: 'id', value: 'id' },
          { text: 'Nombre', value: 'name' },
          { text: 'Cantidad', value: 'amount' },
          { text: 'Número de pagos ', value: 'payments_number' },
          { text: 'Cuota ', value: 'fee' },
          { text: 'Fecha de ministración ', value: 'ministry_date' },
          { text: 'Fecha de vencimiento', value: 'due_date' },
          { text: 'Acciones', value: '' },
        ],
        items: [
          { name: 'Eduardo', phone: '123123', address: 'asdsadasd', Actions:''}
        ]
      }
    },
    computed: {
        ...mapState({
            loans: state=>state.loans
        })
    },
    mounted () {
      this.getLoans();
    },
    methods: {
        getLoans (){
            this.$store.dispatch('getLoans');
        }
    },
    
  }
</script>
