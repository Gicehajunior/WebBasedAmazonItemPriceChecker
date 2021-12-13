<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- toast css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="./public/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Amazon Price Tracker</title>
</head>

<body>
    <section id="main-hero">
        <div class="hero">
            <?php
            if (($_SESSION['username'])) {
            ?>
                <div style="margin-left: 20px; color: white" class="welcome w-75 pt-3">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    Welcome <?= ($_SESSION['username']) ? $_SESSION['username'] : NULL; ?>
                </div>
            <?php
            }
            ?>

            <div class="hero-content">
                <div class="hero-title">
                    <h2>Flashlight Price Tracker</h2>
                    <p>Let us save you time..because time is money!</p>
                    <center>
                        <div class="track-price-request-status" id="track-price-request-status">

                        </div>
                    </center>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <div class="">
                            <a href="https://www.amazon.com/" target="_blank"><button style="border-radius: 30px;" type="button" class="btn btn-secondary">Visit Site and Copy Link of Product</button></a>
                        </div>

                        <div class="pl-3">
                            <button style="border-radius: 30px;" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modelId">Add Product To List For Tracking</button>
                        </div>

                        <div class="pl-3">
                            <button style="border-radius: 30px;" type="button" class="btn btn-secondary request-check-item-price-btn" id="request-check-item-price-btn">Check Tracking Status</button>
                        </div>

                        <div class="pl-3">
                            <a style="text-decoration-line: none" href="https://mail.google.com/mail/" target="_blank"><button style="border-radius: 30px;" type="button" class="btn btn-secondary">Check Email</button></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Set Item Entity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group pb-2 pt-2 set-item-entities-request-status" id="set-item-entities-request-status">

                            </div>
                            <div class="form-group">
                                <label for="">Amazon Product Link</label>
                                <input style="border-radius: 24px;" type="text" name="valid-item-link" id="valid-item-link" class="form-control" placeholder="" aria-describedby="helpId">
                                <small id="helpId" class="text-muted">Enter a Valid Link</small>
                            </div>
                            <div class="form-group">
                                <label for="">Product Current Price</label>
                                <input style="border-radius: 24px;" type="number" name="product-current-price" id="product-current-price" class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <button style="border-radius: 24px;" type="button" class="btn btn-primary form-control" id="set-item">Set</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button style="border-radius: 24px;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="logout">
                <a style="text-decoration-line: none" href="/logout" class="logout" id="logout">Log Out</a>
            </div>
        </div>
    </section>


    <?php require "./resources/partials/footer.php"; ?>