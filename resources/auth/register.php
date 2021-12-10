<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./public/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Amazon Price Tracker</title>
</head>

<body>
    <section id="register">
        <div class="container w-50">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
                <?php
                if (isset($_GET['error'])) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><?= $_GET['error'] ?></strong>
                    </div>
                <?php
                }
                ?>
                <div class="register-status-container" id="register-status-container">

                </div>
                <div class="input-group">
                    <input type="text" placeholder="Username" name="username" id="username"required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" required>
                </div>
                <div class="input-group">
                    <button name="button" class="btn register-submit-btn" id="register-submit-btn">Register</button>
                </div>
                <p class="login-register-text">Have an account? <a href="/">Login Here</a>.</p>
            </form>
        </div>
    </section>
    <?php require "./resources/partials/footer.php"; ?>