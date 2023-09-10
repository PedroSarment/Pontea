<template>
  <q-layout view="lHh Lpr lFf">
    <app-header :tab="tab" />
    <q-page-container class="page-container">
      <router-view /> <!-- This is where the HomePage will be rendered -->
    </q-page-container>
  </q-layout>
</template>

<script>
import AppHeader from 'components/HeaderComponent.vue';
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'MainLayout',

  components: {
    AppHeader,
  },

  setup() {
    const tab = ref('home'); // Definindo "Home" como tab ativa

    return {
      tab,
    };
  },
});
</script>

<style scoped>
/* Add any custom styles you might need */

.page-container {
  margin: 0 3px; /* 3px de margem nas laterais da página */
}
</style>
