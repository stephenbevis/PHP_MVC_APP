<?php
  class Posts extends Controller {
    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
    }

    public function index(){
      // Get Posts
      $posts = $this->postModel->getPosts();

      $data = [
        'posts' => $posts
      ];

      $this->view('posts/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize Post
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'userID' => $_SESSION['user_id'],
          'title_error' => '',
          'body_error' => ''
        ];

        // Validate Title
        if(empty($data['title'])){
          $data['title_error'] = 'Please Add A Title';
        }

        // Validate Body
        if(empty($data['body'])){
          $data['body_error'] = 'Please Add Body Content';
        }

        // Make sure there are no errors
        if(empty($data['title_error']) && empty($data['body_error'])){
          // Validated
          if($this->postModel->addPost($data)){
            flash('post_added', 'Post Added!');
            redirect('posts');
          } else {
            die("Something Went Wrong!");
          }

        } else {
          // Load View With Errors
          $this->view('posts/add', $data);
        }

      } else {
        $data = [
          'title' => '',
          'body' => ''
        ];
  
        $this->view('posts/add', $data);
      }
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize Post
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'userID' => $_SESSION['user_id'],
          'title_error' => '',
          'body_error' => ''
        ];

        // Validate Title
        if(empty($data['title'])){
          $data['title_error'] = 'Please Add A Title';
        }

        // Validate Body
        if(empty($data['body'])){
          $data['body_error'] = 'Please Add Body Content';
        }

        // Make sure there are no errors
        if(empty($data['title_error']) && empty($data['body_error'])){
          // Validated
          if($this->postModel->addPost($data)){
            flash('post_added', 'Post Added!');
            redirect('posts');
          } else {
            die("Something Went Wrong!");
          }

        } else {
          // Load View With Errors
          $this->view('posts/add', $data);
        }

      } else {
        // Fetch Post
        $post = $this->postModel->getPostById($id);

        // Check For Owner
        // if($post->userID != $_SESSION['user_id']){
        //   redirect('posts');
        // }

        $data = [
          'postID' => $id,
          'title' => $post->title,
          'body' => $post->body
        ];
  
        $this->view('posts/edit', $data);
      }
    }

    public function show($id){
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->userID);

      $data = [
        'post' => $post,
        'user' => $user
      ];

      $this->view('posts/show', $data);
    }
  }