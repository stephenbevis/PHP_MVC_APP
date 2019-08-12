<?php
  class Post {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getPosts(){
      $this->db->query('SELECT *,
                        tbl_posts.postID as postID,
                        tbl_users.userID as userID,
                        tbl_posts.created_at as postCreated,
                        tbl_users.created_at as userCreated
                        FROM tbl_posts
                        INNER JOIN tbl_users
                        ON tbl_posts.userID = tbl_users.userID
                        ORDER BY tbl_posts.created_at DESC
                        ');

      $results = $this->db->resultSet();

      return $results;
    }

    public function addPost($data){
      $this->db->query('INSERT INTO tbl_posts (userID, title, body) VALUES(:userID, :title, :body)');

      // Bind Values
      $this->db->bind(':userID', $data['userID']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getPostById($id){
      $this->db->query('SELECT * FROM tbl_posts WHERE postID = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }
  }