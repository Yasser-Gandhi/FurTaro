// src/components/PetList.jsx

import React, { useEffect, useState } from 'react';
import { fetchPets } from '../utils/apiRoutes';

const PetList = () => {
    const [pets, setPets] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        const getPets = async () => {
            try {
                const data = await fetchPets();
                setPets(data);
            } catch (err) {
                setError(err.message);
            }
        };
        getPets();
    }, []);

    if (error) return <div>Error: {error}</div>;

    return (
        <div>
            <h2>Lista de Mascotas</h2>
            <ul>
                {pets.map(pet => (
                    <li key={pet.pet_id}>
                        <strong>{pet.name} - {pet.species}</strong>
                        <ul>
                            <li>Edad: {pet.age}</li>
                            <li>¿Quién es tu próximo FurTaro?: {pet.description}</li>
                            <li>Refugio: {pet.shelter_id}</li>
                            <li>¿Está adoptado?: {pet.status}</li>
                        </ul>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default PetList;
