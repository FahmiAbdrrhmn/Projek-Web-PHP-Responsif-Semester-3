<?php
    include("auth.php");
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizky Barokah | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Ayam Segar Rizky Barokah</h1>
            <h3>Butuh Masak Apa Hari Ini?</h3>
            <div class="col-md-8 col-10 offset-md-2 mx-auto">
                <form method="get" action="produk.php">
                    <div class="input-group mb-3 my-5 input-group-lg">
                        <input type="text" class="form-control" placeholder="Cari Ayam Segar" aria-label="Cari Ayam Segar" 
                        aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna1 text-white" id="button-addon2">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- highlight kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori</h3>
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="highlight-kategori daging d-flex justify-content-center align-items-center">
                        <h4 class="text-black"><a class="no-decoration warna6" href="produk.php?kategori=Daging">Daging</a></h4>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="highlight-kategori telur d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration warna5" href="produk.php?kategori=Telur">Telur</a></h4>
                    </div>
                </div>  
                
            </div>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="container-fluid warna1 py-5">
        <div class="container">
            <h3 class="text-white align-items-center">Tentang Kami</h3>
            <div class="row mt-5">
                <div class="col-md-6">
                    <img src="image\lokasi.png" class="img-fluid" alt="Ayam Segar">
                </div>
                <div class="col-md-6">
                    <h4 class="text-white mt-5">Ayam Segar Rizky Barokah</h4>
                    <p class="text-white">Ayam Segar Rizky Barokah adalah toko online 
                        yang menyediakan ayam segar berkualitas. Kami menyediakan ayam segar 
                        dengan harga terjangkau dan kualitas terbaik. Ayam kami dijamin segar dan 
                        bebas dari bahan pengawet. Kami juga menyediakan berbagai macam produk ayam segar 
                        seperti daging ayam, telur ayam, dan lain sebagainya. Ayam Segar Rizky Barokah siap 
                        melayani kebutuhan ayam segar Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- produk -->
     <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php
                    while ($data =mysqli_fetch_array($queryProduk)) { ?>
                <div class="col- 12col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna1 text-white">Lihat Lengkap</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn warna1 text-white" href="produk.php">Lihat Semua Produknya</a>
        </div>
    </div>
    
    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>