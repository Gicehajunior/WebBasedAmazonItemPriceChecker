<?php
use PHPHtmlParser\Dom;

class PriceRequest {
    public $user_in_session;
    public $connection;

    public function __construct($connection, $user_in_session)
    {
        $this->user_in_session = $user_in_session; 
        $this->connection = $connection;
    }

    public function check_price($URL) {
        try {
            if (!function_exists('curl_init')) {
                echo 'cURL is not installed. Install and try again.';
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);

            return $output;
            
        } catch (\Throwable $th) {
            return "unable to parse the URL"; 
        } 
    }

    public function getProductSetEntities() {
        $sql = "SELECT * FROM product_entity_features WHERE item_entity_set_by='$this->user_in_session' AND active=1";
        $result = mysqli_query($this->connection, $sql);
        $num_rows_count = mysqli_num_rows($result);

        if ($num_rows_count > 0) {
            while ($row = mysqli_fetch_assoc($result)) { 
                $item_link = $row['item_link'];
                $item_price = $row['item_price'];
                $item_entity_set_by = $row['item_entity_set_by'];

                return [$item_link, $item_price, $item_entity_set_by];
            }
        } else {
            return "Seems no available item set!";
        }
    }

    public function track_price() {
        if ($this->getProductSetEntities() !== "Seems no available item set!") {
            $product_link = $this->getProductSetEntities()[0];
            $product_price = $this->getProductSetEntities()[1];
            $product_entity_set_by = $this->getProductSetEntities()[2];
        }
        else {
            $product_link = '';
            $product_price = '';
            $product_entity_set_by = '';
        }

        echo $product_link;

        if ($this->check_price($product_link) == "unable to parse the URL") {
            echo "unable to parse the URL";
            exit();
        }
        else {
            $check_price_response = $this->check_price($product_link);
        }

        try {
            $dom = new Dom;

            $dom->loadStr($check_price_response);

            // Product title
            $item_title = $dom->find('.product-title-word-break');
            $item_title = $item_title->text;

            // Product Price
            $item_price = ($dom->find('.a-offscreen')) ? $dom->find('.a-offscreen') : $dom->find('.a-size-medium');
            $item_price = $this->clean($item_price->text);

            echo $item_price;

            $converted_price = $this->clean($item_price); 

            if ($converted_price > $product_price) {
                if ($this->email_client($item_title, $item_price, $product_link, "price gone up") == true) {
                    echo "sent mail success";
                }
            } else if ($converted_price < $product_price) {
                if ($this->email_client($item_title, $item_price, $product_link, "price gone down") == true) {
                    echo "sent mail success";
                }
            } else if ($converted_price == $product_price) {
                if ($this->email_client($item_title, $item_price, $product_link, "normal price") == true) {
                    echo "sent mail success";
                }
            } else {
                if ($this->email_client($item_title, $item_price, $product_link, "unknown price status") == true) {
                    echo "sent mail success";
                }
            }
        } catch (\Throwable $th) {
            echo "unable to parse the URL";
        }
    }

    function clean($price)
    {

        $price = preg_replace('/[^(\x20-\x7F)]*/', '', $price);
        $price = str_replace("$", "", $price);

        return number_format($price, 2);
    }

    public function email_client($item_title, $item_price, $product_link, $status) {
        require "MailController.php";
        require './config/.env-config/.env-loader.php';

        if ($status == "price gone down") {
            $string_paragraph_email_text = "The price for your item with the name ".$item_title." fell down.";
        } else if ($status == "price gone up") {
            $string_paragraph_email_text = "The price for your item with the name ".$item_title." gone up.";
        }
        else if ($status == "normal price") {
            $string_paragraph_email_text = "The price for your item with the name ".$item_title." reads to be normal.";
        }
        else {
            $string_paragraph_email_text = "The price for your item with the name ".$item_title." reads to be normal.";
        }

        $set_from_Header_name = 'AMAZON PRICE TRACKER';
        $set_from_email = $notification_email;
        $set_to_user_emails = explode(", ", $email_recipients);
        $subject =  strtoupper($status);
        $message = '
                        ' . $string_paragraph_email_text . '
                        
                        The Current price reads as: ' . $item_price . '.

                        Kindly Checkout this link to confirm, ' . $product_link . '
                    ';

        $html_body = '<div>
                        '.$string_paragraph_email_text.'
                        
                        The Current price reads as: '.$item_price. '.

                        Kindly Checkout this link to confirm, '.$product_link.'
                    </div>';
        $attachments = '';
        $set_from_password = $notification_email_password;

        $mail = new Mail($set_from_Header_name, $set_from_email, $set_to_user_emails, $subject, $message, nl2br($html_body), $attachments, $set_from_password);
         
        return $mail->email_user();
    }
}


