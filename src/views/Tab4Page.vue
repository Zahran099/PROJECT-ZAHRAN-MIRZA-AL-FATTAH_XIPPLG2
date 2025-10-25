<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Reusable Component</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Reusable Component</ion-title>
        </ion-toolbar>
      </ion-header>

      <custom-card 
        title="Belajar Vue + Ionic"
        subtitle="Reusable Component"
        content="Ini adalah contoh penggunaan reusable component. Satu komponen bisa dipakai berulang kali dengan isi berbeda." 
      />

      <custom-card 
        title="Inspirasi Hari Ini"
        subtitle="Motivasi"
      >
        <p>
          Jangan takut gagal, karena dari kegagalan kita belajar cara untuk berhasil.
        </p>
      </custom-card>

      <custom-card 
        title="Kontak Saya"
        subtitle="Developer"
      >
        <ion-button expand="block" color="primary">Hubungi Saya</ion-button>
      </custom-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonButton } from '@ionic/vue';
import CustomCard from '@/components/CustomCard.vue';
</script>
