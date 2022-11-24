<?php
    $db = new SQLite3('qrcode.db');
    $cnt = 0;
    $content = "";
    $res = $db->query('SELECT * FROM qr_codes');
    while ($row = $res->fetchArray()) { 
        $url_nologo = '<a class="btn btn-sm btn-primary" title="Lihat" href="generated/' . $row['file_nologo'] . '" target="_blank"><i class="fa-solid fa-eye"></i></a> <a class="btn btn-sm btn-primary" title="Unduh" download href="generated/' . $row['file_nologo'] . '"><i class="fa-sharp fa-solid fa-download"></i></a>';
        $url_logo = '<a class="btn btn-sm btn-primary" title="Lihat" href="generated/' . $row['file_logo'] . '" target="_blank"><i class="fa-solid fa-eye"></i></a> <a class="btn btn-sm btn-primary" title="Unduh" download href="generated/' . $row['file_logo'] . '"><i class="fa-sharp fa-solid fa-download"></i></a>';
        $content .= '<tr>
        <td>' . $row['nama'] . '</td>
        <td>' . $row['deskripsi'] . '</td>
        <td>' . $row['isi'] . '</td>
        <td>' . $url_nologo . '</td>
        <td>' . $url_logo . '</td>
        </tr>';
        $cnt++;
    }
    if (!$cnt) $content = '<tr><td colspan="5" style="text-align: center">--- Tidak ada data ---</td></tr>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row p-3 pb-5">
            <h2>QR Code Generator</h2>
            <div class="col-sm p-2">
                <div class="card my-2">
                    <div class="card-body">
                        <h5 class="card-title">Buat QR code baru... <span id="chevron-new" onclick="toggleMenu('new')"><i class="fa-solid fa-circle-chevron-down"></i></span></h5>
                        <div id="div-new" style="display: none">
                            <form name="formQRCode" action="genQRCode.php" method="POST" onsubmit="return validateForm()">
                                <table class="table">
                                    <tr>
                                        <td style="width: 130px">Nama Singkat <span class="text-danger">*</span></td>
                                        <td><input type="text" id="inp_nama" name="inp_nama" autocomplete="off" maxlength="50" class="form-control d-inline-block"></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td><input type="text" id="inp_deskripsi" name="inp_deskripsi" autocomplete="off" maxlength="90" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>Isi QR Code <span class="text-danger">*</span></td>
                                        <td><input type="text" id="inp_isi" name="inp_isi" autocomplete="off" maxlength="90" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" id="form_submit" name="form_submit" value="1"><button type="submit" class="btn btn-primary" style="float: right">Proses</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <h5 class="card-title">... atau cari QR code yang sudah pernah dibuat <span id="chevron-old" onclick="toggleMenu('old')"><i class="fa-solid fa-circle-chevron-down"></i></span></h5>
                        <div id="div-old" class="table-responsive" style="display: none">
                            <table id="tblQRCode" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nama Singkat</th>
                                        <th rowspan="2">Deskripsi</th>
                                        <th rowspan="2">Isi QR Code</th>
                                        <th colspan="2">QR Code</th>
                                    </tr>
                                    <tr>
                                        <th>Tanpa Logo</th>
                                        <th>Dengan Logo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $content ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 text-end text-white fixed-bottom" style="background-color: black;">&copy; 2022 <?php echo (date("Y")!=2022 ? " - " . date("Y") : "") ?> <a href="https://github.com/isnanmulia" target="_blank">isnanmulia</a></div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus'
        });
    });
    function validateForm() {
        nama = $("#inp_nama").val();
        isi = $("#inp_isi").val();
        if (!nama) {
            alert("Nama kosong");
            $("#inp_nama").focus();
            return false;
        } else if (!isi) {
            alert("Isi QR Code kosong");
            $("#inp_isi").focus();
            return false;
        }
        return true;
    }
    function toggleMenu(where) {
        if ($("#div-" + where).css("display") == "none")
            $("#chevron-" + where).html('<i class="fa-solid fa-circle-chevron-up"></i>')
        else 
            $("#chevron-" + where).html('<i class="fa-solid fa-circle-chevron-down"></i>')
        $("#div-" + where).fadeToggle();
    }
    toggleMenu("new"); <?php echo (!$cnt==0 ? 'toggleMenu("old")' : '') ?>
</script>
</html>