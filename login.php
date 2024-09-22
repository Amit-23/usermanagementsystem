<?php
require './partials/database.php';
$login = false;
$showerror = false;
error_reporting(E_ALL & ~E_NOTICE);


$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $row = $result->fetch_assoc();   



    if ($result && password_verify($password, $row['password'])) {
        // here if the user is ordinary user that id of the user will be stored in $_SESSION['id']  and if it is admin that will be stored here also..
        $login = true;
        session_start();
        $_SESSION['email'] = $email; 
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['parent_admin'] = $row['parent_admin'];
        


    } else {
        $showerror = true;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            min-height: 100vh;
        }

        .form-container {
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            margin: 50px auto;
        }

        .form-control {
            border-radius: 25px;
            padding: 10px 15px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 25px;
            background: linear-gradient(90deg, #74ebd5, #ACB6E5);
            border: none;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #6dc5d5, #92b5d5);
        }

        .form-label {
            font-weight: bold;
        }

        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php require './partials/navbar.php' ?>

     <?php if($login && $row['role'] == 'admin'): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>SUCCESS!</strong> You are successfully logged in as Admin!
     <button type="button" class="btn-close"  data-bs-dismiss="alert" aria-label="Close"></button>
     </div> 
     <script>
        setTimeout(function() {
            window.location.href = 'admindashboard.php';
        },2000);
     </script>

     <?php elseif($login && $row['role'] == 'user'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong>SUCCESS!</strong> You are successfully logged in as User!.
     <button type="button" class="btn-close"  data-bs-dismiss="alert" aria-label="Close"></button>
     </div> 
     <script>
        setTimeout(function() {
            window.location.href = 'userdashboard.php';
        },2000);
     </script>

     <?php endif; ?>

    <div class="container">
        <div class="form-container">
            <h3 class="text-center mb-4">Login</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name='email'>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name='password'>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>