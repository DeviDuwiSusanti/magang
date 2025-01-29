<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/register.css">
    <title>Register</title>
</head>
<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <header>Register</header>
                <form action="login.php" method="POST" enctype="multipart/form-data" class="d-flex">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="name" required>
                            <label for="name">Nama</label>
                        </div>
                        <div class="input-field">
                            <input type="email" class="input" name="email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" name="nik" required>
                            <label for="nik">NIK</label>
                        </div>
                        <div class="input-field">
                        <select class="input" name="school" id="school" required>
                            <option value="">Masukkan Sekolah Asal</option>
                            <option value="sma_a">SMA Negeri 1 Sidoarjo</option>
                            <option value="sma_b">SMK Buduran 1</option>
                            <option value="universitas_a">Universitas Trunojoyo Madura</option>
                            <option value="universitas_b">Universitas Indonesia</option>
                        </select>
                        </div>
                        <div class="input-field">
                            <select class="input" name="gender" required>
                                <option value="">Pilih Gender</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="input-field">
                            <input type="text" class="input" name="birth_place" required>
                            <label for="birth_place">Tempat Lahir</label>
                        </div>
                        <div class="input-field">
                            <input type="date" class="input" name="birth_date" required>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" name="address" required>
                            <label for="address">Alamat Domisili</label>
                        </div>
                        <div class="input-field">
                            <input type="tel" class="input" name="phone" required>
                            <label for="phone">Telephone</label>
                        </div>

                        <!-- Upload Foto Profil -->
                        <div class="input-field">
                            <label for="image">Upload Foto Profil</label><br><br>
                            <div class="image-preview" id="imagePreview">
                                <img src="" id="previewImage">
                            </div>
                            <input type="file" class="input" id="image" name="image" accept="image/*" onchange="previewFile()" required>
                        </div>
                        <input type="submit" class="submit" name="register" value="Sign Up">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan pratinjau gambar
        function previewFile() {
            const fileInput = document.getElementById('image');
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>