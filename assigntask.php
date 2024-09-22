<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include './partials/database.php';
$taskassigned = false;

// Ensure the session has an admin ID
if (!isset($_SESSION['id'])) {
    die("Error: Admin ID not set in the session. Please log in first.");
}

$db = new Database();
$conn = $db->getConnection();

// Fetch the users for the dropdown
$query = "SELECT * FROM users WHERE parent_admin = '" . $_SESSION['id'] . "'";
$result = $conn->query($query);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "No users found for this admin.<br>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_desc = $_POST['desc'];
    $assigned_user_id = $_POST['assignto'];   //will conatin id of the user to whom the task is assigned;

    
    if (!empty($task_desc) && !empty($assigned_user_id)) {
        

        $taskQuery = "INSERT INTO tasks (task_description, assigned_to, created_by) VALUES ('$task_desc', '$assigned_user_id', '".$_SESSION['id']."')";
        if ($conn->query($taskQuery) === TRUE) {
           $taskassigned = true;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please provide both task description and assign a user.";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #0d6efd;
        }

        .form-floating textarea {
            height: 150px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .select-user-label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <?php include "./partials/navbar.php"?>

    <div class="container">
        <h1>Create Task</h1>
        <form method="post">
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Enter Task Description" id="desc" name="desc"></textarea>
                <label for="desc">Task Description</label>
            </div>

            <div class="mb-3">
                <label for="assignto" class="select-user-label">Select User</label>
                <select class="form-select" id="assignto" name="assignto" aria-label="Default select example">
                    <option selected>Select the user</option>
                    <?php
                    if (!empty($users)) {
                        foreach ($users as $user) {
                            echo "<option value='" . $user['id'] . "'>" . $user['email'] . "</option>";
                        }
                    } else {
                        echo "<option>No users available</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Assign Task</button>
            </div>
        </form>
        <?php if ($taskassigned): ?>
        <div class="alert alert-success" role="alert">
            Task has been successfully assigned!
        </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        &copy; 2024 Task Management System
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
