<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>List Game</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">List Game</ion-title>
        </ion-toolbar>
      </ion-header>

      <ion-list>
        <ion-item button @click="() => router.push('/tabs/detail/123')">
          <ion-label>Pokémon Yellow</ion-label>
        </ion-item>
        <ion-item button @click="() => router.push('/tabs/detail/456')">
          <ion-label>Mega Man X</ion-label>
        </ion-item>
        <ion-item button @click="() => router.push('/tabs/detail/789')">
          <ion-label>The Legend of Zelda</ion-label>
        </ion-item>
        <ion-item button @click="() => router.push('/tabs/detail/112')">
          <ion-label>Pac-Man</ion-label>
        </ion-item>
        <ion-item button @click="() => router.push('/tabs/detail/345')">
          <ion-label>Super Mario World</ion-label>
        </ion-item>
      </ion-list>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { 
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent, 
  IonItem, IonLabel, IonList 
} from '@ionic/vue';
import { useRouter } from 'vue-router';

const router = useRouter();
</script>
