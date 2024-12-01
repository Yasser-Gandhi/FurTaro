import React, { useEffect, useState } from 'react';
import { fetchUserProfile } from '../../services/apiService';
import { useAuth } from '../../context/AuthContext';
import { useNavigate } from 'react-router-dom';
import './Dashboard.css';

const Dashboard = () => {
  const [userProfile, setUserProfile] = useState(null);
  const [loading, setLoading] = useState(true);
  const { logout } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    const userId = localStorage.getItem('userId');

    const fetchProfile = async () => {
      if (userId) {
        try {
          const data = await fetchUserProfile(userId);
          console.log('Perfil de usuario recuperado con éxito:', data);
          setUserProfile(data);
        } catch (error) {
          console.error('¡Hubo un error al recuperar el perfil del usuario!', error);
        } finally {
          setLoading(false);
        }
      } else {
        console.error('No se encontró el ID de usuario en localStorage.');
        setLoading(false);
      }
    };

    fetchProfile();
  }, []);

  const clearUserId = () => {
    localStorage.removeItem('userId');
    setUserProfile(null);
  };

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <div className="dashboard">
      <h1>Tablero</h1>
      <button onClick={handleLogout}>Cerrar Sesión</button>
      <button onClick={clearUserId}>Eliminar Usuario</button>
      <div>
        <h2>Perfil del Usuario</h2>
        {loading ? (
          <p>Cargando perfil del usuario...</p>
        ) : userProfile ? (
          <div>
            <p><strong>Nombre:</strong> {userProfile.name}</p>
            <p><strong>Correo Electrónico:</strong> {userProfile.email}</p>
            <p><strong>Número de Teléfono:</strong> {userProfile.phone_number}</p>
            <p><strong>ID de Usuario:</strong> {userProfile.user_id}</p>
            <p><strong>Fecha de Registro:</strong> {new Date(userProfile.created_at).toLocaleString()}</p>
          </div>
        ) : (
          <p>No se pudo cargar el perfil del usuario.</p>
        )}
      </div>
    </div>
  );
};

export default Dashboard;
