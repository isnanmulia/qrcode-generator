<?php
    $db = new SQLite3('qrcode.db');



    $db->exec("CREATE TABLE IF NOT EXISTS qr_codes(id INT PRIMARY KEY, nama VARCHAR(50), isi VARCHAR(250), deskripsi VARCHAR(250), file_nologo VARCHAR(100), file_logo VARCHAR(100), dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

?>
