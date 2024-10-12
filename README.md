Aquí tienes el archivo `README.md` completo, incluyendo todas las configuraciones del backend y frontend:

```markdown
# FurTaro

## Descripción del Proyecto

FurTaro es una aplicación innovadora diseñada para facilitar la adopción de animales en situación de calle, promoviendo el cuidado responsable y la conexión emocional entre humanos y animales. La plataforma permite a los usuarios explorar, adoptar y cuidar de mascotas, mientras que fomenta la conciencia sobre el bienestar animal.

## Características Principales

- **Interfaz de Usuario Amigable:** Desarrollada con React, la aplicación ofrece una experiencia de usuario fluida y atractiva.
- **Gestión de Mascotas:** Los usuarios pueden ver información detallada sobre cada mascota disponible para adopción, incluyendo imágenes, descripciones y datos relevantes.
- **Formulario de Adopción:** Un proceso simplificado para que los usuarios puedan solicitar la adopción de mascotas.
- **Panel de Usuario:** Los usuarios registrados pueden gestionar sus solicitudes de adopción y favoritos.
- **API RESTful:** El backend está construido con Laravel, proporcionando un sistema robusto y seguro para manejar datos de usuarios y mascotas.

## Tecnologías Utilizadas

- **Frontend:** React, Redux Toolkit, Axios
- **Backend:** Laravel, MySQL
- **Autenticación:** Laravel Sanctum
- **Gestión de Imágenes:** Intervention Image
- **Pruebas:** Jest, React Testing Library

## Instalación

### Requisitos Previos

- PHP 8.0 o superior
- Composer
- Node.js y npm
- MySQL

### Clonar el Repositorio

```bash
git clone https://github.com/tu_usuario/FurTaro.git
cd FurTaro
```

### Configuración del Backend

1. Navega al directorio del backend:
   ```bash
   cd backend
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Configura el archivo `.env`:
   ```bash
   cp .env.example .env
   ```
   Luego, edita el archivo `.env` con tus credenciales de base de datos y otras configuraciones necesarias.

4. Genera la clave de aplicación:
   ```bash
   php artisan key:generate
   ```

5. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

6. Si deseas poblar la base de datos con datos de prueba, puedes ejecutar:
   ```bash
   php artisan db:seed
   ```

7. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

### Configuración del Frontend

1. Navega al directorio del frontend:
   ```bash
   cd ../frontend
   ```

2. Instala las dependencias de Node.js:
   ```bash
   npm install
   ```

3. Inicia la aplicación:
   ```bash
   npm start
   ```

4. Abre tu navegador y ve a `http://localhost:3000` para acceder a la aplicación.

## Uso

1. Abre tu navegador y ve a `http://localhost:3000` para acceder a la aplicación.
2. Explora las mascotas disponibles y completa el formulario de adopción para aquellas que te interesen.

## Contribuciones

Las contribuciones son bienvenidas. Si deseas contribuir al proyecto, por favor sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama para tu característica o corrección:
   ```bash
   git checkout -b feature/nueva-caracteristica
   ```
3. Realiza tus cambios y haz commit:
   ```bash
   git commit -m "Descripción de los cambios"
   ```
4. Envía tu rama:
   ```bash
   git push origin feature/nueva-caracteristica
   ```
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

## Contacto

Para más información, puedes contactar a [yasser.hernandez@udgvirtual.udg.mx](yasser.hernandez@udgvirtual.udg.mx).
```

Asegúrate de personalizar el nombre de usuario en el enlace de GitHub y cualquier otra información relevante antes de usarlo.
