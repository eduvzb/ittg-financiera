<template>
    <v-app>
       <AppBar /> 
       <Drawer /> <!-- Barra lateral -->
      <v-content class="">
        <div class="px-5 py-2">
          <router-view /> <!-- esto es lo que cambia -->
        </div>
        <v-snackbar
         v-model="snackbar.showing"
        :timeout="4000"
        :color="snackbar.color"
        >
            {{snackbar.text}}
        </v-snackbar>    
      </v-content>
    </v-app>
</template>

<script>
import Navigation from '@/js/components/Navigation';
import AppBar from '@/js/components/core/AppBar.vue';
import { mapState } from 'vuex'

import Drawer from '@/js/components/core/Drawer.vue'
export default {
    components: {
        navigation: Navigation,
        AppBar,
        Drawer,
    },
    computed: {
        drawerOpen () {
            return this.$store.state.drawerOpen;
        },
        user () {
            return this.$store.state.user || { name: '' };
        },
        ...mapState(['snackbar'])
    },
    methods: {
        drawerToggle () {
            this.$store.dispatch('drawerToggle');
        },
        async logout() {
            await this.$store.dispatch('logout');
            this.$router.push('/login');
        }
    }
}
</script>
