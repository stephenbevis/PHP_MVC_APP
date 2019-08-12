<?php
  class Users extends Controller{
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function register(){
      // Check For Post
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process Form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init Data
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_error' => '',
          'email_error' => '',
          'password_error' => '',
          'confirm_password_error' => ''
        ];

        // Validate Name
        if(empty($data['name'])){
          $data['name_error'] = 'Please Enter Name';
        }

        // Validate Email
        if(empty($data['email'])){
          $data['email_error'] = 'Please Enter Email';
        } else {
          // Check Email
          if($this->userModel->findUserByEmail($data['email'])){
            $data['email_error'] = 'Email Is Already Taken';
          }
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_error'] = 'Please Enter Password';
        } elseif(strlen($data['password']) < 6){
          $data['password_error'] = 'Password Must Be At Least 6 Characters';
        }

        // Validate Confrim Password
        if(empty($data['confirm_password'])){
          $data['confirm_password_error'] = 'Please Enter Password Again';
        } else {
          if($data['confirm_password'] != $data['password']){
            $data['confirm_password_error'] = 'Passwords Do Not Match';
          }
        }

        // Make Sure Errors Are Empty
        if(empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
          // Validated
          
          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          // Register User
          if($this->userModel->register($data)){
            flash('register_success', 'Thank You For Registering! You Can Now Log In.');
            redirect('users/login');
          } else {
            die("Something Went Wrong!");
          }
          
        } else {
          // Load View With Errors
          $this->view('users/register', $data);
        }


      } else {
        // Init Data
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_error' => '',
          'email_error' => '',
          'password_error' => '',
          'confirm_password_error' => ''
        ];

        // Load View
        $this->view('users/register', $data);
      }
    }

    public function login(){
      // Check For Post
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process Form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init Data
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_error' => '',
          'password_error' => ''
        ];

        // Validate Email
        if(empty($data['email'])){
          $data['email_error'] = 'Please Enter Email';
        }

        // Validate Password
        if(empty($data['password'])){
          $data['password_error'] = 'Please Enter Password';
        }

        // Check For User/Email
        if($this->userModel->findUserByEmail($data['email'])){
          // User Found
        } else {
          // User Not Found
          $data['email_error'] = 'Email Not Found';
        }

        // Make Sure Errors Are Empty
        if(empty($data['email_error']) && empty($data['password_error'])){
          // Validated
          // Check and Set Logged In User
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // Create Session
            $this->createUserSession($loggedInUser);
          } else {
            // Rerender Form With Error
            $data['password_error'] = "Incorrect Password";
            $this->view('users/login', $data);
          }

        } else {
          // Load View With Errors
          $this->view('users/login', $data);
        }

      } else {
        // Init Data
        $data = [
          'email' => '',
          'password' => '',
          'email_error' => '',
          'password_error' => ''
        ];

        // Load View
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user){
      $_SESSION['user_id'] = $user->userID;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      redirect('posts');
    }

    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_email']);
      session_destroy();
      redirect('users/login');
    }
  }