<?php
session_start();
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <style>
        .main {
            height: 100vh;
        }

        .login-box {
            width: 90%;
            max-width: 500px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        @media (max-width: 576px) {
            .login-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label> 
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
            </form>
        </div>

        <div class="mt-3" style="width: 90%; max-width: 500px;">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                
                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                $countData = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countData > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['role'] = $data['role'];
                        $_SESSION['login'] = true;

                        if ($data['role'] == 'admin') {
                            header("Location: adminpanel/index.php");
                        } elseif ($data['role'] == 'user') {
                            header("Location: index.php");
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Peran tidak dikenal.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Password salah.</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning" role="alert">Akun tidak tersedia.</div>';
                }
            }
            ?>
        </div>
    </div>
    
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>
