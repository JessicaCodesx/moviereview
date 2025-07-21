namespace Models;

use Core\APIClient;

class Movie extends BaseModel {
    protected $table = 'movies';

    public function findByImdbId($imdbId) {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE imdb_id = ?");
        $stmt->execute([$imdbId]);
        return $stmt->fetch();
    }

    public function saveFromOMDB($movieData) {
        // Check if movie already exists
        $existing = $this->findByImdbId($movieData['imdbID']);

        if ($existing) {
            // Update existing movie
            $this->update($existing['id'], [
                'title' => $movieData['Title'],
                'year' => $movieData['Year'],
                'plot' => $movieData['Plot'],
                'poster' => $movieData['Poster'],
                'director' => $movieData['Director'],
                'actors' => $movieData['Actors'],
                'genre' => $movieData['Genre'],
                'runtime' => $movieData['Runtime'],
                'rating' => $movieData['imdbRating']
            ]);
            return $existing['id'];
        } else {
            // Create new movie
            return $this->create([
                'imdb_id' => $movieData['imdbID'],
                'title' => $movieData['Title'],
                'year' => $movieData['Year'],
                'plot' => $movieData['Plot'],
                'poster' => $movieData['Poster'],
                'director' => $movieData['Director'],
                'actors' => $movieData['Actors'],
                'genre' => $movieData['Genre'],
                'runtime' => $movieData['Runtime'],
                'rating' => $movieData['imdbRating']
            ]);
        }
    }

    public function getWithRatings($id) {
        $movie = $this->find($id);
        if ($movie) {
            $ratingModel = new Rating();
            $movie['ratings'] = $ratingModel->getAverageRating($id);
        }
        return $movie;
    }
}