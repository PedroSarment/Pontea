<template>
  <q-header
    reveal
    style="
      background-color: white;
      color: black;
      box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
      padding-bottom: 1%;
    "
  >
    <q-toolbar class="q-space-between" style="background-color: #D9DCF9; padding: 1%;">
      <div>
        <img
          src="/../images/logo.svg"
          alt="Logo"
          class="logo-image"
          style="max-width: 300px; min-width: 150px; z-index: 1;"
        />
      </div>
      <div class="toolbar-icons">
        <div class="search-input">
          <q-input outlined rounded dense class="rounded-input" label="Busca" v-model="searchQuery">
            <template v-slot:prepend>
              <div class="search-icon">
                <q-icon name="search" />
              </div>
            </template>
          </q-input>
        </div>
        <div style="display: flex; align-items: stretch; gap: 0.75rem;">
          <div class="icon-button">
            <img src="/../icons/notification.svg" alt="Notifications" class="icon-svg" />
          </div>
          <div class="icon-button">
            <img src="/../icons/shoppingCart.svg" alt="Cart" class="icon-svg" />
          </div>
          <div class="icon-avatar">
            <q-avatar size="34px" class="custom-avatar">
              <img src="/../images/profile.jpeg" alt="Foto de Perfil" class="avatar-image" />
            </q-avatar>
          </div>
        </div>
      </div>
    </q-toolbar>

    <!-- Use v-if para ocultar a div quando a rota estiver na raiz -->
    <div class="breadcrumb" style="margin-top: 1%; margin-left: 15px;" v-if="route.path !== '/' && route.path !== '/home'">
      <router-link to="/home" class="breadcrumb-link">Home</router-link>
      <span v-if="route.path !== '/'">|</span>
      <router-link v-if="route.path !== '/'" :to="route.path" class="breadcrumb-link">{{ getBreadcrumbLabel(route) }}</router-link>
    </div>

    <div class="toolbar-options" style="margin-top: 1%; margin-left: 15px;">
      <router-link to="/atividades" class="icon-button-option" :class="{ 'active-button': isActiveTab('/atividades') }">
        Atividades
      </router-link>
      <router-link to="/experiencias" class="icon-button-option" :class="{ 'active-button': isActiveTab('/experiencias') }">
        Campos de experiências
      </router-link>
      <router-link to="/educadores" class="icon-button-option" :class="{ 'active-button': isActiveTab('/educadores') }">
        Educadores
      </router-link>
    </div>

    <div class="selectActivate" v-if="route.path === '/atividades'">
      <q-select
        outlined dense
        v-model="model.supportLevel"
        :options="supportLevelOptions"
        label="Nivel de suporte do TEA"
        class="custom-q-select narrower-select"
      />
      <q-select
        outlined dense
        v-model="model.experienceFields"
        :options="experienceFieldsOptions"
        label="Campos de experiência"
        class="custom-q-select narrower-select"
      />
      <q-select
        outlined dense
        v-model="model.ageRange"
        :options="ageRangeOptions"
        label="Faixa etária"
        class="custom-q-select narrower-select"
      />
      <q-select
        outlined dense
        v-model="model.activityLevel"
        :options="activityLevelOptions"
        label="Nível da atividade"
        class="custom-q-select narrower-select"
      />
      <q-select
        outlined dense
        v-model="model.multimediaResources"
        :options="multimediaResourcesOptions"
        label="Recursos multimídia"
        class="custom-q-select narrower-select"
      />
      <q-select
        outlined dense
        v-model="model.visualInstructions"
        :options="visualInstructionsOptions"
        label="Instruções visuais"
        class="custom-q-select narrower-select"
      />
    </div>

    <div class="experience-buttons" v-if="route.path === '/experiencias'">
      <q-btn
        v-for="field in experienceFieldsOptions"
        :key="field"
        :class="{ 'active-button': activeField === field }"
        @click="toggleActiveField(field)"
        size="sm"
        style="color: inherit; background-color: inherit; border: none;"
      >
        <span :style="{ color: activeField === field ? '#144ec0' : 'inherit' }">{{ field }}</span>
      </q-btn>
    </div>
  </q-header>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  name: 'HeaderComponent',

  setup() {
    const route = useRoute();

    const getBreadcrumbLabel = (route) => {
      // Mapeie suas rotas e os rótulos correspondentes aqui
      const routeLabels = {
        '/atividades': 'Atividades',
        '/experiencias': 'Campos de Experiências',
        '/educadores': 'Educadores',
        // Adicione mais rotas e rótulos conforme necessário
      };

      return routeLabels[route.path] || '';
    };

    const isActiveTab = (tabRoute) => {
      return route.path === tabRoute;
    };

    // Dados para as seleções
    const supportLevelOptions = ['Nível 1', 'Nível 2', 'Nível 3'];
    const experienceFieldsOptions = [
      'O Eu, o outro e o nós',
      'Traços, sons, cores e formas',
      'Espaços, tempo, quantidades, relações e transformações',
      'Corpo, gestos e movimento',
      'Escuta, fala, pensamento e imaginação',
    ];
    const ageRangeOptions = [
      '0 a 1 ano e 6 meses',
      '1 ano e 7 meses a 3 anos e 11 meses',
      '4 anos a 5 anos e 11 meses',
      '6 anos a 11 anos'
    ];
    const activityLevelOptions = ['Fácil', 'Médio', 'Avançado'];
    const multimediaResourcesOptions = ['Com', 'Sem'];
    const visualInstructionsOptions = ['Com', 'Sem'];

    // Modelo para armazenar seleções
    const model = {
      supportLevel: null,
      experienceFields: null,
      ageRange: null,
      activityLevel: null,
      multimediaResources: null,
      visualInstructions: null,
    };

    const activeField = ref(null);

    const toggleActiveField = (field) => {
      activeField.value = activeField.value === field ? null : field;
    };

    return {
      route,
      getBreadcrumbLabel,
      isActiveTab,
      supportLevelOptions,
      experienceFieldsOptions,
      ageRangeOptions,
      activityLevelOptions,
      multimediaResourcesOptions,
      visualInstructionsOptions,
      model,
      activeField,
      toggleActiveField,
    };
  },
});
</script>

