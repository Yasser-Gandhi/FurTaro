// src/pages/NotFound/NotFound.jsx
import React from 'react';
import { Link } from 'react-router-dom';
import './NotFound.css';

function NotFound() {
  return (
    <div className="not-found">
      <h1>Error 404</h1>
      <p>Página no encontrada.</p>
      <Link to="/">Volver al inicio</Link>
    </div>
  );
}

export default NotFound;
