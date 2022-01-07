<?php

class Auth {

    public $password;
    public $confirmation_password;
    public $username;
    public $email;

    public $connection;


    public function __construct($connection, $email=null, $password=null)
    {
        $this->connection = $connection;
        $this->email = $email; 
        $this->password = $password;
    }

    public function login() {  

        $sql = "SELECT * FROM users WHERE email='$this->email' AND password='$this->password'";
        $result = mysqli_query($this->connection, $sql);
        $num_rows_count = mysqli_num_rows($result); 

        if ($num_rows_count > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                session_start();

                $_SESSION['id_in_session'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                echo "login success!";
            } 
        } else {
            echo "email and password might be wrong!";
        } 

    } 

    public function register($username, $confirmation_password) {
        $this->username = $username;
        $this->confirmation_password = $confirmation_password;

        if ($this->password == $this->confirmation_password) {
            $sql = "SELECT * FROM users WHERE email='$this->email'";
            $result = mysqli_query($this->connection, $sql);

            if (!$result->num_rows > 0) {
                $sql = "INSERT INTO users (username, email, password) VALUES ('$this->username', '$this->email', '$this->password')";
                $result = mysqli_query($this->connection, $sql);

                if ($result) {
                    echo "register success!";
                } else {
                    echo "register failed!";
                }
            } else {
                echo "Email already exists";
            }
        } else {
            echo "password mismatch";
        }
    }

    public function logout() {
        session_start();

        session_unset();
        session_destroy();
        session_abort();

        if (true) {
            header('Location: /?log=booted out successfully');
            exit();
        }
    }
}