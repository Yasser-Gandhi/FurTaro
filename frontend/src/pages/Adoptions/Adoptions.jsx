import React, { useEffect, useState } from 'react';
import './Adoptions.css'; // Asegúrate de importar tu archivo CSS
import { getPetImage } from '../../services/imageService'; // Importa la función para obtener la imagen

function Adoptions() {
    const [adoptions, setAdoptions] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchAdoptionsData = async () => {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/adoptions');
                const data = await response.json();
                
                // Obtener imágenes para cada adopción
                const adoptionsWithImages = await Promise.all(
                    data.map(async (adoption) => {
                        const imageUrl = await getPetImage(adoption.pet_id); // Suponiendo que tienes un pet_id en cada adopción
                        return {
                            ...adoption,
                            image_url: imageUrl || adoption.image_url // Usar la imagen del servicio o la existente
                        };
                    })
                );

                setAdoptions(adoptionsWithImages);
            } catch (error) {
                console.error('Error al obtener las adopciones:', error);
            } finally {
                setLoading(false); // Cambiar el estado de carga al finalizar
            }
        };

        fetchAdoptionsData();
    }, []);

    return (
        <div className="adoptions-container">
            <h2 className="adoptions-title">Historias de Éxito en Adopciones</h2>
            {loading ? (
                <div className="loading">Cargando...</div>
            ) : adoptions.length > 0 ? (
                <div className="adoptions-grid">
                    {adoptions.map(adoption => (
                        <div key={adoption.adoption_id} className="adoption-card">
                            {adoption.image_url && (
                                <img 
                                    src={adoption.image_url} 
                                    alt={`Imagen de ${adoption.description}`} 
                                    className="adoption-image" 
                                />
                            )}
                            <div className="adoption-description">
                                {adoption.description}
                            </div>
                            <div className="adoption-details">
                                <span className="adopter-name">Adoptado por: {adoption.user.name}</span>
                                <span className="adoption-date">Fecha de adopción: {new Date(adoption.adoption_date).toLocaleDateString()}</span>
                            </div>
                        </div>
                    ))}
                </div>
            ) : (
                <div className="no-adoptions-container">No hay adopciones disponibles.</div>
            )}
        </div>
    );
}

export default Adoptions;
