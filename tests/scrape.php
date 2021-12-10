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

$html = curl_download('https://www.amazon.de/-/en/Samsung-smartphone-contract-infinity-display-gray/dp/B08QZSP9TP/ref=sr_1_1?crid=35UK5OF274B7R&keywords=samsung+galaxy+s21&qid=1638959420&sprefix=Samsung+%2Caps%2C1073&sr=8-1');


// Assuming you installed from Composer:
require "../vendor/autoload.php";

use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadStr($html);
$a = $dom->find('.product-title-word-break');
echo $a->text; // "click here"

echo '<br><br>';

// a-offscreen
$b = $dom->find('.a-offscreen');
echo $b->text; // "click here"
