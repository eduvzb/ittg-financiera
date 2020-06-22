<template>
    <v-row dense>
        <v-col cols="3">
          <v-card
            color="#385F73"
            dark
            height="200px"
          >
            <v-card-title class="headline">Clientes</v-card-title>

            <v-card-subtitle class="display-4">
                <v-icon size="100" >mdi-account-circle</v-icon>
               {{ number }}
            </v-card-subtitle>
           
          </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
  name: 'home',
  data: function () {
    return{
      number : '',
    }
  },
  mounted () {
    this.getNumber()
  },
  methods: {
    getNumber(){
      axios.get('/api/clients/number')
        .then(response => {
          this.number = response.data
        })
        .catch(error => {
          console.log(error);
        })
    }
  }
}
</script>
