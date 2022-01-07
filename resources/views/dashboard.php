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

    <link rel="stylesheet" media="print" href="https://printjs-4de6.kxcdn.com/print.min.css">
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
                                <label for="">Enter Your Desired Price</label>
                                <input style="border-radius: 24px;" type="number" name="product-desired-price" id="product-desired-price" class="form-control" placeholder="" aria-describedby="helpId">
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

            <center class="">
                <div class="form-group">
                    <button style="border-radius: 24px;" type="button" class="btn btn-primary w-25" data-toggle="modal" data-target="#generate-track-price-report">Generate Track Price Reports</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="generate-track-price-report" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 100%;" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Track Price Report</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-start">
                                    <div class="dropdown pl-2 pt-4">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="triggerId">
                                            <a class="dropdown-item btn btn-link generate-track-price-report-btn" id="generate-track-price-report-btn">View Your Report</a>
                                            <h6 class="dropdown-header">Print Actions</h6>
                                            <a class="dropdown-item btn btn-link" id="refresh">Refresh Track Price Reports</a>
                                            <a class="dropdown-item btn btn-link" onclick="printJS({ printable: 'track-price-report', type: 'html', header: `<center><h1>TRACK PRODUCTS PRICE REPORT</h1></center`});">Print Track Price Report</a>
                                        </div>
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="start-date">Date Start</label>
                                        <input type="date" name="from_date" id="start_date" class="form-control" value="">
                                    </div>
                                    <div class="form-group pl-3">
                                        <label for="up-to-date">Date End</label>
                                        <input type="date" name="to_date" id="end_date" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="report-table">
                                    <?php require "report-template.php"; ?>
                                </div>
                            </div>
                            <div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </center>
            <center>
                <div class="form-group">
                    <!-- Button trigger modal -->
                    <button style="border-radius: 24px;" type="button" class="btn btn-primary btn-lg btn-sm w-15" data-toggle="modal" data-target="#help-modal">
                        Help <i class="fa fa-caret-right" aria-hidden="true"></i>
                    </button>
                </div>
            </center>

            <!-- Modal -->
            <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 50%;" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                <srong>HELP INFORMATION</srong>
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: block;" class="container">
                                <p>
                                    Thank you for choosing Flashlight Price Tracker.
                                    Please follow the steps below to use the system:
                                </p>
                                <p>
                                <ol style="margin-left: 12px;">
                                    <li>Log in to your account using your email and password.</li>
                                    <li>Visit the site and select the product you want.</li>
                                    <li>
                                        Copy the link of the product by clicking on the address bar and right clicking then
                                        selecting "Copy" from the list of options. Take note of the current price.
                                    </li>
                                    <li>Click on "Add Product to List for Tracking".</li>
                                    <li>Paste your product link by right clicking and selecting "Paste".</li>
                                    <li>Enter current price of product.</li>
                                    <li>Enter the price of product you want to be notified about. Please enter a reasonable amount.</li>
                                    <li>Click set, then Close.</li>
                                    <li>Wait for a notification once the price drops to your desired price!</li>
                                </ol>
                                </p>
                                <h6><strong>Additional Notes:</strong></h6>
                                <p>To check status of your item, kindly click on "Check Tracking Status".</p>
                                <p>To visit your email, kindly click on "Check email".</p>

                                <p>Thank you again for choosing Flashlight Price Tracker.</p>
                                <p><strong>Ciao!</strong></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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