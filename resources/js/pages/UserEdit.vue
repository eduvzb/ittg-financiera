<template>
  <v-container
  fluid
  tag="section"
  >
    <v-card>
      <v-row>
        <v-col
        :md="6"
        >
            <v-row>
              <v-col
              :md="3"
              >
               
              </v-col>
              <v-col
              :md="9"
              >
                <v-row>
                 <v-col cols="12" sm="12" md="10">
                  <v-text-field label="Nombre*" 
                    required
                    outlined
                    >
                    </v-text-field>
                </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" sm="12" md="10">
                    <v-text-field label="Coreo Electrónico*" 
                    required
                    outlined
                    >
                    </v-text-field>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
        </v-col>
      </v-row>  
    </v-card>
  </v-container>
</template>

<script>
export default {
    name: 'userEdit'
}
</script>

<style>

</style>