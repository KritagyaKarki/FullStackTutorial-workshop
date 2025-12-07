const API_URL = 'http://localhost:3000/movies';
const movieListDiv = document.getElementById('movie-list');
const searchInput = document.getElementById('search-input');
const form = document.getElementById('add-movie-form');
let allMovies = [];

// render helper
function renderMovies(moviesToDisplay) {
  movieListDiv.innerHTML = '';
  if (moviesToDisplay.length === 0) {
    movieListDiv.innerHTML = '<p>No movies found matching your criteria.</p>';
    return;
  }
  moviesToDisplay.forEach(movie => {
    const movieElement = document.createElement('div');
    movieElement.classList.add('movie-item');
    movieElement.innerHTML = `
      <p><strong>${movie.title}</strong> (${movie.year}) - ${movie.genre}</p>
      <button onclick="editMoviePrompt(${movie.id}, '${movie.title}', ${movie.year}, '${movie.genre}')">Edit</button>
      <button onclick="deleteMovie(${movie.id})">Delete</button>
    `;
    movieListDiv.appendChild(movieElement);
  });
}

// READ (GET)
function fetchMovies() {
  fetch(API_URL)
    .then(res => res.json())
    .then(movies => {
      allMovies = movies;
      renderMovies(allMovies);
    })
    .catch(err => console.error('Error fetching movies:', err));
}
fetchMovies();

// SEARCH
searchInput.addEventListener('input', function() {
  const searchTerm = searchInput.value.toLowerCase();
  const filteredMovies = allMovies.filter(movie => {
    return movie.title.toLowerCase().includes(searchTerm) ||
           movie.genre.toLowerCase().includes(searchTerm);
  });
  renderMovies(filteredMovies);
});

// CREATE (POST)
form.addEventListener('submit', function(event) {
  event.preventDefault();
  const newMovie = {
    title: document.getElementById('title').value,
    genre: document.getElementById('genre').value,
    year: parseInt(document.getElementById('year').value)
  };
  fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(newMovie),
  })
  .then(response => {
    if (!response.ok) throw new Error('Failed to add movie');
    return response.json();
  })
  .then(() => {
    this.reset();
    fetchMovies();
  })
  .catch(err => console.error('Error adding movie:', err));
});

// UPDATE (PUT)
function editMoviePrompt(id, currentTitle, currentYear, currentGenre) {
  const newTitle = prompt('Enter new Title:', currentTitle);
  const newYearStr = prompt('Enter new Year:', currentYear);
  const newGenre = prompt('Enter new Genre:', currentGenre);
  if (newTitle && newYearStr && newGenre) {
    const updatedMovie = {
      id: id,
      title: newTitle,
      year: parseInt(newYearStr),
      genre: newGenre
    };
    updateMovie(id, updatedMovie);
  }
}

function updateMovie(movieId, updatedMovieData) {
  fetch(`${API_URL}/${movieId}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(updatedMovieData),
  })
  .then(res => {
    if (!res.ok) throw new Error('Failed to update movie');
    return res.json();
  })
  .then(() => fetchMovies())
  .catch(err => console.error('Error updating movie:', err));
}

// DELETE
function deleteMovie(movieId) {
  fetch(`${API_URL}/${movieId}`, { method: 'DELETE' })
    .then(res => {
      if (!res.ok) throw new Error('Failed to delete movie');
      fetchMovies();
    })
    .catch(err => console.error('Error deleting movie:', err));
}
