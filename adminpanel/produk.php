<?php
    require "../session.php";
    require "../koneksi.php";  

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id = b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i=0; $i<$length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

</head>

<style>
    .no-decoration{
        text-decoration: none ;
    }

    form div{
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class = "container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                 <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted"><i class="fas fa-home"></i> Home</a>
                </li>
                 <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <!-- tambah produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete=off required
                    >
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" > 
                        <option value="">Pilih Satu</option>
                        <?php
                            while($data=mysqli_fetch_array($queryKategori)){
                        ?>
                            <option value="<?php echo $data['id'] ?>"> <?php echo $data['nama'] ?></option>
                        <?php
                                    
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia">tersedia</option>
                        <option value="habis">habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES['foto']['name']);
                    $target_file = "{$target_dir}{$nama_file}";
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $image_size = $_FILES['foto']['size'];
                    $random_name = generateRandomString(20);
                    $new_name = "{$random_name}.{$imageFileType}";

                    if($nama==''|| $kategori=='' || $harga==''){
                ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Nama, Kategori, dan Harga wajib diisi
                        </div>
                <?php
                    }
                    else{
                        $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
                        $jumlahData = mysqli_num_rows($queryCheck);

                        if($jumlahData > 0){
                ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Produk sudah ada
                            </div>
                <?php
                        }
                        else{
                            if($image_size > 0){
                                if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'){
                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Format file tidak didukung
                                </div>
                <?php
                                }
                                else{
                                    if(move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir.$new_name)){
                                        $querySimpan = mysqli_query($con, "INSERT INTO produk(nama, kategori_id, harga, foto, detail, ketersediaan_stok) 
                                        VALUES('$nama', '$kategori', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");
                                        if($querySimpan){
                ?>
                                            <div class="alert alert-success mt-3" role="alert">
                                                Produk berhasil ditambahkan
                                            </div>
                <?php
                                            ?>
                                            <meta http-equiv="refresh" content="0; url=produk.php">
                                            <?php
                                        }
                                        else{
                                            echo mysqli_error($con);
                                        }
                                    }
                                    else{
                                        echo mysqli_error($con);
                                    }
                                }
                            }
                            else{
                                $querySimpan = mysqli_query($con, "INSERT INTO produk(nama, kategori_id, harga, detail, ketersediaan_stok) 
                                VALUES('$nama', '$kategori', '$harga', '$detail', '$ketersediaan_stok')");
                                if($querySimpan){   
                ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Produk berhasil ditambahkan
                                    </div>
                <?php
                                    ?>
                                    <meta http-equiv="refresh" content="0; url=produk.php">
                                    <?php
                                }
                                else{
                                    echo mysqli_error($con);
                                }
                            }
                        }
                    }
                }       
            ?>
            
        </div>

        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
            <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Ketersediaan Stok</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($jumlahProduk == 0){
                ?>
                    <tr>
                        <td colspan= 6 class="text-center">Tidak ada Produk</td>
                    </tr>
                <?php
                } 
                else {
                    $jumlah = 1;
                    while($data = mysqli_fetch_array($query)){
                ?>
                        <tr>
                            <td><?php echo $jumlah; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['nama_kategori']; ?></td>
                            <td><?php echo $data['harga']; ?></td>
                            <td><?php echo $data['ketersediaan_stok']; ?></td>
                            <td>
                                <a href="produk-detail.php?id=<?php echo $data['id']; ?>" class="btn-btn-info">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                        $jumlah++;
                    }
                }
                ?>
            </tbody>
        </table>
            </div>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>