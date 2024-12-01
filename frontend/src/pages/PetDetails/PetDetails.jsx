import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import DetailCard from '../../components/DetailCard/DetailCard';
import { fetchPetById } from '../../services/apiService';
import { getPetImage } from '../../services/imageService';
import { useFavorites } from '../../context/FavoritesContext'; // Importa el contexto
import './PetDetails.css';

function PetDetails() {
  const { id } = useParams();
  const [pet, setPet] = useState(null);
  const [error, setError] = useState(null);
  const navigate = useNavigate();
  const { addToFavorites, removeFromFavorites, favorites } = useFavorites(); // Obtén las funciones y el estado del contexto

  useEffect(() => {
    const fetchPetDetails = async () => {
      try {
        const data = await fetchPetById(id);
        const image = await getPetImage(data.pet_id);
        setPet({ ...data, image }); // Combina los datos de la mascota con la imagen
      } catch (error) {
        console.error("Error fetching pet details:", error);
        setError("No se pudo cargar la información de la mascota.");
      }
    };

    fetchPetDetails();
  }, [id]);

  const handleFavoriteToggle = () => {
    const isFavorite = favorites.some((favorite) => favorite.pet_id === pet.pet_id);
    if (isFavorite) {
      removeFromFavorites(pet.pet_id); // Elimina de favoritos
    } else {
      addToFavorites(pet); // Añade a favoritos
    }
  };

  if (error) return <div>{error}</div>;
  if (!pet) return <div>Cargando...</div>;

  return (
    <div className="pet-details">
      <button className="back-button" style={{backgroundColor: 'red'}} onClick={() => navigate(-1)}>← Volver</button>
      <button onClick={handleFavoriteToggle}>
        {favorites.some((favorite) => favorite.pet_id === pet.pet_id) ? 'Eliminar de Favoritos' : 'Añadir a Favoritos'}
      </button>
      <DetailCard item={{
        image: pet.image || '',  
        name: pet.name,
        description: pet.description
      }} />
    </div>
  );
}

export default PetDetails;
