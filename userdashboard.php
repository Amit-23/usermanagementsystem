<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$noTaskAssigned = false;
$sno = 0;

require './partials/database.php';
$obj = new Database();
$conn = $obj->getConnection();

$assigned = $_SESSION['id'];
$userName = $_SESSION['email'];

$result = $conn->query("SELECT * FROM tasks WHERE assigned_to = '$assigned'");

if ($result) {
    if ($result->num_rows == 0) {
        $noTaskAssigned = true;
    } else {
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 40px;
        }

        .card {
            background-color: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-body {
            padding: 30px;
        }

        .welcome-message {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .no-task-message {
            font-size: 1.5rem;
            color: #dc3545;
            text-align: center;
            font-weight: bold;
        }

        .table {
            background-color: #fff;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }

        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .btn-custom {
            background-color: #343a40;
            border-color: #343a40;
            color: white;
        }

        .btn-custom:hover {
            background-color: #495057;
            border-color: #343a40;
        }

      
        .card-header {
            background: linear-gradient(135deg, #0072ff 0%, #00c6ff 100%);
            color: #fff;
            font-size: 1.25rem;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            border-bottom: none;
        }

        
        @media (max-width: 768px) {
            .card-body {
                padding: 15px;
            }

            .welcome-message {
                font-size: 1.5rem;
            }

            .container {
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>

<?php include "./partials/navbar.php"  ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Welcome to Your Dashboard
                    </div>
                    <div class="card-body">
                        <div class="welcome-message">
                            Welcome, <?= htmlspecialchars($userName) ?>
                        </div>

                        <?php if ($noTaskAssigned): ?>
                            <p class="no-task-message">No task found.</p>
                        <?php else: ?>
                            <table class="table table-bordered table-hover table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">Sno.</th>
                                        <th scope="col">Assigned Task</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $task): ?>
                                        <tr>
                                            <td><?= htmlspecialchars(++$sno) ?></td>
                                            <td><?= htmlspecialchars($task['task_description']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
