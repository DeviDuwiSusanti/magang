<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="assets/css/login.css">
    <style> 
        body {
            background-color:#e2ecf4 ;
        }
        p {
            padding-top: 10px;
            font-size: 12px;
            text-align: center;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="text">
                        <p><b>Welcome <i></i></b></p>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <header>Log In</header>
                        <form action="otp.php" method="POST">
                            <div class="input-field">
                                <input type="email" class="input" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" name="login" value="Sign In">
                            </div>
                        </form>
                        <p>Belum punya akun? <a href="register.php">Register Now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>