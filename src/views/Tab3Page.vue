<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title class="large-centered-title">Form Input</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title class="large-centered-title">Form Input</ion-title>
        </ion-toolbar>
      </ion-header>

      <ion-list>
        <ion-item>
          <ion-input label="Nama Lengkap :" label-placement="floating" v-model="fullname"></ion-input>
        </ion-item>

        <ion-item>
          <ion-input label="Nama Panggilan :" label-placement="floating" v-model="nickname"></ion-input>
        </ion-item>

        <ion-item>
          <ion-label>Agama :</ion-label>
          <ion-select placeholder="Pilih agama" interface="popover" v-model="religion">
            <ion-select-option value="islam">Islam</ion-select-option>
            <ion-select-option value="kristen">Kristen</ion-select-option>
            <ion-select-option value="katolik">Katolik</ion-select-option>
            <ion-select-option value="buddha">Buddha  </ion-select-option>
            <ion-select-option value="hindu">Hindu</ion-select-option>
            <ion-select-option value="konghucu">Konghucu</ion-select-option>
          </ion-select>
        </ion-item>

        <ion-item>
          <ion-label>Jenis Kelamin :</ion-label>
          <ion-select placeholder="Pilih gender" interface="popover" v-model="gender">
            <ion-select-option value="laki">Laki-laki</ion-select-option>
            <ion-select-option value="perempuan">Perempuan</ion-select-option>
          </ion-select>
        </ion-item>

        <ion-item>
          <ion-textarea
            label="Alamat :"
            label-placement="floating"
            fill="outline"
            placeholder="Masukkan alamat lengkap"
            v-model="address">
          </ion-textarea>
        </ion-item>

        <ion-item lines="full">
          <ion-label>Hobby :</ion-label>
        </ion-item>
        <ion-radio-group v-model="hobby">
          <ion-item>
            <ion-label>Membaca</ion-label>
            <ion-radio value="membaca"></ion-radio>
          </ion-item>
          <ion-item>
            <ion-label>Olahraga</ion-label>
            <ion-radio value="olahraga"></ion-radio>
          </ion-item>
          <ion-item>
            <ion-label>Musik</ion-label>
            <ion-radio value="musik"></ion-radio>
          </ion-item>
        </ion-radio-group>

        <ion-item lines="full">
          <ion-label>Makanan Favorit :</ion-label>
        </ion-item>
        <ion-item v-for="food in makananOptions" :key="food">
          <ion-label>{{ food }}</ion-label>
          <ion-checkbox
            :checked="favoriteFoods.includes(food)"
            @ionChange="toggleFood(food, $event)"
            slot="end">
          </ion-checkbox>
        </ion-item>
      </ion-list>

      <ion-button expand="block" @click="submitForm">
        <ion-icon :icon="paperPlane" slot="start" />
        Kirim
      </ion-button>

      <div v-if="showData" class="ion-padding">
        <h3>Data Anda :</h3>
        <p><strong>Nama Lengkap :</strong> {{ fullname }}</p>
        <p><strong>Nama Panggilan :</strong> {{ nickname }}</p>
        <p><strong>Agama :</strong> {{ religion }}</p>
        <p><strong>Jenis Kelamin :</strong> {{ gender }}</p>
        <p><strong>Alamat :</strong> {{ address }}</p>
        <p><strong>Hobby :</strong> {{ hobby }}</p>
        <p><strong>Makanan Favorit :</strong> {{ favoriteFoods.join(', ') }}</p>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
  IonList, IonItem, IonInput, IonLabel, IonSelect, IonSelectOption,
  IonButton, IonIcon, IonTextarea, IonRadio, IonRadioGroup, IonCheckbox
} from '@ionic/vue';
import { paperPlane } from 'ionicons/icons';
import { ref } from 'vue';

const fullname = ref('');
const nickname = ref('');
const religion = ref('');
const gender = ref('');
const address = ref('');
const hobby = ref('');
const favoriteFoods = ref<string[]>([]);
const makananOptions = ['Nasi Goreng', 'Sate', 'Bakso', 'Mie Ayam', 'Rendang'];
const showData = ref(false);

const toggleFood = (food: string, ev: CustomEvent) => {
  if (ev.detail.checked) {
    if (!favoriteFoods.value.includes(food)) {
      favoriteFoods.value.push(food);
    }
  } else {
    favoriteFoods.value = favoriteFoods.value.filter(f => f !== food);
  }
};

const submitForm = () => {
  showData.value = true;
};
</script>

<style scoped>
.large-centered-title {
  width: 100%;
  text-align: center !important;
  display: flex !important;
  justify-content: center !important;
  font-size: 1.6rem;
}

ion-content {
  --background: linear-gradient(to bottom, #87ceeb 0%, #b0e0e6 100%);
  background-image:
    radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.7) 0%, transparent 70%),
    radial-gradient(circle at 80% 40%, rgba(255, 255, 255, 0.6) 0%, transparent 70%),
    radial-gradient(circle at 50% 70%, rgba(255, 255, 255, 0.5) 0%, transparent 70%);
  background-repeat: no-repeat;
  background-size: cover;
}

ion-radio::part(container) {
  width: 30px;
  height: 30px;
  border-radius: 8px;
  border: 2px solid #ddd;
}

ion-radio::part(mark) {
  background: none;
  transition: none;
  transform: none;
  border-radius: 0;
}

ion-radio.radio-checked::part(container) {
  background: #6815ec;
  border-color: transparent;
}

ion-radio.radio-checked::part(mark) {
  width: 6px;
  height: 10px;
  border-width: 0px 2px 2px 0px;
  border-style: solid;
  border-color: #fff;
  transform: rotate(45deg);
}

ion-button {
  margin-top: 12px;
  margin-bottom: 16px;
}
</style>
