<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/home.css" />
    <style>
        #profile-photo {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 120px;
        }

        #profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        #profile-photo input {
            display: none;
        }

        #profile-photo label {
            position: absolute;
            bottom: 5px;
            right: 5px;
            font-size: 20px;
            color: #007bff;
            cursor: pointer;
            background-color: transparent;
        }

        #profile-photo label:hover {
            color: #0056b3;
        }

        #edit-form input,
        #edit-form textarea {
            margin-bottom: 15px;
        }
    </style>

    <title>Edit Profil</title>
</head>

<body>
    <?php include "../assets/layout/navbarUser.php" ?>

    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== EDIT PROFILE ====================-->
        <section class="section" id="profile">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- Kolom Tengah -->
                    <div class="col-md-8">
                        <article class="profile__data p-4">
                            <h2 class="mb-3">Edit Profil Pengguna</h2>
                            <hr style="border: 1px solid #ddd; margin: 10px 0;">

                            <!-- Foto Profil -->
                            <div id="profile-photo" class="text-center mb-4">
                                <img id="profile-image" src="../assets/img/avatar1.png" alt="Foto Profil">
                                <label for="profile-upload">
                                    <i class="bx bx-camera"></i>
                                </label>
                                <input type="file" id="profile-upload" accept="image/*">
                            </div>

                            <!-- Form Edit Profil -->
                            <form id="edit-form" action="profil.php" method="POST">
                                <div class="form-group">
                                    <label for="nama-lengkap">Nama Lengkap</label>
                                    <input type="text" id="nama-lengkap" name="nama_lengkap" class="form-control" value="Heviaa" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="heviaa@gmail.com" required>
                                </div>

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" id="nik" name="nik" class="form-control" value="35227247635247" required>
                                </div>

                                <div class="form-group">
                                    <label for="tempat-lahir">Tempat Lahir</label>
                                    <input type="text" id="tempat-lahir" name="tempat_lahir" class="form-control" value="Bojonegoro" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal-lahir">Tanggal Lahir</label>
                                    <input type="date" id="tanggal-lahir" name="tanggal_lahir" class="form-control" value="2005-08-17" required>
                                </div>

                                <div class="form-group">
                                    <label for="no-telepon">No. Telepon</label>
                                    <input type="text" id="no-telepon" name="no_telepon" class="form-control" value="0865327432" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3" required>Jl. Diponegoro No.139, Lemah Putro, Sidoarjo, Jawa Timur</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="asal-studi">Asal Studi</label>
                                    <input type="text" id="asal-studi" name="asal_studi" class="form-control" value="Universitas Trunojoyo Madura" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" onclick="window.location.href = 'profil.php'">Simpan Perubahan</button>
                            </form>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../assets/layout/footerUser.php" ?>

    <!-- Script untuk memperbarui foto profil -->
    <script>
        const profileUpload = document.getElementById('profile-upload');
        const profileImage = document.getElementById('profile-image');

        profileUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
