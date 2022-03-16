<?php

include dirname(__DIR__) . '/src/SendTalk.php';


$apiKey = 'YOUR_SENDTALK_API_KEY_HERE';
$sendtalk = new Esyede\TapTalk\SendTalk($apiKey);


/*
|--------------------------------------------------------------------------
| Send a plain text message.
|--------------------------------------------------------------------------
*/

// $receiverPhone = '081234567890';
// $message = 'Selamat, anda mendapatkan 2 buah mobil Honda Jazz 2022. Ikuti terus gebyar semarak indosiar!';

// $results = $sendtalk->sendText($receiverPhone, $message);
// echo json_encode($results); die;



/*
|--------------------------------------------------------------------------
| Send a text message with image.
|--------------------------------------------------------------------------
*/

// $receiverPhone = '081234567890';
// $imageUrl = 'https://i.picsum.photos/id/111/4400/2656.jpg?hmac=leq8lj40D6cqFq5M_NLXkMYtV-30TtOOnzklhjPaAAQ';
// $imageCaption = 'Tak kirimi gambar mobil Farmer Boy mat :)';
// $imageFileName = 'FARMER-BOY.jpg';

// $results = $sendtalk->sendImage($receiverPhone, $imageUrl, $imageCaption, $imageFileName);
// echo json_encode($results); die;


/*
|--------------------------------------------------------------------------
| Send an OTP message (prioritized message).
|--------------------------------------------------------------------------
*/

// $receiverPhone = '081234567890';
// $message = 'Kode OTP anda adalah 12345';

// $results = $sendtalk->sendOTP($receiverPhone, $message);
// echo json_encode($results); die;