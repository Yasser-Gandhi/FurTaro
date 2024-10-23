// src/components/PetDetails.jsx
import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { fetchPetById, getPetImage } from '../utils/apiRoutes'; // Asegúrate de tener la función para obtener una mascota por ID

const PetDetails = () => {
    const { id } = useParams();
    const [pet, setPet] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        const loadPet = async () => {
            try {
                const data = await fetchPetById(id);
                setPet(data);
            } catch (err) {
                setError(err.message);
            }
        };

        loadPet();
    }, [id]);

    if (error) {
        return <div className="error">{error}</div>;
    }

    if (!pet) {
        return <div>Cargando...</div>;
    }

    return (
        <div className="pet-details">
            <h1>Detalles de {pet.name}</h1>
            <img src={getPetImage()} alt={pet.name} className="pet-image" />
            <p><strong>Especie:</strong> {pet.species}</p>
            <p><strong>Edad:</strong> {pet.age}</p>
            <p><strong>Descripción:</strong> {pet.description}</p>
            <p><strong>Raza:</strong> {pet.breed}</p>
            <p><strong>Sexo:</strong> {pet.gender}</p>
            <p><strong>Estado:</strong> {pet.status}</p>
            <Link to="/" className="back-link">Regresar a la lista de mascotas</Link>
        </div>
    );
};

export default PetDetails;
