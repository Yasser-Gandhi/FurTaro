const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || '/api';

// Función genérica para realizar peticiones
const fetchData = async (url, options = {}) => {
  try {
    const response = await fetch(url, options);

    if (!response.ok) {
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
        const errorData = await response.json();
        throw new Error(errorData.message || `Error ${response.status}: ${response.statusText}`);
      } else {
        throw new Error(`Error ${response.status}: ${response.statusText}`);
      }
    }

    return await response.json();
  } catch (error) {
    console.error(`Fetch error in ${url}:`, error);
    throw error;
  }
};

// Función para agregar token de autenticación
export const setAuthToken = (token) => {
  if (token) {
    localStorage.setItem('token', token);
  } else {
    localStorage.removeItem('token');
  }
};

// Función para obtener headers con token
const getAuthHeaders = () => {
  const token = localStorage.getItem('token');
  return token ? { 'Authorization': `Bearer ${token}` } : {};
};

// Funciones de autenticación
export const loginUser = (credentials) =>
  fetchData(`${API_BASE_URL}/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify(credentials),
  });

export const signUpUser = (userData) =>
  fetchData(`${API_BASE_URL}/register`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify(userData),
  });

// Funciones de CRUD para recursos
export const fetchPets = () => fetchData(`${API_BASE_URL}/pets`);
export const fetchPetById = (id) => fetchData(`${API_BASE_URL}/pets/${id}`);
export const fetchShelters = () => fetchData(`${API_BASE_URL}/shelters`);
export const fetchShelterById = (id) => fetchData(`${API_BASE_URL}/shelters/${id}`);
export const fetchAdoptions = () => fetchData(`${API_BASE_URL}/adoptions`);
export const fetchAdoptionById = (id) => fetchData(`${API_BASE_URL}/adoptions/${id}`);

// Funciones para manejar favoritos
export const fetchFavorites = (userId = null) => {
  const url = userId ? `${API_BASE_URL}/users/${userId}/favorites` : `${API_BASE_URL}/favorites`;
  return fetchData(url, {
    headers: getAuthHeaders(),
  });
};

export const saveFavorite = (userId, petId) =>
  fetchData(`${API_BASE_URL}/users/${userId}/favorites`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      ...getAuthHeaders(),
    },
    body: JSON.stringify({ pet_id: petId }),
  });

export const deleteFavorite = (userId, petId) =>
  fetchData(`${API_BASE_URL}/users/${userId}/favorites/${petId}`, {
    method: 'DELETE',
    headers: getAuthHeaders(),
  });

// Funciones de perfil de usuario
export const fetchUserProfile = (userId) =>
  fetchData(`${API_BASE_URL}/users/${userId}`, {
    headers: getAuthHeaders(),
  });

export const updateUserProfile = (userId, userData) =>
  fetchData(`${API_BASE_URL}/users/${userId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      ...getAuthHeaders(),
    },
    body: JSON.stringify(userData),
  });

// Exportar todas las funciones
export default {
  fetchData,
  loginUser,
  signUpUser,
  fetchPets,
  fetchPetById,
  fetchShelters,
  fetchShelterById,
  fetchAdoptions,
  fetchAdoptionById,
  fetchFavorites,
  saveFavorite,
  deleteFavorite,
  fetchUserProfile,
  updateUserProfile,
  setAuthToken,
};
