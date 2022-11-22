<?php
    include 'phpqrcode/qrlib.php';
    $storage = 'generated/';
    if (!file_exists($storage)) mkdir($storage);
    $fileqr = 'testing.png';
    $fileqrlogo = 'testing-logo.png';
    $filelogo = 'logoRS.png';
    $isi = 'https://google.com';

    // generate QR code
    QRcode::png($isi, $storage.$fileqr, QR_ECLEVEL_H, 10, 4);

    // add logo inside QR code
    $QR = imagecreatefrompng($storage.$fileqr);
    $logo = imagecreatefromstring(file_get_contents($filelogo));

    imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
    imagealphablending($logo, false);
    imagesavealpha($logo, true);

    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    $logo_qr_width = $QR_width/4;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;
    imagecopyresampled($QR, $logo, $QR_width/2.7, $QR_height/2.8, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    imagepng($QR, $storage.$fileqrlogo);


    // show QR code
    echo '<img src="'.$storage.$fileqr.'">';
    echo '<img src="'.$storage.$fileqrlogo.'">';
?>