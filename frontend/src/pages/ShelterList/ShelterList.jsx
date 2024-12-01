import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import ItemCard from '../../components/ItemCard/ItemCard';
import { fetchShelters } from '../../services/apiService';
import { getPetImage } from '../../services/imageService'; 
import { useFavorites } from '../../context/FavoritesContext'; // Importa el contexto
import './ShelterList.css';

function ShelterList() {
  const [shelters, setShelters] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();
  const { addToFavorites, favorites } = useFavorites(); // Obtén las funciones y el estado del contexto

  useEffect(() => {
    const fetchSheltersData = async () => {
      try {
        const data = await fetchShelters();
        const sheltersWithImages = await Promise.all(
          data.map(async (shelter) => {
            const imageUrl = await getPetImage(shelter.shelter_id);
            return {
              ...shelter,
              image_url: imageUrl || shelter.image_url
            };
          })
        );
        setShelters(sheltersWithImages);
      } catch (error) {
        console.error("Error fetching shelters:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchSheltersData();
  }, []);

  const handleCardClick = (id) => {
    navigate(`/shelters/${id}`);
  };

  const handleAddToFavorites = (shelter) => {
    addToFavorites(shelter); // Agrega la función para añadir a favoritos
  };

  return (
    <div className="shelter-list">
      {loading ? (
        <div className="loading">Cargando refugios...</div>
      ) : (
        shelters.map(shelter => (
          <ItemCard
            key={shelter.shelter_id}
            item={{
              name: shelter.name,
              description: shelter.location,
              image: shelter.image_url
            }}
            onClick={() => handleCardClick(shelter.shelter_id)}
            onAddToFavorites={() => handleAddToFavorites(shelter)} // Añadir a favoritos
            isFavorite={favorites.some((favorite) => favorite.shelter_id === shelter.shelter_id)} // Verifica si es favorito
          />
        ))
      )}
    </div>
  );
}

export default ShelterList;
