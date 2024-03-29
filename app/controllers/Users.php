<?php
  class Users extends Controller {
    public function __construct() {
      $this->userModel = $this->model("User");
    }

    public function index() {
      redirect("users/login");
    }

    public function register() {
      // Check for post
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = array(
          "name" => trim($_POST["name"]),
          "email" => trim($_POST["email"]),
          "password" => trim($_POST["password"]),
          "confirm_password" => trim($_POST["confirm_password"]),
          "name_err" => "",
          "email_err" => "",
          "password_err" => "",
          "confirm_password_err" => ""
        );

        // Validate email
        if (empty($data["email"])) {
          $data["email_err"] = "Please enter email";
        } elseif ($this->userModel->findUserByEmail($data["email"])) {
          $data["email_err"] = "Email is already taken";
        }

        // Validate name
        if (empty($data["name"])) {
          $data["name_err"] = "Please enter name";
        }

        // Validate password
        if (empty($data["password"])) {
          $data["password_err"] = "Please enter password";
        } elseif (strlen($data["password"]) < 6) {
          $data["password_err"] = "Password must at least 6 characters";
        }

        // Validate confirm_password
        if (empty($data["confirm_password"])) {
          $data["confirm_password_err"] = "Please enter confirm_password";
        } elseif ($data["password"] != $data["confirm_password"]) {
          $data["confirm_password_err"] = "Passwords are not matched";
        }

        // Make sure all errors are empty (no error occured)
        if (empty($data["email_err"]) && empty($data["name_err"]) && empty($data["password_err"]) && empty($data["confirm_password_err"])) {
          // Validated

          // Hash password
          $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

          // Register user
          if ($this->userModel->register($data)) {
            flash("register_success", "You are now registered");
            redirect("users/login");
          } else {
            die("Something went wrong");
          }
        } else {
          // Load view
          $this->view("users/register", $data);
        }
      } else {
        // Init data
        $data = array(
          "name" => "",
          "email" => "",
          "password" => "",
          "confirm_password" => "",
          "name_err" => "",
          "email_err" => "",
          "password_err" => "",
          "confirm_password_err" => ""
        );

        // Load view
        $this->view("users/register", $data);
      }
    }

    public function login() {
      // Check for POST
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = array(
          "email" => trim($_POST["email"]),
          "password" => trim($_POST["password"]),
          "email_err" => "",
          "password_err" => ""
        );

        // Validate email
        if (empty($data["email"])) {
          $data["email_err"] = "Please enter email";
        }

        // Validate password
        if (empty($data["password"])) {
          $data["password_err"] = "Please enter password";
        }

        // Check user/email
        if ($this->userModel->findUserByEmail($data["email"])) {
          // User found
        } else {
          // User not found
          $data["email_err"] = "Email doesn't exist";
        }

        // Make sure all errors are empty (no error occured)
        if (empty($data["email_err"]) && empty($data["password_err"])) {
          // Validated
          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data);

          if ($loggedInUser) {
            $this->createUserSession($loggedInUser);
          } else {
            $data["password_err"] = "Password incorrect";
            $this->view("users/login", $data);
          }
        } else {
          // Load view
          $this->view("users/login", $data);
        }

      } else {
        // Init data
        $data = array(
          "email" => "",
          "password" => "",
          "email_err" => "",
          "password_err" => ""
        );

        // Load view
        $this->view("users/login", $data);
      }
    }

    // Create user session
    public function createUserSession($user) {
      $_SESSION["user_id"] = $user->id;
      $_SESSION["user_email"] = $user->email;
      $_SESSION["user_name"] = $user->name;
      redirect("posts/index");
    }

    // Logout
    public function logout() {
      unset($_SESSION["user_id"]);
      unset($_SESSION["user_email"]);
      unset($_SESSION["user_name"]);
      session_destroy();
      redirect("users/login");
    }
  }
?>
