<template>
    <v-container
      id="regular-tables"
      fluid
      tag="section"
    >
      <v-card>
        <v-card-title>
          <v-row justify="space-between">
            <v-col md="10" class="pa-0">
              Clientes
            </v-col>
            <v-col md="2" justify="end" class="pa-0">
              <v-row> 
                <v-col align="end" class="ml-10 pa-0">
                  <uploadFile/>
                </v-col >
                <v-col align="end" class="pa-0 mr-3"> 
                  <FormClient 
                  v-model="client"
                  @submit="choose" 
                  :openModal="openModal"
                  @changeModal="changeModal"
                  @changeEditing="changeEditing"
                  >
                  </FormClient>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
            
            
           
        </v-card-title>
          <v-data-table 
          :headers="headers"
          :items="clients"
           class="elevation-1"
          :sort-by="['id']"
          > 
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
  import { mapState } from 'vuex'
  import FormClient from '@/js/components/FormClient.vue'
  import uploadFile from '@/js/components/uploadFile.vue'
  const axios = require("axios");
  export default {
    name: 'clients',
    components: {
      FormClient,
      uploadFile
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
        openModal: false,
        editing: false,  
      }
    },
    computed: {
      ...mapState({
          clients: state=>state.clients,
          clientSelected: state=>state.client
        })
    },
    mounted () {
      this.getClients();
    },
    methods: {
      deleteItem (item){
      const index = this.clients.indexOf(item)
      const id = this.clients[index].id;
        axios.post('/api/clients/delete/' + id)
          .then(response => {
            this.getClients();
          })
          .catch(error => {
            console.log(error);
          });
    },
      save (){
        console.log(this.client);
        axios.post('/api/clients',this.client)
          .then(response => {
            console.log(response);
              this.getClients();
              this.editing = false;
              this.$store.dispatch('setSnackbar',{
                  text: 'El cliente ha sido añadido correctamente'
              })
          })
            .catch(error => {
              console.log('Catch error', error);
              this.editing = false;
              this.openModal = false
            });     
      },
      edit (){
        axios.post('/api/clients/edit/' + this.client.id, this.client)
          .then(response => {
            this.getClients();
            this.editing = false
            this.openModal = false
            this.$store.dispatch('setSnackbar',{
                text: 'El cliente ha sido actualizado correctamente'
              })
          })
          .catch(error => {
            this.editing = false
            this.$store.dispatch('setSnackbar',{
                text: 'Ocurrió un error al actualizar el cliente',
                color: 'red'
              })
          })
      },
      choose (){
        if(this.editing == true){
          this.edit();
        }else
          this.save();
      },
      getClients: function () {
        this.$store.dispatch('getClients');
      },
      async findClient (item){
        this.editing = true;
        const index = this.clients.indexOf(item)
        const id = this.clients[index].id;
        await this.$store.dispatch('getClient', id);
          this.client = Object.assign({}, this.client, this.clientSelected)
            this.openModal = true;
      },
      changeModal: function (modal){
        this.openModal = modal;
      },
      changeEditing: function (value){
        this.editing = value;
      }
    }
  }
</script>
