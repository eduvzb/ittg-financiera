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
            <v-file-input
            multiple label="File input"
            show-size
            ></v-file-input>
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
            @click="dialog = false"
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
    name: 'uploadFile',
    data () {
      return {
        dialog: false,
      }
    },
}
</script>

<style scoped>
    .v-dialog {
        position: absolute;
        bottom: 0;
        right: 0;
    }
</style>