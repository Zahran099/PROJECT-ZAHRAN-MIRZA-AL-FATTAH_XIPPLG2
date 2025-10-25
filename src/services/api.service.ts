import axios from 'axios';

const API_URL = 'http://localhost/server/api.php';

// 🔹 Helper untuk ambil token dari localStorage
function getAuthToken(): string | null {
  const userData = localStorage.getItem('user');
  if (!userData) return null;
  try {
    const user = JSON.parse(userData);
    return user.token || null;
  } catch {
    return null;
  }
}

// 🔹 Axios instance dengan interceptor
const api = axios.create({
  baseURL: API_URL,
  headers: { 'Content-Type': 'application/json' },
});

// Tambahkan Authorization token otomatis di setiap request
api.interceptors.request.use(
  (config) => {
    const token = getAuthToken();
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  (error) => Promise.reject(error)
);

// Tangani token invalid atau expired
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      alert('Sesi login telah habis. Silakan login ulang.');
      localStorage.removeItem('user');
      window.location.href = '/tabauth';
    }
    return Promise.reject(error);
  }
);

// ===============================
//  CRUD FUNCTION UNTUK POST
// ===============================

// 🔹 Ambil semua post milik user login
export async function getPosts() {
  const res = await api.get('');
  return res.data.posts || [];
}

// 🔹 Tambah post baru
export async function createPost(data: any) {
  const res = await api.post('', data);
  return res.data;
}

// 🔹 Update post
export async function updatePost(id: number, data: any) {
  const res = await api.put(`?id=${id}`, data);
  return res.data;
}

// 🔹 Hapus post
export async function deletePost(id: number) {
  const res = await api.delete(`?id=${id}`);
  return res.data;
}

export default api;