<?php 
    include "sidebar.php";
?>

<div class="container mt-4">
        <h2 class="text-center p-4">Jadikan Admin Instansi</h2>
        <div class="card p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="../assets/img/login.jpeg" alt="Gambar User" class="img-thumbnail mb-5" width="150">
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                            <td>Saiful Anam</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-gender-male"></i> <strong>Gender</strong></td>
                            <td>Laki-Laki</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-calendar"></i> <strong>Tanggal Lahir</strong></td>
                            <td>Bangkalan, 30-05-2004</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                            <td>0891234432</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-house-door"></i> <strong>Alamat</strong></td>
                            <td>Jl. Sakera Sepulu</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Pilihan Instansi -->
            <form>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Pilih Instansi</label>
                    <select id="instansi" class="form-select">
                        <option selected disabled>Pilih Instansi</option>
                        <option>Diskominfo</option>
                        <option>Dinas Kesehatan</option>
                        <option>Dinas Pendidikan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-person-check"></i> Jadikan Admin Instansi
                </button>
                <a href="admin_instansi_view" class="btn btn-danger">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </form>
        </div>
    </div>