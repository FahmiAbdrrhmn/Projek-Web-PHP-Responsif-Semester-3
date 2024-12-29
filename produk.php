<?php
    require "koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    
    // get produk by keyword
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
    // get produk by kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama = '$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id = '$kategoriId[id]'");  
    }
    // get produk default
    else{
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizky Barokah | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <?php require "navbar.php"; ?>

    <!-- banner-produk -->
    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h2 class="text-white">Produk</h2>
        </div>
    </div>



    <!-- body -->
     <div class="container py-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-12 col-lg-3 mb-5">
                    <h3 class="text-center">Kategori</h3>
                        <ul class="list-group">
                            <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
                            <a class="no-decoration list-group-item list-group-item-action text-center" href="produk.php?kategori=<?php echo $kategori['nama']; ?>">
                                <?php echo $kategori['nama'] ?>
                            </a>
                            <?php } ?>
                        </ul>
                </div>
                <div class="col-lg-9">
                    <h3 class="text-center mb-3">Produk</h3>
                    <div class="row">
                        <?php 
                            if($countData<1){ 
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger text-center" role="alert">
                                Produk tidak ditemukan
                            </div>
                        </div>
                        <?php } ?>

                        <?php while($produk = mysqli_fetch_array($queryProduk)){ ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="image-box">
                                    <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $produk['nama']; ?></h5>
                                    <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                    <p class="card-text text-harga text-center">Rp <?php echo $produk['harga']; ?></p>
                                    <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn warna1 text-white">Lihat Lengkap</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
     </div>





    
    
    <!-- footer -->
    <?php require "footer.php"; ?>  
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>