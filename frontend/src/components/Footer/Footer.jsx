// src/components/Footer/Footer.jsx
import React from 'react';
import { Link } from 'react-router-dom';
import './Footer.css';
import adoptionIcon from '../../assets/dog-origami-paper-svgrepo-com.svg';

function Footer() {
  return (
    <footer className="footer">
      <Link to="/adoptions">
        <img src={adoptionIcon} alt="Adoptions" className="footer-icon" />
      </Link>
      <Link to="/shelters">
        Refugios
      </Link>
      <Link to="/favorites">
        Mis Favoritos
      </Link>
    </footer>
  );
}

export default Footer;
