<template>
  <v-row justify="end">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mx-3"
          fab 
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          <v-icon dark>mdi-plus</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Datos del prestamo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            >
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-select
                  :items="clientsNames"
                  :rules="clientRules"
                  label="Cliente"
                  item-text="name"
                  item-value="id"
                  v-model="value.client_id"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field 
                  :rules="amountRules"
                  label="Cantidad*" 
                  prefix="$"
                  type="number"
                  v-model="value.amount"
                  >
                  </v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    :rules="numberRules"
                    label="Número de pagos*"
                    required
                    type="number"
                    v-model="value.payments_number"
                    @change="updDate"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    :rules="feeRules"
                    label="Cuota*"
                    required
                    type="number"
                    v-model="value.fee"
                   
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    :rules="ministryRules"
                    label="Fecha de ministración*"
                    required
                    type="date"
                    v-model="value.ministry_date"
                    @change="updDate"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    label="Fecha de vencimiento*"
                    required
                    type="date"
                    readonly
                    v-model="value.due_date"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
          <small>*Indica los campos obligatorios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
          <v-btn :disabled="!valid" color="blue darken-1" text @click="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import moment from 'moment-business-days'
import { mapState } from 'vuex'
export default {
    name: 'FormLoan',
    data: () => ({
      dialog: false,
      paymentsNumber: 0,
      valid: true,
      clientRules: [
        v => !!v || 'El nombre del cliente es requerido',
      ],
      amountRules: [
        v => !!v || 'La cantidad es requerida',
      ],
      numberRules: [
        v => !!v || 'La cantidad de pagos es requerida',
      ],
      feeRules: [
        v => !!v || 'La couta es requerida',
      ],
      ministryRules: [
        v => !!v || 'La fecha de ministro es requerida',
      ],
      dueRules: [
        v => !!v || 'La fecha de vencimiento es requerida',
      ],
    }),
    watch: {
      openModal: function (){
      this.dialog = this.openModal;  
      }

    },
    props: {
      value:{
        type: Object,
        default: function () {
          return {
            client_id:'',
            amount: '',
            payments_number: '',
            fee: '',
            ministry_date :'',
            due_date :'',
          }
        }
        },
      openModal: {
        type: Boolean,
        default: false,
      }
    },
    computed: {
        ...mapState({
            clientsNames: state=>state.clientsNames
          }),
        hoy (){
          return moment().format('YYYY-MM-DD');
        },
        dueDate (){
          let date = moment(this.value.ministry_date).businessAdd(this.value.payments_number)._d
          date = moment(date).format('YYYY-MM-DD')
          return date
        }
    },
    mounted () {
      this.value.ministry_date = moment().format('YYYY-MM-DD')
      this.value.due_date = this.dueDate
    },
    methods: {
        updDate (){
          this.value.due_date = this.dueDate
        },
        submit () {
            this.dialog = false;
            this.$emit('submit', this.value);
        },
        changeModal (){
          this.$emit('changeModal', this.dialog)
          this.$emit('changeEditing', this.editing)
        },
        closeDialog (){
          this.dialog = false
          this.editing = false
          this.changeModal();
        },

    }
}
</script>
