<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mx-3"
          fab 
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
           <v-icon dark>mdi-plus</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Datos del cliente</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form 
            ref="form"
            v-model="valid"
            lazy-validation
            >
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field label="Nombre*" 
                  :rules="nameRules"
                  required
                  v-model="value.name"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field label="Telefono*" 
                  :rules="phoneRules"
                  required
                  v-model="value.phone"
                  >
                  </v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="12">
                  <v-text-field
                    label="Dirección*"
                    :rules="addressRules"
                    required
                    v-model="value.address"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
          <small>*Indica los campos obligatorios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
          <v-btn :disabled="!valid" color="blue darken-1" text @click="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>

<script>
export default {
    name: 'FormClient',
    data: () => ({
      dialog: false,
      valid: true,
      editing: '',
      nameRules: [
        v => !!v || 'El nombre es requerido',
      ],
      phoneRules: [
        v => !!v || 'El número de telefono es requerido',
      ],
      addressRules: [
        v => !!v || 'La dirección es requerida',
      ],
    }),
    watch: {
      openModal: function (){
        this.dialog = this.openModal;  
      }
    },
    props: {
      value:{
        type: Object,
        default: function () {
          return {
            name: '',
            phone: '',
            address: '',
          }
        }
      },
      openModal: {
        type: Boolean,
        default: false,
      }
    },
    methods: {
        validate () {
        this.$refs.form.validate()
        },
        submit: function () {
          this.dialog = false;
          this.$emit('submit',this.value);
        },
        changeModal: function (){
          this.$emit('changeModal', this.dialog)
          this.$emit('changeEditing', this.editing)
        },
        closeDialog: function (){
          this.dialog = false
          this.editing = false
          this.changeModal()
        },
        cleanInputs (){
          this.value.name = ''
          this.value.phone = ''
          this.value.address = ''
        }
    }
}
</script>