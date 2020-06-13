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
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-select
                :items="clientsNames"
                label="Cliente"
                item-text="name"
                item-value="id"
                v-model="value.client_id"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field 
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
                  label="Número de pagos*"
                  required
                  type="number"
                  v-model="value.payments_number"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
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
                  label="Fecha de ministración*"
                  required
                  type="date"
                  v-model="value.ministry_date"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Fecha de vencimiento*"
                  required
                  type="date"
                  v-model="value.due_date"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*Indica los campos obligatorios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
          <v-btn color="blue darken-1" text @click="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'
export default {
    name: 'FormLoan',
    data: () => ({
      dialog: false,
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
          })
    },
    methods: {
        submit: function () {
            this.dialog = false;
            this.$emit('submit', this.value);
        },
        changeModal: function (){
          this.$emit('changeModal', this.dialog)
        },
        closeDialog: function (){
          this.dialog = false;
          this.changeModal();
        }
    }
}
</script>
