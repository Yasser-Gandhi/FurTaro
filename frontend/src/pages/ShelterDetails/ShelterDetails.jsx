import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import DetailCard from '../../components/DetailCard/DetailCard';
import { fetchShelterById } from '../../services/apiService';
import { useFavorites } from '../../context/FavoritesContext'; // Importa el contexto
import './ShelterDetails.css';

function ShelterDetails() {
  const { id } = useParams();
  const [shelter, setShelter] = useState(null);
  const navigate = useNavigate();
  const { addToFavorites, removeFromFavorites, favorites } = useFavorites(); // Obtén las funciones y el estado del contexto

  useEffect(() => {
    const fetchShelterDetails = async () => {
      try {
        const data = await fetchShelterById(id);
        setShelter(data);
      } catch (error) {
        console.error("Error fetching shelter details:", error);
      }
    };

    fetchShelterDetails();
  }, [id]);

  const handleFavoriteToggle = () => {
    const isFavorite = favorites.some((favorite) => favorite.shelter_id === shelter.shelter_id);
    if (isFavorite) {
      removeFromFavorites(shelter.shelter_id); // Elimina de favoritos
    } else {
      addToFavorites(shelter); // Añade a favoritos
    }
  };

  if (!shelter) return <div>Cargando...</div>;

  return (
    <div className="shelter-details">
      <button className="back-button" onClick={() => navigate(-1)}>← Volver</button>
      <button onClick={handleFavoriteToggle}>
        {favorites.some((favorite) => favorite.shelter_id === shelter.shelter_id) ? 'Eliminar de Favoritos' : 'Añadir a Favoritos'}
      </button>
      <DetailCard item={{
        name: shelter.name,
        description: shelter.description,
        image: shelter.image_url
      }} />
      <div className="shelter-info">
        <h3>Información de contacto</h3>
        <p>Ubicación: {shelter.location}</p>
        <p>Teléfono: {shelter.phone}</p>
        <p>Email: {shelter.email}</p>
      </div>
    </div>
  );
}

export default ShelterDetails;
