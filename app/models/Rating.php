
namespace Models;

class Rating extends BaseModel {
    protected $table = 'ratings';

    public function addRating($movieId, $rating, $userIP) {
        try {
            // Try to insert new rating
            return $this->create([
                'movie_id' => $movieId,
                'rating' => $rating,
                'user_ip' => $userIP
            ]);
        } catch (\PDOException $e) {
            // If duplicate, update existing rating
            if ($e->getCode() == 23000) { // Integrity constraint violation
                $stmt = $this->db->prepare("UPDATE ratings SET rating = ? WHERE movie_id = ? AND user_ip = ?");
                return $stmt->execute([$rating, $movieId, $userIP]);
            }
            throw $e;
        }
    }

    public function getAverageRating($movieId) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as average, COUNT(*) as count FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch();

        return [
            'average' => round($result['average'] ?? 0, 1),
            'count' => (int)($result['count'] ?? 0)
        ];
    }

    public function getUserRating($movieId, $userIP) {
        $stmt = $this->db->prepare("SELECT rating FROM ratings WHERE movie_id = ? AND user_ip = ?");
        $stmt->execute([$movieId, $userIP]);
        $result = $stmt->fetch();

        return $result ? (int)$result['rating'] : null;
    }
}