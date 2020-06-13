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
            Prestamos
          </v-card>
        </v-col>
        <v-col
        :md="6"
        >
          <v-card class="pa-5">
            <v-form>
              <v-row>
                <v-col
                :md="6"
                >
                  <v-text-field
                  v-model="amount"
                  label="Ingrese cantidad"
                  prefix="$"
                  type="number"
                  required
                  >
                </v-text-field>
              </v-col>
              <v-col>
                <div class="my-3">
                  <v-btn color="primary">Primary</v-btn>
                </div>
              </v-col>
             </v-row>
            </v-form> 
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
          > 
          </v-data-table>
      </v-card>
  </v-container>
</template>

<script>
export default {
    name:'clientsPayments',
    data: function () {
      return { 
        amount: 0,
        headers: [],
        payments: [],
      }
    },
    methods: {
      getPaymens(){
        this.store.dispatch('getPaymens');
      }
    }
}
</script>

