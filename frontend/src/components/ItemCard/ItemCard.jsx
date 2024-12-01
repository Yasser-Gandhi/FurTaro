// src/components/ItemCard/ItemCard.jsx
import React from 'react';
import './ItemCard.css';
function ItemCard({ item, onClick }) {
  return (
    <div className="item-card" onClick={onClick}>
      <img src={item.image} alt={item.name} className="item-image" />
      <h3>{item.name}</h3>
      <p>{item.description}</p>
    </div>
  );
}
export default ItemCard;