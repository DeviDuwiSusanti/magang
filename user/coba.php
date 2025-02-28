<form id="pengajuanForm" action="" class="form-profile" method="POST" enctype="multipart/form-data">
    <div id="step1">
        <h4>Step 1: Daftar Pengajuan</h4>

        <div class="mb-3">
            <label for="instansi" class="form-label">Instansi yang Dituju</label>
            <select class="form-control" name="id_instansi" id="instansi">
                <option value="" disabled selected> -- Pilih Instansi --</option>
                <?php
                if (mysqli_num_rows($result_instansi) > 0) {
                    while ($row = mysqli_fetch_assoc($result_instansi)) {
                        echo '<option value="'.$row['id_instansi'].'">'.$row['nama_panjang'].' (Kuota: '.$row['total_kuota'].')</option>';
                    }
                }
                ?>
            </select>
            <div id="error-instansi" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label for="bidang" class="form-label">Bidang yang Dipilih</label>
            <select class="form-control" name="id_bidang" id="bidang">
                <option value="" disabled selected> -- Pilih Bidang --</option>
            </select>
            <div id="error-bidang" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label for="kelompok_pribadi" class="form-label">Personil</label>
            <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi" onchange="toggleNextButton()">
                <option value="" disabled selected>Pilih Personil</option>
                <option value="Kelompok">Kelompok</option>
                <option value="Pribadi">Pribadi</option>
            </select>
            <div id="error-kelompok_pribadi" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label for="jumlah_anggota" class="form-label">Jumlah Anggota (Termasuk Kamu)</label>
            <input type="number" class="form-control" id="jumlah_anggota" name="jumlah_anggota">
            <div id="error-jumlah_anggota" class="text-danger"></div>
        </div>

        <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="validateStep1()">Next</button>
        <button type="submit" id="submitButton" name="pengajuan_pribadi" class="btn btn-success btn-sm">Kirim</button>
    </div>

    <div id="step2" style="display: none;">
        <h4>Step 2: Informasi Anggota</h4>
        <div id="anggotaContainer"></div>
        
        <button type="submit" class="btn btn-success btn-sm">Kirim</button>
    </div>
</form>