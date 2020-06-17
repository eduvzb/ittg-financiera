<template>
  <v-container
  fluid
  tag="section"
  >
    <v-row>
      <v-col cols="12" sm="12" md="6">
        <userEdit></userEdit>
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <userPasword></userPasword>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import userEdit from '@/js/components/userEdit.vue'
import userPasword from '@/js/components/userPassword.vue'
export default {
  name: 'user',
  components: {
      userEdit,
      userPasword
    },
}
</script>
