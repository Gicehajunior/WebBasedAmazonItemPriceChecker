<?php

function curl_download($Url){

    if (!function_exists('curl_init')){
        die('cURL is not installed. Install and try again.');
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

$html = curl_download('https://www.amazon.com/Samsung-Electronics-Galaxy-Watch-Smartwatch/dp/B096BHLJ7V?ref_=Oct_DLandingS_D_5a6bb8e1_60&smid=ATVPDKIKX0DER');
// echo $html;

// // Assuming you installed from Composer:
// require "../vendor/autoload.php";

// use PHPHtmlParser\Dom;

// $dom = new Dom;
// $dom->loadStr($html);
// $a = $dom->find('.product-title-word-break');
// echo $a->text; // "click here"

// echo '<br><br>';

// // a-offscreen
// $b = $dom->find('.a-size-medium');
// echo clean($b->text); // "click here"

// function clean($price) {

//     $price = preg_replace('/[^(\x20-\x7F)]*/','', $price); 

//     return $price;
// }