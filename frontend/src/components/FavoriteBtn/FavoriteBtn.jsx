import React from 'react';

function FavoriteBtn({ pet_id, isFavorite, onAddToFavorites, onDeleteFromFavorites }) {
  return (
    <button onClick={() => isFavorite ? onDeleteFromFavorites(pet_id) : onAddToFavorites({ pet_id })}>
      {isFavorite ? 'Eliminar de Favoritos' : 'Agregar a Favoritos'}
    </button>
  );
}

export default FavoriteBtn;
