import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import ItemCard from '../../components/ItemCard/ItemCard';
import { fetchFavorites, fetchPets } from '../../services/apiService';
import { getPetImage } from '../../services/imageService';
import { useFavorites } from '../../context/FavoritesContext'; // Importa el contexto
import './MyFavorites.css';

function MyFavorites() {
  const [favorites, setFavorites] = useState([]);
  const [recommendedPets, setRecommendedPets] = useState([]);
  const { addToFavorites, removeFromFavorites } = useFavorites(); // Obtén las funciones del contexto
  const userId = localStorage.getItem('userId');

  useEffect(() => {
    const loadFavorites = async () => {
      try {
        const data = userId ? await fetchFavorites(userId) : JSON.parse(localStorage.getItem('favorites')) || [];
        setFavorites(data);
      } catch (error) {
        console.error("Error loading favorites:", error);
      }
    };
    loadFavorites();
  }, [userId]);

  useEffect(() => {
    const fetchRecommendedPets = async () => {
      const petsData = await fetchPets();
      const randomPets = petsData.sort(() => 0.5 - Math.random()).slice(0, 3);
      const petsWithImages = await Promise.all(
        randomPets.map(async (pet) => ({
          ...pet,
          image: await getPetImage(pet.pet_id),
        }))
      );
      setRecommendedPets(petsWithImages);
    };
    fetchRecommendedPets();
  }, []);

  const handleDeleteFavorite = (petId) => {
    removeFromFavorites(petId); // Elimina de favoritos
    setFavorites((prev) => prev.filter((fav) => fav.pet_id !== petId)); // Actualiza la lista de favoritos
  };

  return (
    <div className="favorites-list">
      <h2>Mis Favoritos</h2>
      {favorites.length === 0 ? (
        <div>
          <p>No tienes mascotas favoritas aún.</p>
          {recommendedPets.length > 0 && (
            <div>
              <h3>Te podrían interesar estas mascotas:</h3>
              <div className="recommended-pets">
                {recommendedPets.map((pet) => (
                  <ItemCard
                    key={pet.pet_id}
                    {...pet}
                    onAddToFavorites={() => addToFavorites(pet)} // Añadir a favoritos
                    image={pet.image}
                  />
                ))}
              </div>
            </div>
          )}
        </div>
      ) : (
        favorites.map((fav) => (
          <ItemCard
            key={fav.pet_id}
            {...fav}
            onDeleteFromFavorites={() => handleDeleteFavorite(fav.pet_id)} // Eliminar de favoritos
            isFavorite
            image={fav.image}
          />
        ))
      )}
    </div>
  );
}

export default MyFavorites;
