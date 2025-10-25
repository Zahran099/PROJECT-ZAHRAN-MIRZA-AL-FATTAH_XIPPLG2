<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Autentikasi</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">
      <ion-card>
        <ion-card-header>
          <ion-card-title>{{ mode === 'login' ? 'Login' : 'Register' }}</ion-card-title>
        </ion-card-header>

        <ion-card-content>
          <ion-item>
            <ion-label position="stacked">Username</ion-label>
            <ion-input v-model="username" placeholder="Masukkan username"></ion-input>
          </ion-item>

          <ion-item>
            <ion-label position="stacked">Password</ion-label>
            <ion-input type="password" v-model="password" placeholder="Masukkan password"></ion-input>
          </ion-item>

          <ion-button expand="block" color="primary" @click="submit">
            {{ mode === 'login' ? 'Login' : 'Daftar' }}
          </ion-button>

          <ion-button expand="block" fill="clear" @click="toggleMode">
            {{ mode === 'login' ? 'Belum punya akun? Register' : 'Sudah punya akun? Login' }}
          </ion-button>
        </ion-card-content>
      </ion-card>

      <p v-if="message" class="ion-text-center">{{ message }}</p>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent, ref, nextTick } from 'vue';
import {
  IonPage, IonHeader, IonToolbar, IonTitle,
  IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent,
  IonItem, IonLabel, IonInput, IonButton
} from '@ionic/vue';
import { useRouter } from 'vue-router';
import { loginUser, registerUser } from '@/services/auth.service';

export default defineComponent({
  components: {
    IonPage, IonHeader, IonToolbar, IonTitle,
    IonContent, IonCard, IonCardHeader, IonCardTitle, IonCardContent,
    IonItem, IonLabel, IonInput, IonButton
  },
  setup() {
    const router = useRouter();
    const username = ref('');
    const password = ref('');
    const mode = ref<'login' | 'register'>('login');
    const message = ref('');

    const submit = async () => {
      if (!username.value || !password.value) {
        message.value = 'Username dan password wajib diisi!';
        return;
      }

      try {
        if (mode.value === 'login') {
          const data = await loginUser(username.value, password.value);
          if (data.success && data.user && data.token) {
            localStorage.setItem('user', JSON.stringify({
              id: data.user.id,
              username: data.user.username,
              token: data.token
            }));
            message.value = 'Login berhasil!';
            await nextTick(); // ✅ memastikan token tersimpan sebelum pindah halaman
            router.push('/tabs/tab5');
          } else {
            message.value = data.error || 'Login gagal';
          }
        } else {
          const data = await registerUser(username.value, password.value);
          if (data.success) {
            message.value = 'Registrasi berhasil! Silakan login.';
            mode.value = 'login';
          } else {
            message.value = data.error || 'Registrasi gagal';
          }
        }
      } catch (error: any) {
        console.error(error);
        message.value = 'Terjadi kesalahan koneksi ke server.';
      }
    };

    const toggleMode = () => {
      mode.value = mode.value === 'login' ? 'register' : 'login';
      message.value = '';
    };

    return { username, password, mode, message, submit, toggleMode };
  }
});
</script>

<style scoped>
p {
  margin-top: 12px;
  color: var(--ion-color-danger);
}
</style>