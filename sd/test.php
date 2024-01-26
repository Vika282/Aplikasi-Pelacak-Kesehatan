<?php 
include 'function.php';
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 0) {
        header("location: indexAdmin.php");
    } else if ($_SESSION['role'] == 2) {
        header("location: indexPakar.php");
    }
}

if(!isset($_SESSION['persentase'])){
    $_SESSION['persentase'] = [];
}


$gejala = mysqli_query($koneksi, "SELECT * FROM gejala");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
    crossorigin="anonymous"/>
    <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,700&display=swap"
    rel="stylesheet"/>
    <link rel="stylesheet" href="custom.css" />
    <title>Pelacak Kesehatan Pribadi </title>
</head>
<body>
    <nav class="navbar py-2 navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"
            ><img src="gambar/logo.jpg.jpg" width="147" alt="logo.jpg.jpg"
            /></a>
            <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <a class="btn px-4 btn-primary ml-2" href="logout.php" role="button"
                    >Log Out</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <section class="test mt-5">
        <div class="container">
            <div class="row">
                <div class="col align-self-center">
                    <h2 class="mb-4">Pertanyaan : </h2>
                    <form action="" method="post" enctype="multipart/form-data" role="form">
                    <?php
                        $id_penyakit=1;
                        // if(!isset($_SESSION['id_penyakit'])){
                        //     $_SESSION['id_penyakit'] = $id_penyakit;
                        // }else{
                        //     $id_penyakit = $_SESSION['id_penyakit'];
                        // }
                        $id = gejala($id_penyakit);
                        $id_gejala = intval($id);
                        if(!isset($_SESSION['id_gejala'])){
                            $_SESSION['id_gejala'] = $id_gejala;
                        }else{
                            $id_gejala = $_SESSION['id_gejala'];
                        }
                        $data = mysqli_query($koneksi, "SELECT gejala FROM gejala WHERE id_gejala = '$id_gejala'");
                        // var_dump($data);
                        $row = mysqli_fetch_assoc($data);
                    ?>
                    <p class="mb-4">
                        Apakah anda mengalami <?= $row['gejala']; ?> ?
                    </p>
                    <?php 
                        echo'<input type="submit" class="btn btn-primary mr-2 px-4 py-2" name="ya" value="Ya">';
                        echo'<input type="submit" class="btn btn-danger px-3 py-2" name="tidak" value="Tidak">';
                        $persentase = $_SESSION['persentase'];
                        $temp = 0;
                        $_SESSION['id_gejala'] = $id_gejala;
                        $next_gejala = $_SESSION['id_gejala'];
                        // $next_penyakit = $_SESSION['id_penyakit'];
                        if(isset($_POST['ya'])){
                            if(isset($id_gejala)){
                                $temp = $id_gejala;
                                array_push($persentase, $temp);
                            }
                            $_SESSION['persentase'] = $persentase;
                            $next_gejala = $id_gejala + 1;
                            $_SESSION['id_gejala'] = $next_gejala;
                        } 
                        else if(isset($_POST['tidak'])){
                            $next_gejala = $id_gejala + 1;
                            $_SESSION['id_gejala'] = $next_gejala;
                            // $next_penyakit = $id_penyakit += 1;
                            // $_SESSION['id_penyakit'] = $next_penyakit;
                        }
                        if($_SESSION['id_gejala'] > 27) {
                        
                        $TBC = array(1,2,3,4,5,6,7,25,26);
                        $Asma = array(2,8,9);
                        $demamBerdarah = array(18,19,20,21,22);
                        $Anemia = array(14,15,16,17,27);
                        $darahTinggi = array(10,11,12,13); 
                        $nilai = 0;
                        foreach ($persentase as $value) {
                            if (in_array($value, $TBC)) {
                                $nilai += 1;
                            }else{
                                $nilai += 0;
                            } 
                        }
                        $TBC= $nilai/count($TBC);
                        $TBC = number_format($TBC,3);
                        $hasilTBC = $TBC *100;
                        // echo $hasilTBC;
                        // echo '<br>';
                        $_SESSION['TBC'] = $hasilTBC;
                        $nilai = 0;
                        foreach ($persentase as $value) {
                            if (in_array($value, $Asma)) {
                                $nilai += 1;
                            }else{
                                $nilai += 0;
                            }
                        }
                        $Asma = $nilai/count($Asma);
                        $Asma = number_format($Asma,3);
                        $hasilAsma = $Asma *100;
                        // echo $hasilAsma;
                        // echo '<br>';
                        $_SESSION['Asma'] = $hasilAsma;
                        $nilai = 0;
                        foreach ($persentase as $value) {
                            if (in_array($value, $demamBerdarah)) {
                                $nilai += 1;
                            }else{
                                $nilai += 0;
                            }
                        }
                        $demamBerdarah = $nilai/count($demamBerdarah);
                        $demamBerdarah= number_format($demamBerdarah,3);
                        $hasildemamBerdarah = $demamBerdarah *100;
                        // echo $hasildemamBerdarah;
                        // echo '<br>';
                        $_SESSION['demamBerdarah'] = $hasildemamBerdarah;
                        $nilai = 0;
                        foreach ($persentase as $value) {
                            if (in_array($value, $Anemia)) {
                                $nilai += 1;
                            }else{
                                $nilai += 0;
                            }
                        }
                        $Anemia = $nilai/count($Anemia);
                        $Anemia = number_format($Anemia,3);
                        $hasilAnemia = $Anemia *100;
                        // echo $hasilAnemia;
                        // echo '<br>';
                        $_SESSION['Anemia'] = $hasilAnemia;
                        $nilai = 0;
                        foreach ($persentase as $value) {
                            if (in_array($value, $darahTinggi)) {
                                $nilai += 1;
                            }else{
                                $nilai += 0;
                            }
                        }
                        $darahTinggi = $nilai/count($darahTinggi);
                        $darahTinggi = number_format($darahTinggi,3);
                        $hasildarahTinggi = $darahTinggi *100;
                        // echo $hasildarahTinggi;
                        // echo '<br>';
                        $_SESSION['darahTinggi'] = $hasildarahTinggi;
                        header('Location:hasil.php');
                    }
                    ?>
                    <br>
                    
                </div>
                    </form>
                <div class="col d-none d-sm-block">
                    <img width="500" src="gambar/jawab.png" alt="hero" />
                </div>
            </div>
        </div>
    </section>
</body>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"
></script>
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"
></script>
<script
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"
></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"
></script>
</html>