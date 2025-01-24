<!DOCTYPE html>
<html lang="id">

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
                <!-- Form Kiri -->
                <div class="col-md-6 left">
                    <div class="input-box">
                        <form action="" method="POST" enctype="multipart/form-data">
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
                                <input type="text" class="input" name="school" required>
                                <label for="school">Nama Sekolah / Kampus</label>
                            </div>
                            <div class="input-field">
                                <select class="input" name="gender" required>
                                    <option value="">Pilih Gender</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form Kanan -->
                <div class="col-md-6 right">
                    <div class="input-box">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="input-field">
                                <input type="text" class="input" name="birth_place" required>
                                <label for="birth_place">Tempat Lahir</label>
                            </div>
                            <div class="input-field">
                                <input type="date" class="input" name="birth_date" required>
                                <label for="birth_date">Tanggal Lahir</label>
                            </div>
                            <div class="input-field">
                                <input type="text" class="input" name="address" required>
                                <label for="address">Alamat Domisili</label>
                            </div>
                            <div class="input-field">
                                <input type="tel" class="input" name="phone" required>
                                <label for="phone">Telephone</label>
                            </div>
                            <div class="input-field">
                                <input type="file" class="input" name="image" accept="image/*" required>
                                <label for="image">Upload Foto</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" name="register" value="Sign Up">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>