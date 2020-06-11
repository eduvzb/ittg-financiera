<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-card>
        <v-card-title>
            Clientes
            <FormClient v-model="client"
            @submit="save"
            ></FormClient>
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="clients"
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
          name: 'Test',
          phone: '123123',
          address: 'aasdasd'
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
        ...mapState({
            clients: state=>state.clients
          })
    },
    mounted () {
      this.getClients();
    },
    methods: {
      deleteItem (item){
        const index = this.clients.indexOf(item)
        const id = this.clients[index].id;
        console.log(id);
          axios.post('/api/clients/delete/' + id)
            .then(response => {
              this.getClients();
            })
            .catch(error => {
              console.log(error);
            });
      },
      save (){
         axios.post('/api/clients',this.client)
                  .then(response => {
                    console.log(response);
                     this.getClients();
                  })
                  .catch(error => {
                      console.log('Catch error', error);
                  });        
      },
      getClients: function () {
        this.$store.dispatch('getClient');
      }
    }
  }
</script>
