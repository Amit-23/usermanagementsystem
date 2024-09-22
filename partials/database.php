<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'registration_system';
    public $conn;

    public function __construct()
    {
        $this->getConnection();
    }

    public function getConnection()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database, 8111);
        if ($this->conn->connect_error) {
            die("Something went wrong: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    public function registerAdmin($email, $password)
    {
        // No need to declare variables with 'public' inside a method
        // Properly escape the values to prevent SQL injection
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);

        // Hash the password before storing it for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users` (`id`, `role`, `email`, `password`, `parent_admin`) VALUES (NULL, 'admin', '$email', '$hashedPassword', NULL);";

        if ($this->conn->query($query) === TRUE) {
        } else {
            echo "Error: " . $this->conn->error;
        }
    }



    public function addUser($user_email, $user_password, $parent_admin)
    {

        // echo $parent_admin;
        // exit();
        // Check if the email already exists in the admin user

        $result1 = $this->conn->query("SELECT COUNT(*) AS count FROM users WHERE email = '$user_email' AND parent_admin = '$parent_admin'");
         
        // $see = $result1->fetch_assoc();
        // echo $see['count'];
        // exit();

        if ($result1) {
            $row = $result1->fetch_assoc();
            if ($row['count'] == 0) {
                // Hash the password
                $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);

                // Prepare the query
                $query = "INSERT INTO `users` (`id`, `role`, `email`, `password`, `parent_admin`) VALUES (NULL, 'user', '$user_email', '$hashedPassword', '$parent_admin')";

                // Debugging: Output the query
                // echo "Executing query: $query<br>";

                // Execute the query
                $result2 = $this->conn->query($query);

                if ($result2 == TRUE) {
                    return true;
                } else {
                    echo "Error while adding the user: " . $this->conn->error;
                    return false;
                }
            } else {
                
                return false;
            }
        } else {
            echo "Error: Unable to query the database.<br>";
            return false;
        }
    }

   public function getAllUsers($parent_admin)
{
    // Correct SQL query to fetch tasks assigned by a specific admin
    $sql = "SELECT tasks.task_description, users.email 
            FROM tasks 
            JOIN users ON tasks.assigned_to = users.id 
            WHERE tasks.created_by = '$parent_admin' 
            AND users.parent_admin = '$parent_admin'";

    $result = $this->conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as an associative array
    } else {
        return [];
    }
}

}
