<?php
  class Posts extends Controller {
    public function __construct() {
      if (!isLoggedIn()) {
        redirect("users/login");
      }

      $this->postModel = $this->model("Post");
      $this->userModel = $this->model("User");
    }

    public function index() {
      // Get posts
      $posts = $this->postModel->getPosts();

      $data = array(
        "posts" => $posts
      );

      $this->view("posts/index", $data);
    }

    public function add() {
      // Check for POST
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = array(
          "title" => trim($_POST["title"]),
          "body" => trim($_POST["body"]),
          "user_id" => $_SESSION["user_id"],
          "title_err" => "",
          "body_err" => ""
        );

        // Validate data
        if (empty($data["title"])) {
          $data["title_err"] = "Please enter title";
        }
        if (empty($data["body"])) {
          $data["body_err"] = "Please enter body";
        }

        // Make sure all errors are empty (no error occured)
        if (empty($data["title_err"]) && empty($data["body_err"])) {
          // Validated
          if ($this->postModel->addPost($data)) {
            flash("post_message", "Your post is added");
            redirect("posts");
          } else {
            die("Something went wrong");
          }
        } else {
          // Load view
          $this->view("posts/add", $data);
        }
      } else {
        $data = array(
          "title" => "",
          "body" => "",
        );

        $this->view("posts/add", $data);
      }
    }

    public function show($id) {
      $post = $this->postModel->getPostById($id);
      if (!$post) {
        // no post found
        redirect("posts");
      }
      $user = $this->userModel->getUserById($post->user_id);

      $data = array(
        "post" => $post,
        "user" => $user
      );

      $this->view("posts/show", $data);
    }

    public function edit($id) {
      // Check for POST
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = array(
          "id" => $id,
          "title" => trim($_POST["title"]),
          "body" => trim($_POST["body"]),
          "user_id" => $_SESSION["user_id"],
          "title_err" => "",
          "body_err" => ""
        );

        // Validate data
        if (empty($data["title"])) {
          $data["title_err"] = "Please enter title";
        }
        if (empty($data["body"])) {
          $data["body_err"] = "Please enter body";
        }

        // Make sure all errors are empty (no error occured)
        if (empty($data["title_err"]) && empty($data["body_err"])) {
          // Validated
          if ($this->postModel->updatepost($data)) {
            flash("post_message", "Your post is updated");
            redirect("posts/show/" . $data["id"]);
          } else {
            die("Something went wrong");
          }
        } else {
          // Load view
          $this->view("posts/edit", $data);
        }
      } else {
        $post = $this->postModel->getPostById($id);
        if (!$post) {
          // no posts found
          redirect("posts");
        }

        // Check for owner
        if ($post->user_id != $_SESSION["user_id"]) {
          redirect("posts");
        }

        $data = array(
          "id" => $id,
          "title" => $post->title,
          "body" => $post->body
        );

        $this->view("posts/edit", $data);
      }
    }

    public function delete($id) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($this->postModel->deletePost($id)) {
          flash("post_message", "Post deleted");
          redirect("posts");
        }
      } else {
        redirect("posts");
      }
    }
  }
?>
