<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-card>
        <v-card-title>
            Prestamos
            <FormClient v-model="client"
            @submit="save"
            ></FormClient>
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
  import FormClient from '@/js/components/FormClient.vue'
  const axios = require("axios");
  export default {
    name: 'clients',
    components: {
      FormClient
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
          { text: 'Telefono', value: 'phone' },
          { text: 'Dirección ', value: 'address' },
          { text: 'Opciones ', value: 'Actions' },
        ],
        items: [
          { name: 'Eduardo', phone: '123123', address: 'asdsadasd', Actions:''}
        ]
      }
    },
    computed: {
       loans: function () {}
    },
    mounted () {
      //
    },
    methods: {
        //
    }
  }
</script>
