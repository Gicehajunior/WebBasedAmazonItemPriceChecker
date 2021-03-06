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
    <section class="" id="login">
        <div class="container w-25">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
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
                } else if (isset($_GET['registration'])) {
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><?= $_GET['registration'] ?></strong>
                    </div>
                <?php
                }
                ?>
                <div class="login-status-container" id="login-status-container">

                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>
                <div class="input-group">
                    <button name="button" class="btn" id="login-submit-btn">Login</button>
                </div>
                <p class="login-register-text">Don't have an account? <a href="register">Register Here</a>.</p>
            </form>
        </div>
    </section>

    <?php require "./resources/partials/footer.php"; ?>