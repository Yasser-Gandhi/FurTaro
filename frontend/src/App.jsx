// src/App.jsx

import React from 'react';
import PetList from './components/PetList';
import ShelterList from './components/ShelterList';

const App = () => {
    return (
        <div>
            <h1>Aplicación de Mascotas</h1>
            <PetList />
            <ShelterList />
        </div>
    );
};

export default App;
