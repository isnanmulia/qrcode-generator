<?php
    if (isset($_POST["form_submit"])) {
        require_once 'phpqrcode/qrlib.php';
        $db = new SQLite3('qrcode.db');
        $storage = 'generated/';
        if (!file_exists($storage)) mkdir($storage);
        $nama = strtolower($_POST["inp_nama"]);
        $fileqr = str_replace('', '-', $nama) . '.png';
        $fileqrlogo = str_replace(' ', '-', $nama) . '-logo.png';
        $filelogo = 'LogoRS.png';
        $isi = $_POST["inp_isi"];
        $deskripsi = (strlen($_POST["inp_deskripsi"]) ? $_POST["inp_deskripsi"] : "");

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

        // save to sqlite
        $db->exec("INSERT INTO qr_codes (nama, isi, deskripsi, file_nologo, file_logo) VALUES ('" . $nama . "', '" . $isi . "', '" . $deskripsi . "', '" . $fileqr . "', '" . $fileqrlogo . "')");

        echo "<script>alert('Sukses memproses QR code'); window.location.href='index.php';</script>";
    }
?>