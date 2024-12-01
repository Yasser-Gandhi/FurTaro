import React, { useState } from 'react';
import { loginUser } from '../../services/apiService';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import './Login.css';

function Login() {
  const [credentials, setCredentials] = useState({
    email: '',
    password: ''
  });
  const { login } = useAuth();
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target; 
    setCredentials(prevCredentials => ({
      ...prevCredentials,
      [name]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await loginUser(credentials);
      
      // Verificación de respuesta antes de acceder a los datos
      if (response && response.user && response.token) {
        login(response.user, response.token);
        localStorage.setItem('userId', response.user.user_id); 
        navigate('/dashboard'); 
      } else {
        throw new Error('Invalid response structure');
      }
    } catch (error) {
      console.error('Error logging in:', error);
      alert('Error logging in. Please check your credentials.');
    }
  };

  const handleRegisterRedirect = () => {
    navigate('/signup');
  };

  const handleRecoverPassword = () => {
    navigate('/recover-password');
  };

  return (
    <div className="login">
      <h2>Acceder</h2>
      <form onSubmit={handleSubmit}>
        <label htmlFor="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value={credentials.email}
          onChange={handleChange}
          placeholder="Email"
          required
        />
        <label htmlFor="password">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          value={credentials.password}
          onChange={handleChange}
          placeholder="Contraseña"
          required
        />
        <button type="submit">Login</button>
      </form>
      <button onClick={handleRegisterRedirect}>Registrarse</button>
      <button onClick={handleRecoverPassword}>Recuperar contraseña</button>
    </div>
  );
}

export default Login;