<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Produk - Gridova ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
        }

        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid #e4e7ed;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .06);
        }

        .preview-container {
            width: 100%;
            height: 260px;
            border: 2px dashed #b8bdda;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-bottom: 15px;
            background: #fbfbfd;
        }

        .preview-container img {
            width: 100%;
            object-fit: cover;
        }

        .btn-submit {
            background: #1e3a8a;
            border: none;
            padding: .7rem;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            color: #fff;
            transition: .3s;
        }

        .btn-submit:hover {
            background: #0a246b;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-lg-6">

                <h3 class="fw-bold mb-4 text-center">Tambah Produk Baru</h3>

                <div class="form-card">
                    <?php
                        require_once '../controller/produkController.php';
                        $produk = new ProdukController();

                        // Ambil data produk berdasarkan ID
                        $data = $produk->getById($_GET['id']);


                    ?>

                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- PREVIEW GAMBAR -->
                        <div class="preview-container">
                            <img id="preview-img" src="../assets/images/<?= $data['gambar']; ?>" alt="" class="">
                        </div>

                        <!-- INPUT GAMBAR -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Gambar</label>
                            <input type="file" class="form-control" name="gambar"
                                accept="image/png, image/jpg, image/jpeg" onchange="previewImage(event)">
                        </div>

                        <!-- NAMA -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Smartphone</label>
                            <input type="text" class="form-control" name="nama" required value="<?= $data['nama']; ?>">
                        </div>

                        <!-- HARGA -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Harga</label>
                            <input type="number" class="form-control" name="harga" required
                                value="<?= $data['harga']; ?>">
                        </div>

                        <button class="btn-submit" name="submit" type="submit">
                            Simpan Perubahan
                        </button>

                    </form>

                    <?php
                        
                        require_once '../controller/produkController.php';

                        $produk = new ProdukController();

                                if (isset($_POST['submit'])) {

                        $nama  = $_POST['nama'];
                        $harga = $_POST['harga'];

                        // Cek apakah user upload gambar baru
                        if (!empty($_FILES['gambar']['name'])) {

                            $gambar = $_FILES['gambar']['name'];
                            $tmp    = $_FILES['gambar']['tmp_name'];

                            $path = "../assets/images/" . basename($gambar);

                            move_uploaded_file($tmp, $path);

                        } else {
                            // gunakan gambar lama
                            $gambar = $data['gambar'];
                        }

                        $dataUpdate = [
                            'nama'   => $nama,
                            'harga'  => $harga,
                            'gambar' => $gambar
                        ];

                        if ($produk->updateProduk($_GET['id'], $dataUpdate)) {
                            echo "<script>alert('Data berhasil diupdate'); window.location.href='index.php';</script>";
                        } else {
                            echo "<script>alert('Data gagal diupdate');</script>";
                        }
                    }


                        ?>

                </div>
            </div>
        </div>

    </div>

    <script>
        function previewImage(event) {
            const img = document.getElementById("preview-img");
            const text = document.getElementById("preview-text");
            img.src = URL.createObjectURL(event.target.files[0]);
            img.classList.remove("d-none");
            text.classList.add("d-none");
        }
    </script>

</body>

</html>