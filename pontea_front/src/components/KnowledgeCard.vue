<template>
  <div class="my-card">
    <q-card class="card-content">
      <div class="title-overlay" v-tooltip="title">{{ truncatedTitle }}</div>
      <div class="text-card" :style="{ background: titleIconMap[title]?.color || '#FF7A92' }">
        <div class="icon">
          <img
            :src="`/../public/icons/${titleIconMap[title]?.icon}`"
            alt="image"
            class="logo-image"
          />
        </div>
        <div class="bottom-content">
          <div class="icon-bottom">
            <img src="/../public/icons/quantify.svg" alt="New Icon" class="new-icon" />
            <div class="number">{{ quantity }}</div>
          </div>
        </div>
      </div>
    </q-card>
  </div>
</template>


<script>
export default {
  name: 'KnowledgeCard',
  props: {
    title: String,
    quantity: Number,
  },
  computed: {
    truncatedTitle() {
      // Limita o título a duas linhas e adiciona "..." quando cortado
      const maxLineCount = 2;
      const maxTextLength = 40; // Tamanho máximo para duas linhas
      if (this.title.length <= maxTextLength) {
        return this.title;
      }
      const words = this.title.split(' ');
      let truncatedText = '';
      let lineCount = 0;
      for (const word of words) {
        if (truncatedText.length + word.length + 1 <= maxTextLength && lineCount < maxLineCount) {
          truncatedText += word + ' ';
        } else {
          break;
        }
      }
      if (truncatedText.trim() !== this.title.trim()) {
        truncatedText = truncatedText.trim() + '...';
      }
      return truncatedText;
    },
    // Mapeamento de títulos para ícones e cores
    titleIconMap() {
      return {
        'Escuta, fala, pensamento e imaginação': {
          icon: 'escuta.svg',
          color: '#FF7A92',
        },
        'Corpo, gestos e movimento': {
          icon: 'corpo.svg',
          color: '#FF8616',
        },
        'Espaços, tempo, quantidades, relações e transformações': {
          icon: 'espacos.svg',
          color: '#FECE25',
        },
        'Traços, sons, cores e formas': {
          icon: 'tracos.svg',
          color: '#14A5C0',
        },
        'O Eu, o outro e o nós': {
          icon: 'eu.svg',
          color: '#8CC640',
        }
      };
    },
  },
};
</script>


<style scoped>
.my-card {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: -2.5rem;
  align-self: stretch;
  background: var(--reas-bncc-rosa-2, #FF7A92); /* Manter o fundo rosa */
  box-shadow: 1px 1px 3px 0px rgba(0, 0, 0, 0.15);
  min-width: 10rem; /* Largura mínima do card */
  max-width: 16rem; /* Largura máxima do card */
  height: 13.5rem; /* Fixa a altura em 50% da altura da janela */
  aspect-ratio: 0.8 / 1; /* Proporção fixa entre largura e altura */
}

.card-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0;
  flex: 1;
  align-self: stretch;
  position: relative;
  overflow: hidden;
  padding: 0;
}

.title-overlay {
  position: absolute;
  top: 60%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 1.2rem;
  color: var(--textos-branco, #FBFDFF);
  text-align: center;
  font-size: 1rem;
  font-style: normal;
  font-weight: 500;
  line-height: 1.5rem; /* 150% */
}

.title-overlay:hover {
  white-space: normal;
  overflow: visible;
  text-overflow: initial;
}

.text-card {
  display: flex;
  flex-direction: column; /* Alterado para column */
  flex-wrap: nowrap;
  align-content: stretch;
  justify-content: space-between;
  align-items: center;
  background: var(--reas-bncc-rosa-2, #FF7A92);
  padding: 0.625rem;
  color: white;
  font-size: 1rem;
  flex: 1;
  width: 100%;
}

.q-card > div:not(:first-child),
.q-card > img:not(:first-child) {
  border-radius: 0rem 6.25rem;
}

.icon {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 4.48944rem;
}

.logo-image {
  max-height: 100%; /* Ocupará toda a altura disponível */
  max-width: 100%; /* Ocupará toda a largura disponível */
}

.bottom-content {
  display: flex;
  justify-content: space-between;
  align-items: center; /* Alterado para center */
  padding: 0.625rem;
}

.icon-bottom {
  display: flex;
  align-items: center;
  gap: 0.3125rem; /* Espaço entre o ícone e o número */
}

.new-icon {
  max-height: 100%;
  max-width: 100%;
}

.number {
  font-size: 1rem;
  color: var(--textos-branco, #FBFDFF);
  font-weight: 500;
}
</style>

