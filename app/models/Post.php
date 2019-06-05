<?php
  class Post {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Get posts
    public function getPosts() {
      $this->db->query(
        'SELECT posts.id postId, title, body, name, DATE_FORMAT(posts.created_at, "%M %d, %Y (%h:%s %p)") postCreated ' .
        'FROM users JOIN posts ON users.id = posts.user_id ' .
        'ORDER BY posts.created_at DESC'
      );

      $results = $this->db->resultSet();
      return $results;
    }

    // Add post
    public function addPost($data) {
      $this->db->query("INSERT INTO posts(title, body, user_id) VALUES(:title, :body, :user_id)");
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":body", $data["body"]);
      $this->db->bind(":user_id", $data["user_id"]);

      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // Get post by id
    public function getPostById($id) {
      $this->db->query(
        'SELECT *, DATE_FORMAT(posts.created_at, "%M %d, %Y (%h:%s %p)") postCreated ' .
        'FROM posts ' .
        'WHERE id = :id'
      );

      // Bind value
      $this->db->bind(":id", $id);

      $row = $this->db->single();

      return $row;
    }

    // Update post
    public function updatePost($data) {
      $this->db->query(
        'UPDATE posts ' .
        'SET title = :title, body = :body ' .
        'WHERE id = :id AND user_id = :user_id'
      );

      // Bind values
      $this->db->bind(":id", $data["id"]);
      $this->db->bind(":user_id", $data["user_id"]);
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":body", $data["body"]);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // Delete post
    public function deletePost($id) {
      $this->db->query(
        'DELETE FROM posts ' .
        'WHERE id = :id AND user_id = :user_id'
      );

      // Bind values
      $this->db->bind(":id", $id);
      $this->db->bind(":user_id", $_SESSION["user_id"]);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
  }
?>
