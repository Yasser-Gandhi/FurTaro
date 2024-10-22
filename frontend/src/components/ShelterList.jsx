// src/components/ShelterList.jsx

import React, { useEffect, useState } from 'react';
import { fetchShelters } from '../utils/apiRoutes';

const ShelterList = () => {
    const [shelters, setShelters] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        const getShelters = async () => {
            try {
                const data = await fetchShelters();
                setShelters(data);
            } catch (err) {
                setError(err.message);
            }
        };
        getShelters();
    }, []);

    if (error) return <div>Error: {error}</div>;

    return (
        <div>
            <h2>Lista de Refugios</h2>
            <ul>
                {shelters.map(shelter => (
                    <li key={shelter.shelter_id}>
                        <div>
                            <strong>{shelter.name}</strong>
                            <p>Dirección: {shelter.location}</p>
                            <p>Teléfono: {shelter.phone_number}</p>
                            <p>Correo: {shelter.email}</p>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ShelterList;
