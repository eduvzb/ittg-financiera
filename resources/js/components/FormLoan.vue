<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Nuevo prestamo
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
                :items="items"
                label="Filled style"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field 
                label="Cantidad*" 
                prefix="$"
                type="number"
                v-model="value.phone"
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
                  v-model="value.address"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Cuota*"
                  required
                  type="number"
                  v-model="value.address"
                ></v-text-field>
              </v-col>
            </v-row>
             <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Fecha de ministración*"
                  required
                  type="date"
                  v-model="value.address"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  label="Fecha de vencimiento*"
                  required
                  type="date"
                  v-model="value.address"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*Indica los campos obligatorios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
    name: 'FormLoan',
    data: () => ({
      dialog: false,
      clearable: false,
      items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
    }),
    props: {
        value:{
            type: Object,
            default: function () {
                return {
                    name: '',
                    phone: '',
                    address: '',
                }
            }
        },
    },
    methods: {
        submit: function () {
            this.dialog = false;
            this.$emit('submit',this.value);
        }
    }
}
</script>

<style>

</style>