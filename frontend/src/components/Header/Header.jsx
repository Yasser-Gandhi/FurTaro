// src/components/Header/Header.jsx
import React from 'react';
import { Link } from 'react-router-dom';
import './Header.css';
import logo from '../../assets/cat-origami-paper-svgrepo-com.svg';

function Header() {
  return (
    <header className="header">
      <Link to="/" className="logo-container">
        <img src={logo} alt="FurTaro" className="logo" />
        <span className="brand-name">FurTaro</span>
      </Link>
      <nav>
        <Link to="/signup" className="signup-button">Registrarse</Link>
      </nav>
    </header>
  );
}

export default Header;
