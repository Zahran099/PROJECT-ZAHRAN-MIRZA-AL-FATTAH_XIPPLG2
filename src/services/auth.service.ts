import axios from 'axios';

const API_URL = 'http://localhost/server/auth.php';

// REGISTER USER
export const registerUser = async (username: string, password: string) => {
  const formData = new FormData();
  formData.append('action', 'register');
  formData.append('username', username);
  formData.append('password', password);

  const res = await axios.post(API_URL, formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
  return res.data;
};

// LOGIN USER
export const loginUser = async (username: string, password: string) => {
  const formData = new FormData();
  formData.append('action', 'login');
  formData.append('username', username);
  formData.append('password', password);

  const res = await axios.post(API_URL, formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });

  // ✅ Simpan user lengkap + token di localStorage
  if (res.data.success && res.data.token && res.data.user) {
    localStorage.setItem(
      'user',
      JSON.stringify({
        id: res.data.user.id,
        username: res.data.user.username,
        token: res.data.token,
      })
    );
  }

  return res.data;
};