<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-row>
        <v-col
        :md="6"
        >
          <v-card>
            <v-list-item v-if="client">
              <v-list-item-content>
                <v-list-item-title>
                  <strong>Clientess:</strong>
                  {{ client.name }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <strong >Total abonado:</strong>
                   {{ payment.saldo_abonado}}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  <strong >Total pendiente:</strong>
                   {{ payment.saldo_pendiente}}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

          </v-card>
        </v-col>
        <v-col
        :md="6"
        >
          <v-card class="pa-5">
            <!-- <v-form> -->
              <v-row>
                <v-col
                :md="6"
                >
                  <v-text-field
                  v-model="pay.received_amount"
                  label="Ingrese cantidad"
                  prefix="$"
                  type="number"
                  required
                  >
                </v-text-field>
              </v-col>
              <v-col>
                <div class="my-3">
                  <v-btn 
                  color="primary"
                  @click="submit"
                  >
                  Primary</v-btn>
                </div>
              </v-col>
             </v-row>
           <!--  </v-form>  -->
          </v-card>
        </v-col>
      </v-row>
      <v-card>
        <v-card-title>
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="payments"
           class="elevation-1"
          :sort-by="['number']"
          > 
          </v-data-table>
      </v-card>
  </v-container>
</template>

<script>
import { mapState } from 'vuex'
const axios = require("axios")
export default {
    name:'clientsPayments',
    data: function () {
      return { 
        pay: {
          received_amount: ''
        },
         headers: [
          { text: 'Número de pago', value: 'number' },
          { text: 'Cuota', value: 'amount' },
          { text: 'Abonado', value: 'received_amount' },
          { text: 'Fecha de pago ', value: 'payment_date' },
          { text: 'Fecha de abono ', value: 'receipt_date' },
        ],
      }
    },
    methods: {
       submit (){
        let id = this.$route.params.id
         axios.post('/api/payments/store/' + id, this.pay)
          .then( response => {
            this.getPayments(id)
            this.pay.received_amount = ''
          })
          .catch( error => {
            console.log('Catch error', error);
            this.pay.received_amount = ''
          })
      },
      getPayments(id){
        this.$store.dispatch('getPayments',id)
      }
    },
    mounted () {
      let id = this.$route.params.id
      this.getPayments(id) 
      this.amount = '' 
    },
    computed: {
      ...mapState({
        payments: state=>state.payments.payments,
        client: state=>state.payments.client,
        payment: state=>state.payments
      })
    }
}
</script>

