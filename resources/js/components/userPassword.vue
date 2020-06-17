<template>
  <v-row
  >
    <v-col col="12">
      <v-card>
        <v-card-title>
        </v-card-title>
        <v-card-text>
            <v-row justify="center" align="center">
              <v-col md="8">
                <v-row>
                    <v-text-field
                    outlined
                    label="Contraseña actual"
                    :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                    :type="showPassword ? 'text': 'password'"
                    @click:append="showPassword = !showPassword"
                    >
                   </v-text-field>
                </v-row>
                <v-row>
                    <v-text-field
                    outlined
                    label="Contraseña nueva"
                    :append-icon="showPassword2 ? 'mdi-eye': 'mdi-eye-off'"
                    :type="showPassword2 ? 'text': 'password'"
                    @click:append="showPassword2 = !showPassword2"
                    >
                   </v-text-field>
                </v-row>  
                <v-row>
                    <v-text-field
                    outlined
                    label="Confirmar contraseña"
                    :append-icon="showPassword3 ? 'mdi-eye': 'mdi-eye-off'"
                    :type="showPassword3 ? 'text': 'password'"
                    @click:append="showPassword3 = !showPassword3"
                    >
                   </v-text-field>
                </v-row>
                <v-row justify="end">
                   <v-btn 
                    class="my-4"
                    >
                    Guardar</v-btn>
                </v-row>
              </v-col>
            </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
     name: 'userPassword',
     data: () => ({
       showPassword: false,
       showPassword2: false,
       showPassword3: false
     })
}
</script>
