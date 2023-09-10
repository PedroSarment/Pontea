<template>
  <div class="q-pa-md row items-start q-gutter-md">
    <h5 class="sub-title col-12 q-mb-sm">Por área do conhecimento</h5>
    <div class="cards-container">
      <KnowledgeCard
        v-for="item in items"
        :key="item.title"
        :title="item.title"
        :quantity="item.quantity"
        class="card-wrapper"
      />
    </div>
    <h5 class="sub-title col-12 q-mb-sm"> Educadores Bem Avaliados</h5>
    <div class="educadores-avaliados">
      <TeacherCard  v-for="teacher in teachers"
      :key="teacher.name"
      :name="teacher.name"
      :rating="teacher.rating"
      :quantity="teacher.quantity"
      :img_src="teacher.src"
      class="teacher-wrapper"/>
    </div>
  </div>
</template>

<script>
import KnowledgeCard from 'components/KnowledgeCard.vue';
import TeacherCard from 'src/components/TeacherCard.vue';

export default {
  name: 'HomePage',
  components: {
    KnowledgeCard,
    TeacherCard
},
  data() {
    return {
      items: [
        { title: 'Escuta, fala, pensamento e imaginação', quantity: 5 },
        { title: 'Corpo, gestos e movimento', quantity: 2 },
        { title: 'Espaços, tempo, quantidades, relações e transformações', quantity: 3 },
        { title: 'Traços, sons, cores e formas', quantity: 7 },
        { title: 'O Eu, o outro e o nós', quantity: 1 },
        // { title: 'Espaços, tempo, quantidades, relações e transformações', quantity: 3 },
        // { title: 'Traços, sons, cores e formas', quantity: 7 },
        // { title: 'O Eu, o outro e o nós', quantity: 1 },
        // ... more items ...
      ],
      teachers:[
        { name: 'Testando um nome grande', rating: 4.2, quantity: 2, src: "https://cdn.quasar.dev/img/avatar2.jpg"},
        { name: 'Estela Mendes', rating: 5, quantity: 21, src: "https://cdn.quasar.dev/img/avatar2.jpg"},
        { name: 'Ana', rating: 4, quantity: 2, src: "https://cdn.quasar.dev/img/avatar2.jpg"}
      ]
    };
  }
  // ... outras configurações do componente ...
}
</script>

<style scoped>

.cards-container {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  gap: 20px; /* Espaçamento entre os cards */
}

.card-wrapper {
  flex-basis: calc(33.33% - 20px); /* Defina o tamanho base dos cards */
  margin: 0; /* Remova as margens padrão */
}

.educadores-avaliados{
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
.teacher-wrapper {
  flex-basis: calc(33.33% - 20px); /* Defina o tamanho base dos cards */
  margin: 0; /* Remova as margens padrão */
}

</style>
