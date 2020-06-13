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
export default {
    name:'clientsPayments'
}
</script>

<style>

</style>