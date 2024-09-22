<?php
session_start();
$isadmin = false;

// Check if user is logged in and role is set
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
  $isadmin = true;
}

// Output the navbar
echo '<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="' . ($isadmin ? 'admindashboard.php' : '#') . '">Home</a>
        </li>';

// If the user is an admin, show admin links
if ($isadmin) {
  echo '<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="addnewuser.php">Add User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="assigntask.php">Assign Task</a>
        </li>';
}

// If the user is logged in, show the logout link
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  echo '<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
        </li>';
} else {
  // Show login and signup links if not logged in
  echo '<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="ADMINregister.php">Admin Signup</a>
        </li>';
}

echo '   </ul>
    </div>
  </div>
</nav>';
?>
