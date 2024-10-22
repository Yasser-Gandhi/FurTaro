// src/utils/apiRoutes.js

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || '/api'; // Usa la variable de entorno

const fetchData = async (url) => {
    console.log(`Fetching: ${url}`);
    const response = await fetch(url);
    const data = await response.text(); // Cambia a text() para ver la respuesta
    console.log(data); // Muestra la respuesta en texto
    if (!response.ok) throw new Error(`Error: ${response.statusText}`);
    return JSON.parse(data); // Intenta parsear solo si es JSON
};

export const fetchPets = () => fetchData(`${API_BASE_URL}/pets`);
export const fetchPet = (id) => fetchData(`${API_BASE_URL}/pets/${id}`);
export const fetchShelters = () => fetchData(`${API_BASE_URL}/shelters`);
export const fetchShelter = (id) => fetchData(`${API_BASE_URL}/shelters/${id}`);
export const fetchUsers = () => fetchData(`${API_BASE_URL}/users`);
export const fetchUser = (id) => fetchData(`${API_BASE_URL}/users/${id}`);
export const fetchFavorites = () => fetchData(`${API_BASE_URL}/favorites`);
export const fetchFavorite = (id) => fetchData(`${API_BASE_URL}/favorites/${id}`);
export const fetchAdoptions = () => fetchData(`${API_BASE_URL}/adoptions`);
export const fetchAdoption = (id) => fetchData(`${API_BASE_URL}/adoptions/${id}`);
