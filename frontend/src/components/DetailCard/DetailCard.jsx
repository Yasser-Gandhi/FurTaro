// src/components/DetailCard/DetailCard.jsx
import React from 'react';
import './DetailCard.css';

function DetailCard({ item }) {
  return (
    <div className="detail-card">
      <img src={item.image} alt={item.name} className="detail-image" />
      <div className="detail-content">
        <h2>{item.name}</h2>
        <p>{item.description}</p>
        {/* Añade más detalles según sea necesario */}
      </div>
    </div>
  );
}

export default DetailCard;
