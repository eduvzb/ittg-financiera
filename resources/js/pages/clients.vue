<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <button @click="update">Actualizar</button>
      <FormClient v-model="client"
      @submit="save"
      ></FormClient>
      <v-data-table 
        :headers="headers"
        :items="clients"
         class="elevation-1"
      > 
      <template v-slot:item.Actions="{ item }">
        <button @click="deleteItem(item)">Delete</button>
      </template>

      </v-data-table>
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
        console.log(this.clients[index].id);
      },
      update (){
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