<style scoped>
.active-button {
  font-weight: bold;
  color: #144ec0;
}

.toolbar-icons {
  display: flex;
  align-items: center;
  margin-left: 10px;
  padding-right: 20px;
  gap: 1.5rem;
}

.toolbar-options {
  display: flex;
  width: 76rem;
  align-items: center;
  gap: 1rem;
}

.icon-button-option {
  color: var(--textos-cinza, #616167);
  text-decoration: none;
  cursor: pointer;
  font-size: 0.90rem;
  font-style: normal;
  font-weight: 500;
  line-height: 1rem; /* 125% */
}

.icon-button-option.active-button {
  text-decoration: underline; /* Adiciona um sublinhado quando ativo */
  color: #144EC0; /* Cor azul para ativo */
  text-decoration-skip-ink: auto; /* Controlar a posição do sublinhado */
  text-underline-offset: 0.5rem; /* Ajustar o deslocamento vertical (aumente conforme necessário) */
}

.search-input {
  display: flex;
  align-items: center;
  gap: 0.7rem;
}

.rounded-input {
  width: 20rem;
  min-width: 5rem;
  border-radius: 30px;
  overflow: hidden;
  background-color: #FBFDFF;
  border: 0.09rem solid #144ec0;
}

.search-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 2rem;
  height: 100%;
  background-color: #FBFDFF;
  border-radius: 30px 0 0 30px;
}

.icon-avatar {
  margin-left: 0.20rem;
  display: flex;
  width: 1.5rem;
  height: 1.5rem;
  justify-content: center;
  align-items: center;
}

.q-ml-sm {
  margin-left: 10px;
}

.flex-grow-1 {
  flex-grow: 1;
}

.breadcrumb {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  color: var(--textos-cinza, #616167); /* Cor cinza para o breadcrumb */
}

.breadcrumb-link {
  text-decoration: none; /* Remover sublinhado dos links do breadcrumb */
  color: var(--textos-cinza, #616167); /* Cor cinza para os links do breadcrumb */
  cursor: pointer;
}

/* Estilo hover para os links do breadcrumb */
.breadcrumb-link:hover {
  text-decoration: underline; /* Adicionar sublinhado quando o mouse estiver sobre o link */
  color: #144ec0; /* Cor azul quando o mouse estiver sobre o link */
}

.row, .column, .flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.selectActivate {
  display: flex;
  justify-content: space-evenly;
  align-items: flex-start;
  height: 3rem;
  margin-top: 2%;
}

.custom-q-select {
  width: 70%; /* Largura personalizada */
  height: 1.5rem !important;
  margin-left: 10px;
  margin-right: 10px;
  border-width: 0.09rem; /* Largura da borda */
  border-color: #144ec0; /* Cor da borda */
  border-radius: 0.25rem; /* Raio da borda */
  margin-bottom: 1%;
}

.q-field--auto-height .q-field__control {
    height: 1.5rem !important;
    min-height: none;
}

.q-field--auto-height .q-field__control,
.q-field--auto-height .q-field__native {
    min-height: 0px !important;
}

.experience-buttons {
  display: flex;
  gap: 10px; /* Espaço entre os botões */
  flex-wrap: wrap; /* Quebrar para a próxima linha se não couberem */
  border-radius: 0.25rem;
  background: #FFF;
  justify-content: space-evenly; /* Alinhar os botões à esquerda */
  padding-top: 15px; /* Adicionar algum espaçamento ao redor dos botões */
  margin-left: 10px;
  margin-top: 10px;
  margin-right: 15px;
  color: var(--textos-cinza, #616167); /* Cor cinza para texto */
  white-space: wrap;
  cursor: pointer;
  font-size: 1rem; /* Tamanho da fonte menor */
  transition: background-color 0.3s, color 0.3s, width 0.3s;
  width: auto
}

.active-button,
.active-button:hover {
  font-weight: bold;
  color: #144ec0; /* Cor azul para o texto */
}
</style>
