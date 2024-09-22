<?php
session_start();
include "./partials/database.php";
error_reporting(E_ALL & ~E_NOTICE);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
} 

$adminName = $_SESSION['email'];

// Retrieve all the users created by the admin
$db = new Database();
$conn = $db->getConnection(); 
$parent_admin = $_SESSION['id'];

$users = $db->getAllUsers($parent_admin);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHq+6TZEXREklI0BSrkGFV2DQFcG/9ZW/ACf8Br4pRlE3NHIF5/8L8mx2efJ7PqESdh0wNw==" crossorigin="anonymous" />
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .table-container {
            margin-top: 40px;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
            padding: 12px 15px;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f1f1f1;
        }

        .table-header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
        }

        .empty-message {
            text-align: center;
            font-size: 1.2em;
            color: #6c757d;
            padding: 20px 0;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .admin-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .admin-header i {
            font-size: 30px;
        }

        .card {
            border-radius: 8px;
        }

        .card-header {
            font-size: 1.5em;
        }
    </style>
</head>

<body>
    <?php include './partials/navbar.php' ?>

    <div class="container mt-4">
        <div class="admin-header shadow-sm">
            <h1>Welcome, <?= htmlspecialchars($adminName); ?> <i class="fas fa-user-circle"></i></h1>
            <a href="logout.php" class="btn btn-light">Logout</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header text-center table-header">
                <h3>Assigned Tasks</h3>
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">User Email</th>
                            <th scope="col">Assigned Task</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['task_description']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="empty-message">No tasks found for this admin.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
