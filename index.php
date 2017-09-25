<?php

/**
 * To get database.sql please contact me on aswad.ayub@gmail.com
 * Coded with love by Ayub Aswad aka. fsevenm
 */

require_once 'function/webmethod.php';

?>
<!DOCTYPE html>
<html>
  <head>
      <title>AMTaskUploader</title>
      <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
      <link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />
      <link rel="stylesheet" href="style.css"/>
      <link rel="stylesheet" href="style-upload.css">
      <script src="js/tanggaljam.js" type="text/javascript"></script>
      <link rel="stylesheet" href="sweetalert.css">
      <script src="js/sweetalert-dev.js"></script>
      <script src="js/jquery-1.12.4.min.js"></script>
      <link rel="stylesheet" href="animate.css">
      <script src="js/wow.min.js"></script>
      <script>
          $(document).ready(function() {

              window.location.hash = "#popup1";

              new WOW().init();

              alert("hai");
          };
      </script>
  </head>
  <body>
    <div id="pertama">
      <div id="header">
        <img src="assets/Logo.png" id="logo" alt=""/>
        <div id="menu">
          <div class="konten">
                <a href="#" class="demo-2 kolom3" data-text="Demo&nbsp;1">Home</a>
                <a href="#kedua" class="demo-2 kolom3 kolom3tengah" data-text="Demo&nbsp;2">Upload!</a>
                <a href="#footer" class="demo-2 kolom3" data-text="Demo&nbsp;3">Down</a>
          </div>
        </div>
      </div>

      <div class="clear"></div>

      <div class="konten wow fadeInRight">
        <div id="welcome-box">
          <h1>Selamat datang <br>di AMTaskUploader</h1>
            <nav>
              <a href="#kedua" class="box demo-1"> <i class="fa fa-hand-o-right"></i> <span>Upload Tugas Sekarang!</span> </a>
              <a href="#keempat" class="box demo-1"> <i class="fa fa-hand-o-up"></i> <span>Register</span></a>
            </nav>
        </div>
      </div>
    </div>

    <div id="kedua">
      <div class="konten">
        <div id="send-box">
          <h2 class="wow fadeInUp">Upload Tugas Praktikum kamu sekarang!</h2>
            <h4>Persyaratan: telah melakukan pendaftaran.</h4>
          <div class="clear"></div>
          <div id="submit-box">
            <form class="form-submit-tugas" action="index.php" method="post" enctype="multipart/form-data">
              <input type="file" name="file" value="Pilih file" class="btn-choose"><br><br>
              <input type="submit" name="upl" value="Submit" class="btn-submit">
            </form>
          </div>
            <?php
                if (isset($_POST['upl'])) {
                    if ($msgMark === 0) {
                        echo '<script>swal("Perhatian!", "Anda belum memilih file", "warning");</script>';
                    } else if ($msgMark === 1) {
                        echo '<script>swal("Upload gagal!", "Format nama file salah", "error");</script>';
                    } else if ($msgMark === 2) {
                        echo '<script>swal("Upload gagal!", "Format nama file tidak sesuai", "error");</script>';
                    } else if ($msgMark === 3) {
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Sepertinya Anda belum terdaftar sebagai pengguna AMTaskUploader",
                            type: "error",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Daftar sekarang!",
                            cancelButtonText: "Batal",
                            closeOnConfirm: true,
                            closeOnCancel: false
                            },
                            function(isConfirm){
                                if (isConfirm){
                                    top.location = "#ketiga";
                                } else {
                                    swal(":(", "Pendaftaran dibatalkan", "error");
                                }
                            });</script>';
                    } else if ($msgMark === 4){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Batas waktu upload untuk tugas ini sudah berakhir",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 5){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Anda belum diizinkan mengupload tugas ini. Coba lagi nanti",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 6){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Tugas ini dibatasi sekali upload berhasil",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 7){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Ukuran file terlalu besar",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 8){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "File ekstensi tidak didukung",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 9) {
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Anda belum registrasi untuk final online",
                            type: "error",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Daftar sekarang!",
                            cancelButtonText: "Batal",
                            closeOnConfirm: true,
                            closeOnCancel: false
                            },
                            function(isConfirm){
                                if (isConfirm){
                                    top.location = "#ketiga";
                                } else {
                                    swal(":(", "Pendaftaran dibatalkan", "error");
                                }
                            });</script>';
                    } else if ($msgMark === 10){
                        echo '<script>swal({
                            title: "Upload gagal!",
                            text: "Waktu submission tugas final Anda sudah berakhir",
                            type: "error",
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            },
                            function(isConfirm){
                                if (isConfirm){
                                   swal(":)", "Tetap semangat!", "info");
                                }
                            });</script>';
                    } else if ($msgMark === 11) {
                        echo '<script>swal("Upload sukses!", "File berhasil terupload", "success");</script>';
                    } else if ($msgMark === 12) {
                        echo '<script>swal("Selamat!", "Anda telah berhasil mengumpulkan project final", "success");</script>';
                    }
                }
            ?>
            <div id="info-lo">
                    <ul class="style-1 effect">
                            <li>
                                <h2>Ketentuan & Cara Upload</h2>
                                <p>
                                    <ul>
                                        <li>Format file yang dibolehkan: <br> &nbsp;&nbsp;&nbsp; zip, rar, iso, dmg dan 7z</li>
                                        <li>Ukuran file maks: <br> &nbsp;&nbsp;&nbsp; 4.5 mb</li>
                                        <li>Format nama file: <br> &nbsp;&nbsp;&nbsp; &lt;NamaTugas&gt;-&lt;Stambuk&gt;-&lt;Nama&gt;-&lt;Kelas&gt;</li>
                                        <li>Contoh nama file: <br> &nbsp;&nbsp;&nbsp;Tugas2-F55114007-Ayub Aswad-A</li>
                                        <li>Tugas yang sudah sukses tidak dapat re-upload</li>
                                        <hr>
                                        <li>Baca ketentuan upload, pilih file, klik Submit</li>
                                    </ul>
                                </p>
                            </li>
                        <li><img class="top" src="images/agreement.svg" alt=""/></li>
                    </ul>
                <div class="info-box">
                    <ul class="style-1 effect">
                        <li>
                            <div class="scroller">
                                <h2>Final Praktikum IMK</h2>
                                <ul>
                                    <li>ProjectFinalPIMK</li>
                                    <li>Open (Gel. 1):<br> &nbsp;&nbsp;&nbsp; 13 Juni 2016 18:00 WIB</li>
                                    <li>Deadline (Gel. 1):<br> &nbsp;&nbsp;&nbsp; 13 Juni 2016 23:00 WIB</li>
                                    <li>Reopen (Gel. 2):<br> &nbsp;&nbsp;&nbsp; 14 Juni 2016 8:00 WIB</li>
                                    <li>Deadline (Gel. 2):<br> &nbsp;&nbsp;&nbsp; 14 Juni 2016 16:00 WIB</li>
                                </ul>
                            </div>
                        </li>
                        <li><img class="top" src="images/classSD.svg" alt=""/></li>
                    </ul>
                </div>
                <div class="info-box">
                    <ul class="style-1 effect">
                        <li>
                            <div class="scroller">
                                <h2>Tugas Prak SD</h2>
                                <ul>
                                    <li>Tugas1PSD<br> &nbsp;&nbsp;&nbsp; Due: 13 Juni 2016 23:00 WIB</li>
                                    <li>Tugas2PSD<br> &nbsp;&nbsp;&nbsp; Due: 13 Juni 2016 23:00 WIB</li>
                                </ul>
                                <h2>Final Prak SD</h2>
                                <ul>
                                    <li>ProjectFinalPSD<br> &nbsp;&nbsp;&nbsp; Due: 17 Juni 2016 23:00 WIB</li>
                                </ul>
                            </div>
                        </li>
                        <li><img class="top" src="images/classIMK.svg" alt=""/></li>
                    </ul>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div id="keempat">
        <div class="konten">
            <h2>Registrasi Pengguna AMTaskUploader</h2>
            <div class="reg-user">
                <form id="user-reg-form" method="post">
                    <label for="stambuk">Stambuk</label>
                    <input required typeof="number" maxlength="9" type="text" name="stambuk" id="stambuk" placeholder="F55115000">
                    <label for="nama">Nama</label>
                    <input required maxlength="35" type="text" name="nama" id="nama" placeholder="Nama Anda">
                    <label for="kunci">Kode Kunci</label>
                    <input required maxlength="8" type="password" name="kunci" id="kunci" placeholder="Kode Unik Mudah Diingat">
                    <input required type="checkbox" name="setuju-reg" id="setuju-reg" value="setuju"><label for="setuju-reg">  Saya berjanji, data ini adalah benar data saya</label>
                    <input type="submit" name="reg-user" id="reg-user" value="Daftar">
                </form>
                <?php
                    if (isset($_POST['reg-user'])){
                        if ($msgMark === 0){
                            echo '<script>swal("Registrasi gagal!", "Pengguna telah terdaftar", "error");</script>';
                        } else if ($msgMark === 1){
                            echo '<script>swal("Registrasi sukses!", "Anda telah terdaftar sebagai pengguna AMTaskUploader", "success");</script>';
                        } else if ($msgMark === 2){
                            echo '<script>swal("Oops!", "Semua field harus diisi untuk melakukan pendaftaran", "warning");</script>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div id="ketiga">
        <?php if ($_SESSION['amtuUser']) { ?>
        <div class="konten">
            <h2>Submit Analisa Praktikum Basis Data</h2>
            <div class="ujian-final" id="khusus">
                <div class="w480" >
                    <span style="color: #fff;">Task Code: </span><h2><?= getTaskCode('PBDA1'); ?></h2>
                    <span style="color: #fff;">Now: (Your Computer)</span><h2 id="clock"></h2>
                    <span style="color: #fff;">Due: (Actual Time)</span><h2><?= getDueDate('PBDA1'); ?></h2>
                    <br>
                    <br>
                    <span style="color: #fff;">Logged as: </span><h2><h2><?= getName($_SESSION['amtuUser']); ?></h2>
                    <h2><?= $_SESSION['amtuUser']; ?></h2>
                        <?= checkTurnedIn($_SESSION['amtuUser'], 'PBDA1'); ?>
                    <form class="form-ujian-final" method="post">
                        <input type="submit" name="keluar" id="keluar" value="Keluar">
                        <br><span style="font-size: 10px;">Sorry bug! Please press twice.</span>
                    </form>
                </div>
                <div class="w480">
                <h2>Kotak Analisa </h2>
                <br>
                    <form method="post">
                        <textarea placeholder="Ketik/CoPas Analisa disini..." style="height: 400px;" name="analisa" id="analisa" rows="30"><?= getAnalysis($_SESSION['amtuUser'], 'PBDA1'); ?></textarea>
                        <span style="color: #fff;">Status: </span>
                        <h2 style="font-size: 24px;"><?= checkSeen1($_SESSION['amtuUser'], 'PBDA1'); ?></h2>
                        <span style="color: #fff;">Revisi:</span>
                        <textarea name="revisi" id="revisi" cols="30" rows="10"><?= getRevision($_SESSION['amtuUser'], 'PBDA1'); ?></textarea>
                        <input type="submit" name="submit-analisa" id="submit-analisa" value="Submit" onclick="top.location = '#kedua'">
                    </form>
                    <?php
                    if (isset($_POST['submit-analisa'])){
                        if ($msgMark === 0){
                            echo '<script>swal("Oops!", "Anda belum memasukkan apapun!", "warning");</script>';
                        } else if ($msgMark === 1){
                            echo '<script>swal("Analisa Tidak Dikirim!", "Submit hanya diizinkan sekali.", "error");</script>';
                        } else if ($msgMark === 2){
                            echo '<script>swal("Sukses!", "Analisa Anda telah dikirim.", "success");</script>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="konten">
            <h2>Login</h2>
            <h4>Praktikum Basis Data Only</h4>
            <div class="log-user">
                <form id="user-log-form" method="post">
                    <label for="stambuk">Stambuk</label>
                    <input required maxlength="9" type="text" name="stambuk" id="stambuk" placeholder="F55115000">
                    <label for="nama">Kode Kunci</label>
                    <input required maxlength="8" type="password" name="kunci" id="kunci" placeholder="Kode Kunci">
                    <input type="submit" name="log-user" id="log-user" value="Masuk">
                </form>
                <?php
                if (isset($_POST['log-user'])){
                    if ($msgMark === 0){
                        echo '<script>swal("Oops!", "Sepertinya Anda Belum Terdaftar, Silahkan Mendaftar!", "warning");</script>';
                    } else if ($msgMark === 1){
                        echo '<script>swal("Login gagal!", "Kode Kunci yang Anda Masukkan tidak cocok.", "error");</script>';
                    }
                }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <div id="footer">
      <p>
        &copy;AMEDIA
      </p>
    </div>
  </body>
</html>
