// src/components/PetDetail.jsx

import React, { useEffect, useState } from 'react';
import { fetchPet } from '../utils/apiRoutes';

const PetDetail = ({ petId }) => {
    const [pet, setPet] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        const getPet = async () => {
            try {
                const data = await fetchPet(petId);
                setPet(data);
            } catch (err) {
                setError(err.message);
            }
        };
        getPet();
    }, [petId]);

    if (error) return <div>Error: {error}</div>;
    if (!pet) return <div>Cargando...</div>;

    return (
        <div>
            <h2>{pet.name}</h2>
            <p>Especie: {pet.species}</p>
            <p>Edad: {pet.age}</p>
            <p>Descripción: {pet.description}</p>
        </div>
    );
};

export default PetDetail;
