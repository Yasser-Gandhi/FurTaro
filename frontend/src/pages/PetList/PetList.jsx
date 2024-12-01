import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import ItemCard from '../../components/ItemCard/ItemCard';
import { fetchPets } from '../../services/apiService';
import { getPetImage } from '../../services/imageService'; 
import { useFavorites } from '../../context/FavoritesContext'; // Importa el contexto
import './PetList.css';

function PetList() {
  const [pets, setPets] = useState([]);
  const navigate = useNavigate();
  const { addToFavorites, favorites } = useFavorites(); // Obtén las funciones y el estado del contexto

  useEffect(() => {
    const fetchPetsWithImages = async () => {
      try {
        const data = await fetchPets();
        const petsWithImages = await Promise.all(data.map(async (pet) => ({
          ...pet,
          image: await getPetImage(pet.pet_id) // Espera a que se obtenga la imagen
        })));
        setPets(petsWithImages);
      } catch (error) {
        console.error("Error fetching pets:", error);
      }
    };

    fetchPetsWithImages();
  }, []);

  const handleCardClick = (id) => {
    navigate(`/pets/${id}`);
  };

  const handleFavoriteToggle = (pet) => {
    const isFavorite = favorites.some((favorite) => favorite.pet_id === pet.pet_id);
    if (isFavorite) {
      // Aquí puedes implementar la lógica para eliminar de favoritos si es necesario
    } else {
      addToFavorites(pet);
    }
  };

  return (
    <div className="pet-list">
      {pets.map(pet => (
        <ItemCard
          key={pet.pet_id}
          item={{
            image: pet.image,
            name: pet.name,
            description: pet.species
          }}
          onClick={() => handleCardClick(pet.pet_id)}
          onFavoriteToggle={() => handleFavoriteToggle(pet)} // Agrega la función de favoritos
          isFavorite={favorites.some((favorite) => favorite.pet_id === pet.pet_id)} // Verifica si es favorito
        />
      ))}
    </div>
  );
}

export default PetList;
