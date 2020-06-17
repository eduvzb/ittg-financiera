<template>
    <v-card>
        <v-row>
            <v-col :md="8" :sm="6" :lg="3">
               <v-list-item>
                <v-list-item-content>
                <v-avatar size="128">
                    <img
                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                        alt="John"
                    >
                    </v-avatar>
                    <fileUpload v-model="user.picture"></fileUpload>
                    <!-- <template>
                      <v-file-input
                      :v-model="user.picture"
                      multiple label="File input"
                      :disabled="active"
                      >
                      </v-file-input>
                    </template> -->
                </v-list-item-content>
                </v-list-item>
            </v-col>
            <v-col :md="12" :lg="8">
                <form>
                    <v-text-field
                    label="Name"
                    v-model="user.name"
                    required
                    outlined
                    :disabled="active"
                    ></v-text-field>
                    <v-text-field
                    label="E-mail"
                    v-model="user.email"
                    required
                    outlined
                    :disabled="active"
                    ></v-text-field>
                    <v-btn 
                    class="my-4"
                    @click="check"
                    >
                    Editar</v-btn>
                </form>
            </v-col>
        </v-row>
    </v-card>
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
								console.log(res)
							})
							.catch(error => error)
        }
    }
        
}
</script>