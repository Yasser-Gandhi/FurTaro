const fetchImageFromDatabase = async (petId) => {
  try {
    const response = await fetch(`/api/pets/${petId}/image`);
    
    // Verifica si la respuesta es correcta
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const text = await response.text(); // Obtiene la respuesta como texto
    console.log("Response text:", text); // Muestra el contenido de la respuesta

    // Intenta parsear el texto como JSON
    try {
      const data = JSON.parse(text);
      return data.imageUrl || null; // Retorna la URL de la imagen o null
    } catch (jsonError) {
      console.error("Error parsing JSON:", jsonError);
      return null; // Retorna null si hay un error al parsear
    }
  } catch (error) {
    console.error("Error fetching image from database:", error);
    return null; // Retorna null si hay un error
  }
};

// Función para obtener una imagen aleatoria de la API
const fetchRandomImage = () => {
  const width = 800;
  const height = 700;
  return `https://place.dog/${width}/${height}`; // URL de imagen aleatoria de perros
};

// Función principal para obtener la imagen
export const getPetImage = async (petId) => {
  const imageFromDB = await fetchImageFromDatabase(petId);
  return imageFromDB || fetchRandomImage(); // Retorna la imagen de la base de datos o una aleatoria
};