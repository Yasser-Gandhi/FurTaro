// src/components/PetList.jsx
import React, { useEffect, useState } from 'react';
import { fetchPets, getPetImage } from '../utils/apiRoutes'; // Asegúrate de importar getPetImage
import { Link } from 'react-router-dom';

const PetList = () => {
    const [pets, setPets] = useState([]);
    const [error, setError] = useState(null);
    const [favorites, setFavorites] = useState(new Set());

    useEffect(() => {
        const loadPets = async () => {
            try {
                const data = await fetchPets();
                setPets(data);
            } catch (err) {
                setError(err.message);
            }
        };

        loadPets();
    }, []);

    const toggleFavorite = (petId) => {
        const newFavorites = new Set(favorites);
        if (newFavorites.has(petId)) {
            newFavorites.delete(petId);
        } else {
            newFavorites.add(petId);
        }
        setFavorites(newFavorites);
    };

    if (error) {
        return <div className="error">{error}</div>;
    }

    return (
        <div className="pet-list">
            <h1>Lista de Mascotas</h1>
            <ul className="pet-cards">
                {pets.map(pet => (
                    <li key={pet.pet_id} className="pet-card" onClick={() => window.location.href = `/pet/${pet.pet_id}`}>
                        <div className="image-container">
                            <img src={getPetImage()} alt={pet.name} className="pet-image" />
                            <button className="favorite-button" onClick={(e) => { e.stopPropagation(); toggleFavorite(pet.pet_id); }}>
                                {favorites.has(pet.pet_id) ? '❤️' : '🤍'}
                            </button>
                        </div>
                        <div className="pet-info">
                            <h2>{pet.name}</h2>
                            <p>Especie: {pet.species}</p>
                            <p>Edad: {pet.age}</p>
                            <p>{pet.description}</p>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default PetList;
