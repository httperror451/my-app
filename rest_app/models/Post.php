<?php

class Post {
    private $connection;
    private $table = 'posts';

    //properties
    public $id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;



    //constructor with DB
    public function __construct($db) {
        $this->connection = $db;
    }

    //get post
    public function read() {
        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
         FROM
         ' . $this->table .'p
         LEFT JOIN
         categories c ON p.category_id = c.id
         ORDER BY
         p.created_at DESC';


        //prepare statement
        $statement = $connection->prepare($query);
        $statement ->execute();

        return $statement;
    }

}

?>