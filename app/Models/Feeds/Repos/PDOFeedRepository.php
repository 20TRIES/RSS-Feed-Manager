<?php namespace App\Models\Feeds\Repos;

use App\Contracts\ModelContract AS Model;
use App\Models\Feeds\Feed;
use PDO;

class PDOFeedRepository extends FeedRepository {

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(Model $model)
    {
        parent::__construct($model);

        // Create a new instance of PDO.
        $host     = 'localhost';
        $db_name  = 'rss_feed_manager';
        $user     = 'root';
        $password = 'qoC2Dwqa8Bj9T1KMKHEp';
        $this->pdo =  new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    }

    public function find($id)
    {
        $statement = "SELECT feeds.* FROM FEEDS WHERE id = :id";
        $query = $this->pdo->prepare($statement);
        $query->bindParam(':id', $id);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $this->model()->fill($query->fetch());
        return $this->model();
    }

    public function all()
    {
        $statement = "SELECT feeds.* FROM FEEDS";
        $query = $this->pdo->prepare($statement);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();

        $feeds = [];
        foreach($query->fetchAll() AS $data)
        {
            $feed = new Feed();
            $feed->fill($data);
            $feeds[$data['id']] = $feed;
        }
        return $feeds;
    }

    public function create(Array $attributes)
    {
        // TODO: Implement create() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}