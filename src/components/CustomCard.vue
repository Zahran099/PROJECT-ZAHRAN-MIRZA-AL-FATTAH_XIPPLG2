<template>
  <ion-card>
    <ion-card-header>
      <ion-card-title>{{ title }}</ion-card-title>
      <ion-card-subtitle>{{ subtitle }}</ion-card-subtitle>
    </ion-card-header>
    <ion-card-content>
      <slot>
        {{ content }}
      </slot>
    </ion-card-content>
  </ion-card>
</template>

<script setup lang="ts">
import { IonCard, IonCardHeader, IonCardTitle, IonCardSubtitle, IonCardContent } from '@ionic/vue';

defineProps<{
  title: string;
  subtitle?: string;
  content?: string;
}>();
</script>

<style scoped>
ion-card {
  --background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  margin: 16px;
  transition: transform 0.2s ease;
}
ion-card:hover {
  transform: scale(1.02);
}
ion-card-title {
  font-size: 1.2rem;
  font-weight: bold;
}
ion-card-subtitle {
  color: #666;
  font-size: 0.9rem;
}
</style>
