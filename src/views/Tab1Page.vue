<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title class="title-background">Biodata Diri</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title class="title-background">Biodata Diri</ion-title>
        </ion-toolbar>
      </ion-header>

  <ion-card>
  <img alt="Silhouette of mountains" src="@/gambar/Zahran.jpg" />
</ion-card>

<ion-card>
    <ion-card-header>
      <ion-card-subtitle class="bold-subtitle">Zahran Mirza Al Fattah</ion-card-subtitle>
      <ion-card-title>Nama Lengkap</ion-card-title>
    </ion-card-header>
  </ion-card>

<ion-card>
    <ion-card-header>
      <ion-card-subtitle class="bold-subtitle">3091310105</ion-card-subtitle>
      <ion-card-title>NISN</ion-card-title>
    </ion-card-header>
  </ion-card>

  <ion-card>
    <ion-card-header>
      <ion-card-subtitle class="bold-subtitle">081345085280</ion-card-subtitle>
      <ion-card-title>No HP</ion-card-title>
    </ion-card-header>
  </ion-card>

  <ion-card>
    <ion-card-header>
      <ion-card-subtitle class="bold subtitle">Saya siswa SMK NEGERI 7 SAMARINDA Kelas XI PPLG 2, hobby saya adalah bermain badminton, cita cita saya adalah dokter dan saya juga meminati bidang Cyber Security</ion-card-subtitle>
      <ion-card-title>Hal Tentang Saya</ion-card-title>
    </ion-card-header>
  </ion-card>
  <div class="footer">
        Copyright &copy; Zahran Mirza Al Fattah.net 2009
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent } from '@ionic/vue';
import ExploreContainer from '@/components/ExploreContainer.vue';
</script>

<style scoped>
.title-background {
  background-color: white;
  padding: 12px 20px;
  border: 2px solid #ccc;
  border-radius: 8px;
  color: #000;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
}
ion-content::part(background) {
    background:  #228ed6;
  }

  ion-content::part(scroll) {
    color: #b6dceb;
  }
  ion-card {
    --background: #ffffff;
    --color: #000000;
  }

  ion-card-title {
    --color: #000000;
  }

  ion-card-subtitle {
    --color: #000000;
  }
  .footer {
  text-align: center;
  font-size: 0.9rem;
  color: #ffffff;
  padding: 20px 16px;
  margin-top: 40px;
  border-top: 1px solid #ddd;
}
</style>