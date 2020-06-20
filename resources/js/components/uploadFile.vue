<template>
  <v-row justify="center">
    <v-btn
      fab
      color="primary"
      dark
      @click.stop="dialog = true"
    >
       <v-icon dark>mdi-file-upload-outline</v-icon>
    </v-btn>

    <v-dialog
      v-model="dialog"
      max-width="400"
      top
      class="v-dialog"
    >
      <v-card >
        <v-card-title class="headline">Importar clientes</v-card-title>
        <v-card-text>
          <input
          type="file"
          ref="file"
          v-on:change="handleFileUpload()"
          accept=".XLSX, .CSV"
          >
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red"
            text
            @click="dialog = false"
          >
            Disagree
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click="save"
          >
            Importar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapState } from 'vuex'
export default {
    name: 'uploadFile',
    data () {
      return {
        dialog: false,
        file: '',
      }
    },
    methods: {
      save(){
        let formData = new FormData();
        formData.append('file', this.file);
        axios
            .post( '/api/clients-import',
                formData, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                }
            ).then(function(){
                this.dialog = true
                this.$store.dispatch('setSnackbar',{
                  text: 'Datos importados correctamente'
                });
            })
            .catch(function(){
                this.$store.dispatch('setSnackbar',{
                  text: 'Ha ocurrido un error',
                  color:"red"
                })
            });
      },
    handleFileUpload(){
      this.file = this.$refs.file.files[0];
    }
  }
}
</script>

<style scoped>
    .v-dialog {
        position: absolute;
        bottom: 0;
        right: 0;
    }
</style>