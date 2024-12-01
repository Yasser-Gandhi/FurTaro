import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Header from './components/Header/Header';
import Footer from './components/Footer/Footer';
import ErrorBoundary from './components/ErrorBoundary';
import { FavoritesProvider } from './context/FavoritesContext'; // Importa el contexto
import { AuthProvider } from './context/AuthContext'; // Importa el contexto de autenticación

// Páginas de mascotas
import PetList from './pages/PetList/PetList';
import PetDetails from './pages/PetDetails/PetDetails';

// Páginas de refugios
import ShelterList from './pages/ShelterList/ShelterList';
import ShelterDetails from './pages/ShelterDetails/ShelterDetails';

// Páginas de adopciones
import Adoptions from './pages/Adoptions/Adoptions';

// Páginas de usuario
import MyFavorites from './pages/MyFavorites/MyFavorites';
import Login from './pages/Login/Login';
import SignUp from './pages/SignUp/SignUp';
import Dashboard from './pages/Dashboard/Dashboard';

// Página de error
import NotFound from './pages/NotFound/NotFound';

function App() {
  return (
    <ErrorBoundary>
      <AuthProvider> {/* Añadido AuthProvider */}
        <FavoritesProvider>
          <Router>
            <Header />
            <Routes>
              {/* Rutas de mascotas */}
              <Route path="/" element={<PetList />} />
              <Route path="/pets/:id" element={<PetDetails />} />

              {/* Rutas de refugios */}
              <Route path="/shelters" element={<ShelterList />} />
              <Route path="/shelters/:id" element={<ShelterDetails />} />

              {/* Rutas de adopciones */}
              <Route path="/adoptions" element={<Adoptions />} />

              {/* Rutas de usuario */}
              <Route path="/favorites" element={<MyFavorites />} />
              <Route path="/signup" element={<SignUp />} />
              <Route path="/login" element={<Login />} />
              <Route path="/dashboard" element={<Dashboard />} />

              {/* Ruta no encontrada */}
              <Route path="*" element={<NotFound />} />
            </Routes>
            <Footer />
          </Router>
        </FavoritesProvider>
      </AuthProvider>
    </ErrorBoundary>
  );
}

export default App;
