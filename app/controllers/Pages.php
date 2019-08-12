<?php
  class Pages extends Controller {
    public function __construct(){

    }

    public function index(){
      if(isLoggedIn()){
        redirect('posts');
      }

      $data = [
        'title' => 'SharePosts',
        'description' => 'This is a simple social network I built using a custom MVC PHP Framework!'
      ];

      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About This App',
        'description' => 'This is an app i built to try out a PHP framework I built from scratch. I hope you like it!'
      ];

      $this->view('pages/about', $data);
    }
  }