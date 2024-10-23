// src/App.jsx
import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import PetList from './components/PetList';
import PetDetails from './components/PetDetails';
import './App.css';

const App = () => {
    return (
        <Router>
            <div className="app">
                <Routes>
                    <Route path="/" element={<PetList />} />
                    <Route path="/pet/:id" element={<PetDetails />} />
                </Routes>
            </div>
        </Router>
    );
};

export default App;
