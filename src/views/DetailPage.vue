<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Detail Game</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true" class="ion-padding">
      <div class="back-btn-container">
        <ion-button fill="solid" color="medium" shape="round" @click="router.back()">
           Kembali
        </ion-button>
      </div>

      <div v-if="game" class="game-card">
        <img :src="game.image" :alt="game.title" class="game-img"/>
        <h2 class="game-title">{{ game.title }}</h2>
        <p class="game-desc">{{ game.description }}</p>
      </div>

      <div v-else class="not-found">
        <ion-icon name="alert-circle-outline" size="large"></ion-icon>
        <p>Game tidak ditemukan.</p>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { 
  IonPage, IonHeader, IonToolbar, IonTitle, 
  IonContent, IonButton, IonIcon
} from '@ionic/vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const id = route.params.id as string;

const games: Record<string, { title: string; image: string; description: string }> = {
  "123": {
    title: "Pokémon Yellow",
    image: "src/gambar/Pokemon Yellow_.jpg",
    description: "Pokémon Yellow adalah versi khusus dari seri Pokémon generasi pertama. Bedanya dengan Pokémon Red/Blue, di sini pemain memulai dengan Pikachu sebagai partner, mirip dengan anime Pokémon. Pikachu selalu mengikuti pemain di luar Pokéball. Tujuan utama game ini adalah menjelajahi dunia Kanto, menangkap Pokémon, melatihnya, melawan Gym Leader, mengalahkan organisasi jahat Team Rocket, hingga menjadi Pokémon Champion."
  },
  "456": {
    title: "Mega Man X",
    image: "src/gambar/Mega man x.jpg",
    description: "Mega Man X adalah kelanjutan dari seri klasik Mega Man. Pemain mengendalikan X, robot pemburu Maverick (robot pemberontak) yang harus melawan delapan boss dengan senjata unik. Game ini terkenal dengan gameplay cepat, tingkat kesulitan menantang, serta fitur baru seperti dash, wall jump, dan armor upgrade yang membuat aksi lebih seru dibanding seri Mega Man klasik."
  },
  "789": {
    title: "The Legend of Zelda",
    image: "src/gambar/the legend of zelda.jpg",
    description: "Game ini adalah seri pertama dari franchise legendaris Zelda. Pemain mengendalikan Link, seorang pahlawan muda yang bertugas menyelamatkan Princess Zelda dan mengalahkan Ganon yang mencuri Triforce of Power. Gameplay-nya menggabungkan eksplorasi dunia luas, pemecahan puzzle di dungeon, dan pertarungan dengan berbagai musuh. Game ini dianggap sebagai salah satu pelopor game action-adventure open world."
  },
  "112": {
    title: "Pac-Man",
    image: "src/gambar/pac man.webp",
    description: "Pac-Man adalah salah satu game paling ikonik sepanjang masa. Pemain mengendalikan Pac-Man di dalam labirin, memakan titik-titik kecil (dot) sambil menghindari hantu (Blinky, Pinky, Inky, Clyde). Jika memakan Power Pellet, Pac-Man bisa berbalik mengejar dan memakan hantu untuk skor tambahan. Game ini sederhana tapi adiktif, dan menjadi simbol budaya pop di era 80-an."
  },
  "345": {
    title: "Super Mario World",
    image: "src/gambar/Super_Mario_World_Coverart.png",
    description: "Super Mario World adalah salah satu game platformer paling terkenal dari Nintendo. Pemain mengendalikan Mario (atau Luigi) dalam petualangan di Dinosaur Land untuk menyelamatkan Princess Peach dari Bowser. Game ini memperkenalkan karakter Yoshi, dinosaurus hijau yang bisa ditunggangi Mario. Dengan level beragam, rahasia tersembunyi, dan kontrol halus, game ini dianggap sebagai salah satu platformer terbaik sepanjang masa."
  }
};

const game = games[id];
</script>

<style scoped>
.back-btn-container {
  margin-bottom: 20px;
}

.game-card {
  background: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 6px 16px rgba(0,0,0,0.1);
  text-align: center;
  animation: fadeIn 0.4s ease;
}

.game-img {
  width: 100%;
  max-width: 280px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.game-title {
  font-size: 1.6rem;
  font-weight: bold;
  color: #1a1a1a;
  margin-bottom: 12px;
}

.game-desc {
  font-size: 1rem;
  line-height: 1.6;
  color: #444;
  text-align: justify;
}

.not-found {
  padding: 40px;
  text-align: center;
  color: #888;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
