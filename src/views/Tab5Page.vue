<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Data Posts</ion-title>
        <ion-buttons slot="end">
          <ion-button color="light" @click="logout">
            Logout
          </ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">
      <!-- Form Tambah / Edit Post -->
      <ion-card>
        <ion-card-header>
          <ion-card-title>
            {{ editingPost ? 'Edit Post' : 'Tambah Post' }}
          </ion-card-title>
        </ion-card-header>

        <ion-card-content>
          <ion-item>
            <ion-label position="stacked">Judul</ion-label>
            <ion-input v-model="form.title" placeholder="Masukkan judul"></ion-input>
          </ion-item>

          <ion-item>
            <ion-label position="stacked">Isi</ion-label>
            <ion-textarea v-model="form.body" placeholder="Masukkan isi"></ion-textarea>
          </ion-item>

          <ion-button expand="block" color="success" @click="savePost">
            {{ editingPost ? 'Update' : 'Tambah' }}
          </ion-button>

          <ion-button
            v-if="editingPost"
            expand="block"
            color="medium"
            fill="outline"
            @click="cancelEdit"
          >
            Batal Edit
          </ion-button>
        </ion-card-content>
      </ion-card>

      <!-- Daftar Post -->
      <ion-card v-for="post in posts" :key="post.id">
        <ion-card-header>
          <ion-card-title>{{ post.title }}</ion-card-title>
        </ion-card-header>
        <ion-card-content>
          <p>{{ post.body }}</p>
          <ion-button size="small" color="warning" @click="editPost(post)">Edit</ion-button>
          <ion-button size="small" color="danger" @click="removePost(post.id)">Hapus</ion-button>
        </ion-card-content>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import {
  IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
  IonCard, IonCardHeader, IonCardTitle, IonCardContent,
  IonItem, IonLabel, IonInput, IonTextarea, IonButton, IonButtons
} from '@ionic/vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default defineComponent({
  name: 'Tab5Page',
  components: {
    IonPage, IonHeader, IonToolbar, IonTitle, IonContent,
    IonCard, IonCardHeader, IonCardTitle, IonCardContent,
    IonItem, IonLabel, IonInput, IonTextarea, IonButton, IonButtons
  },
  setup() {
    const router = useRouter();
    const posts = ref<any[]>([]);
    const form = ref({ title: '', body: '' });
    const editingPost = ref<number | null>(null);
    const API_URL = 'http://localhost/server/api.php';

    // bagian dalam setup()
const getToken = () => {
  const userData = localStorage.getItem('user');
  if (!userData) {
    router.push('/tabauth');
    return null;
  }
  try {
    const user = JSON.parse(userData);
    return user.token || null;
  } catch {
    router.push('/tabauth');
    return null;
  }
};

    // 🔹 Ambil semua post
    const loadPosts = async () => {
      const token = getToken();
      if (!token) return;

      try {
        const res = await axios.get(API_URL, {
          headers: { Authorization: `Bearer ${token}` }
        });
        posts.value = res.data.posts || [];
      } catch (err) {
        console.error('Gagal memuat data:', err);
      }
    };

    // 🔹 Simpan / Update post
    const savePost = async () => {
      const token = getToken();
      if (!token) return;

      if (!form.value.title || !form.value.body) {
        alert('Judul dan isi wajib diisi');
        return;
      }

      try {
        if (editingPost.value) {
          // Update post
          const res = await axios.put(`${API_URL}?id=${editingPost.value}`, form.value, {
            headers: { Authorization: `Bearer ${token}` }
          });
          if (res.data.success) {
            alert(res.data.message);
            await loadPosts();
            cancelEdit();
          } else {
            alert(res.data.error || 'Gagal update');
          }
        } else {
          // Tambah post
          const res = await axios.post(API_URL, form.value, {
            headers: { Authorization: `Bearer ${token}` }
          });
          if (res.data.success) {
            alert(res.data.message);
            form.value = { title: '', body: '' };
            await loadPosts();
          } else {
            alert(res.data.error || 'Gagal menambah');
          }
        }
      } catch (err) {
        console.error('Gagal menyimpan:', err);
      }
    };

    // 🔹 Edit post
    const editPost = (post: any) => {
      form.value = { title: post.title, body: post.body };
      editingPost.value = post.id;
    };

    // 🔹 Batal edit
    const cancelEdit = () => {
      form.value = { title: '', body: '' };
      editingPost.value = null;
    };

    // 🔹 Hapus post
    const removePost = async (id: number) => {
      const token = getToken();
      if (!token) return;
      if (!confirm('Yakin mau hapus post ini?')) return;

      try {
        const res = await axios.delete(`${API_URL}?id=${id}`, {
          headers: { Authorization: `Bearer ${token}` }
        });
        if (res.data.success) {
          alert(res.data.message);
          posts.value = posts.value.filter(p => p.id !== id);
        } else {
          alert(res.data.error || 'Gagal menghapus');
        }
      } catch (err) {
        console.error('Gagal menghapus:', err);
      }
    };

    // 🔒 Logout user
    const logout = () => {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      router.push('/tabauth');
    };

    onMounted(loadPosts);

    return {
      posts,
      form,
      editingPost,
      savePost,
      editPost,
      cancelEdit,
      removePost,
      logout
    };
  }
});
</script>

<style scoped>
ion-card {
  margin-bottom: 16px;
}
</style>