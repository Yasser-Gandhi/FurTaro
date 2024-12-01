import React, { useState } from 'react';
import { signUpUser } from '../../services/apiService';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import './SignUp.css';

function SignUp() {
  const [userData, setUserData] = useState({
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
    phone_number: ''
  });
  
  const { login } = useAuth();
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setUserData((prevData) => ({
      ...prevData,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (userData.password !== userData.confirmPassword) {
      alert('Las contraseñas no coinciden.');
      return;
    }
    try {
      const response = await signUpUser(userData);
      console.log('Usuario registrado:', response);
      login(response.user, response.token);
      localStorage.setItem('userId', response.user.user_id); 
      alert('Registro exitoso.');
      navigate('/dashboard'); 
    } catch (error) {
      console.error('Error al registrar:', error);
      alert('Error al registrar. Verifica tus datos.');
    }
  };

  const handleLoginRedirect = () => {
    navigate('/login');
  };

  return (
    <div className="signup">
      <h2>Registrate</h2>
      <form onSubmit={handleSubmit}>
        <label htmlFor="name">Nombre</label>
        <input
          type="text"
          id="name"
          name="name"
          value={userData.name}
          onChange={handleChange}
          placeholder="Nombre"
          required
        />
        <label htmlFor="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value={userData.email}
          onChange={handleChange}
          placeholder="Email"
          required
        />
        <label htmlFor="password">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          value={userData.password}
          onChange={handleChange}
          placeholder="Contraseña"
          required
        />
        <label htmlFor="confirmPassword">Confirma tu contraseña</label>
        <input
          type="password"
          id="confirmPassword"
          name="confirmPassword"
          value={userData.confirmPassword}
          onChange={handleChange}
          placeholder="Confirma tu contraseña"
          required
        />
        <label htmlFor="phone_number">Número de teléfono</label>
        <input
          type="text"
          id="phone_number"
          name="phone_number"
          value={userData.phone_number}
          onChange={handleChange}
          placeholder="Número de teléfono"
          required
        />
        <button type="submit">Registrarse</button>
      </form>
      <button onClick={handleLoginRedirect}>Acceder</button>
    </div>
  );
}

export default SignUp;
