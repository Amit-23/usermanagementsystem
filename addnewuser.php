<?php
include "./partials/database.php";
session_start();
$datainserted = FALSE;
$error = false;
error_reporting(E_ALL & ~E_NOTICE);

if (!isset($_SESSION['id'])) {
    die("Error: Admin ID not set in the session. Please log in first.");
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['user_email']) && isset($_POST['user_password'])) {

        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $parent_admin = $_SESSION['id'];

        $result = $db->addUser($user_email, $user_password, $parent_admin);

        if ($result != TRUE) {
            $error = true;
        } else {
            $datainserted = TRUE;
        }
    }
} 
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adding User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%);
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border-radius: 15px;
            border: none;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #333;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            padding: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 10px;
            padding: 10px;
            font-size: 1.2rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .alert {
            font-size: 1.2rem;
            padding: 15px;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 40px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <?php include "./partials/navbar.php"?>

    <?php if ($datainserted): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> You have successfully added a user.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = 'admindashboard.php';
            }, 2000);
        </script>
    <?php elseif ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Username already exists. Please choose some other username.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%;">
            <h3 class="text-center mb-4">Add User</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="user_email" class="form-label">Username</label>
                    <input type="text" class="form-control" id="user_email" placeholder="Create User email" name="user_email">
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="user_password" placeholder="Enter Password for the user" name="user_password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
