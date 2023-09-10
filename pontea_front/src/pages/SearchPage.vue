<template>
    <div>
      <!-- Conteúdo da página vai aqui -->
      <h1>Página Vazia</h1>
    </div>

    aaaaa

</template>

<script>
export default {
  name: 'EmptyPage',
  created() {

    const urlParams = new URLSearchParams(window.location.search);
    const paramsArray = [];

    for (const [key, value] of urlParams.entries()) {
      paramsArray.push({ key, value });
    }

    this.$root.urlParamsArray = paramsArray;
  },
};
</script>

<style scoped>

/* Estilos específicos para esta página, se necessário */
</style>
