<template>
  <v-row>
    <v-col col="12">
      <v-card>
        <v-card-title h1>
          Editar usuario
        </v-card-title>
        <v-card-text>
            <v-row justify="center" align="center">
              <v-col md="8">
                <v-row>
                   <v-text-field
                    label="Name"
                    v-model="user.name"
                    required
                    outlined
                    :disabled="active"
                    ></v-text-field>
                </v-row>
                <v-row>
                   <v-text-field
                    label="E-mail"
                    v-model="user.email"
                    required
                    outlined
                    :disabled="active"
                    ></v-text-field>
                </v-row>  
                <v-row justify="end">
                   <v-btn 
                    class="my-4"
                    @click="check"
                    >
                    Editar</v-btn>
                </v-row>
              </v-col>
            </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'
import fileUpload from '@/js/components/fileUpload.vue'
const axios = require("axios")
export default {
    name: 'userEdit',
    components: {
      fileUpload
    },
    data: () => ({
        active: true,
    }),
    computed: {
      ...mapState({
        user: state => state.user
      })
    },
    methods: {
        check (){
          if(this.active)
            this.active = false
          else
            this.onUpload()
        },
        onUpload (){
						axios.post('/api/user-edit', this.user)
							.then (res => {
                this.active = true
								this.$store.dispatch('setSnackbar',{
                  text: 'El usario ha sido modificado exitosamente'
                })
							})
							.catch(error => error)
        }
    }
        
}
</script>