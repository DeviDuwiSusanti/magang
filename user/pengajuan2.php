<?php
// modal_pengajuan.php

// Ambil data instansi yang memiliki kuota
$sql_instansi = "SELECT i.id_instansi, i.nama_panjang, SUM(b.kuota_bidang) AS total_kuota FROM tb_instansi i JOIN tb_bidang b ON i.id_instansi = b.id_instansi 
                WHERE b.kuota_bidang > 0 GROUP BY i.id_instansi, i.nama_panjang ORDER BY total_kuota DESC";
$result_instansi = mysqli_query($conn, $sql_instansi);

// ambil data pendaftar
$sql_pendaftar = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_user = '$id_user' AND u.id_user = pu.id_user";
$query_pendaftar = mysqli_query($conn, $sql_pendaftar);
$pendaftar = mysqli_fetch_assoc($query_pendaftar);

// Check if we're editing
$is_edit = isset($_GET['id_pengajuanEdit']);
if ($is_edit) {
    $id_pengajuanEdit = $_GET['id_pengajuanEdit'];
    // akses data pengajuan user
    $sql_pengajuan = "SELECT * FROM tb_pengajuan p, tb_bidang b, tb_instansi i WHERE p.id_pengajuan = '$id_pengajuanEdit' AND p.id_bidang = b.id_bidang AND p.id_instansi = i.id_instansi;"; 
    $query_pengajuan = mysqli_query($conn, $sql_pengajuan);
    $pengajuan = mysqli_fetch_assoc($query_pengajuan);

    $sql_dokumen = "SELECT file_path FROM tb_dokumen WHERE id_pengajuan = '$id_pengajuanEdit' ORDER BY id_dokumen ASC";
    $query_dokumen = mysqli_query($conn, $sql_dokumen);
    $daftar_dokumen = mysqli_fetch_all($query_dokumen, MYSQLI_ASSOC);
}
?>

<!-- Modal Tambah Pengajuan -->
<div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengajuanModalLabel"><?= $is_edit ? 'Edit Pengajuan' : 'Tambah Pengajuan Baru' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-container center-form" id="formContainer">
                    <div class="form-wrapper" id="formWrapper">
                        <form id="<?= $is_edit ? 'editPengajuanForm' : 'pengajuanForm' ?>" class="form-profile" method="POST" enctype="multipart/form-data">
                            <?php if ($is_edit): ?>
                                <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan'] ?>">
                                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                            <?php endif; ?>
                            
                            <div id="step1">
                                <h4>Step 1: Daftar Pengajuan</h4>
                                <div class="mb-3">
                                    <label for="instansi" class="form-label">Instansi yang Dituju</label>
                                    <select class="form-control select2" name="id_instansi" id="instansi" style="width: 100%;">
                                        <?php if ($is_edit): ?>
                                            <option value="<?= $pengajuan['id_instansi'] ?>"><?= $pengajuan['nama_panjang'] ?></option>
                                        <?php else: ?>
                                            <option value="" disabled selected>-- Pilih Instansi --</option>
                                        <?php endif; ?>
                                        
                                        <?php
                                        if (mysqli_num_rows($result_instansi) > 0) {
                                            while ($row = mysqli_fetch_assoc($result_instansi)) {
                                                echo '<option value="'.$row['id_instansi'].'">'.$row['nama_panjang'].' (Kuota: '.$row['total_kuota'].')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="bidang" class="form-label">Bidang yang Dipilih</label>
                                    <select class="form-control" name="id_bidang" id="bidang">
                                        <?php if ($is_edit): ?>
                                            <option value="<?= $pengajuan['id_bidang'] ?>"><?= $pengajuan['nama_bidang'] ?></option>
                                        <?php else: ?>
                                            <option value="" disabled selected> -- Pilih Bidang --</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <?php if (!$is_edit): ?>
                                <div class="d-flex gap-4">
                                    <div class="mb-3" style="flex: 1;">
                                        <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                        <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                            <option value="" disabled selected> -- Pilih Pengajuan --</option>
                                            <option value="magang">Magang</option>
                                            <option value="kerja praktek">Kerja Praktek</option>
                                            <option value="pkl">PKL</option>
                                            <option value="penelitian">Penelitian</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" style="flex: 1;">
                                        <label for="kelompok_pribadi" class="form-label">Personil</label>
                                        <select class="form-control" id="kelompok_pribadi" name="kelompok_pribadi">
                                            <option value="" disabled selected> -- Pilih Personil --</option>
                                            <option value="Kelompok">Kelompok</option>
                                            <option value="Pribadi">Pribadi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3" id="jumlahAnggotaContainer" style="display: none;">
                                    <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                                    <input type="number" class="form-control" id="jumlah_anggota" name="jumlah_anggota">
                                </div>
                                <?php else: ?>
                                <div class="mb-3">
                                    <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                    <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                        <option value="<?= $pengajuan['jenis_pengajuan'] ?>"><?= $pengajuan['jenis_pengajuan'] ?></option>
                                        <option value="magang">Magang</option>
                                        <option value="kerja praktek">Kerja Praktek</option>
                                        <option value="pkl">PKL</option>
                                        <option value="penelitian">Penelitian</option>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pelaksanaan</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                            value="<?= $is_edit && !empty($pengajuan['tanggal_mulai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_mulai'])) : '' ?>" 
                                            placeholder="-- mulai --">
                                        <span class="align-self-center">-</span>
                                        <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                            value="<?= $is_edit && !empty($pengajuan['tanggal_selesai']) ? date('d/m/Y', strtotime($pengajuan['tanggal_selesai'])) : '' ?>" 
                                            placeholder="-- selesai --">
                                    </div>
                                </div>
                            
                                <div class="d-flex gap-4">
                                    <!-- KTP -->
                                    <div class="mb-3 position-relative" style="flex: 1;">
                                        <label for="ktp" class="form-label">Unggah KTP</label>
                                        <input type="file" class="form-control pe-5" id="ktp" name="ktp" accept=".pdf" onchange="handleFileLabel('ktp')">
                                        <small id="ktp-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('ktp')"></small>
                                        <?php if ($is_edit): ?>
                                            <p class="mt-1">Dokumen saat ini: <a href="<?= $daftar_dokumen[0]['file_path'] ?>" target="_blank">Lihat KTP</a></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- CV -->
                                    <div class="mb-3 position-relative" style="flex: 1;">
                                        <label for="cv" class="form-label">Unggah CV</label>
                                        <input type="file" class="form-control pe-5" id="cv" name="cv" accept=".pdf" onchange="handleFileLabel('cv')">
                                        <small id="cv-label" class="form-text text-primary" style="cursor: pointer;" onclick="previewFile('cv')"></small>
                                        <?php if ($is_edit): ?>
                                            <p class="mt-1">Dokumen saat ini: <a href="<?= $daftar_dokumen[1]['file_path'] ?>" target="_blank">Lihat CV</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (!$is_edit): ?>
                                    <button type="submit" id="submitButton" name="pengajuan_pribadi" class="btn btn-success btn-sm" style="display: inline-block;">Kirim</button>
                                    <button type="button" id="nextButton" class="btn btn-primary btn-sm" onclick="nextStep(event)" style="display: none;">Next</button>
                                <?php else: ?>
                                    <button type="submit" name="update_pengajuan" class="btn btn-success btn-sm">Update</button>
                                    <input type="hidden" name="hapus_pengajuan">
                                    <button type="button" class="btn btn-danger btn-sm" id="hapusPengajuan">Hapus Pengajuan</button>
                                <?php endif; ?>
                            </div>

                            <?php if (!$is_edit): ?>
                            <!-- Step 2 -->
                            <div id="step2" style="display: none;">
                                <h4>Step 2: Informasi Anggota</h4><br><br>
                                <div id="ketuaContainer">
                                    <!-- Anggota 1 (Readonly, diisi otomatis dari profil user) -->
                                    <div class="mb-3 anggota-group d-flex align-items-center">
                                        <span class="me-2 fw-bold">1.</span>
                                        <div class="row flex-grow-1 gx-2">
                                            <div class="col">
                                                <input type="text" class="form-control" value="<?= $pendaftar['nama_user'] ?>" readonly>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" value="<?= $pendaftar['email'] ?>" readonly>
                                            </div>
                                            <div class="col">
                                                <input type="number" class="form-control" value="<?= $pendaftar['nik'] ?>" readonly>
                                            </div>
                                            <div class="col">
                                                <input type="number" class="form-control" value="<?= !empty($pendaftar['nim']) ? $pendaftar['nim'] : $pendaftar['nisn'] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Placeholder untuk anggota tambahan -->
                                <div id="anggotaContainer"></div>
                                
                                <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">Back</button>
                                <button type="submit" name="pengajuan_kelompok" class="btn btn-success btn-sm">Kirim</button>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Card Detail Lowongan -->
                    <div class="col-md-6" id="detailBidangContainer" style="display: none;">
                        <div class="card" id="detailBidangCard">
                            <div class="card-body">
                                <h5 class="card-title" id="bidangNama"></h5>
                                <p><strong>Deskripsi:</strong></p>
                                <p id="bidangDeskripsi"></p>
                                <p><strong>Kriteria:</strong></p>
                                <p id="bidangKriteria"></p>
                                <p><strong>Dokumen Prasyarat:</strong></p>
                                <p id="bidangDokumen"></p>
                                <p><strong>Kuota:</strong> <span id="bidangKuota"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize modal when shown
    $('#pengajuanModal').on('show.bs.modal', function (e) {
        // Reset form if it's not an edit
        if (!window.location.href.includes('id_pengajuanEdit')) {
            $('#pengajuanForm')[0].reset();
            $('#step1').show();
            $('#step2').hide();
            $('#nextButton').hide();
            $('#submitButton').show();
            $('#jumlahAnggotaContainer').hide();
            $('#detailBidangContainer').hide();
        }
        
        // Initialize select2 with modal parent
        $('#instansi').select2({
            dropdownParent: $('#pengajuanModal'),
            placeholder: "-- Pilih Instansi --",
            allowClear: true
        });
    });

    // Handle delete button
    $('#hapusPengajuan').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[name="hapus_pengajuan"]').val('1');
                $('#editPengajuanForm').submit();
            }
        });
    });

    // Handle modal close
    $('#pengajuanModal').on('hidden.bs.modal', function () {
        // Remove edit parameter from URL if exists
        if (window.location.href.includes('id_pengajuanEdit')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
});
</script>

<!-- Melihat preview dan hapus dokumen -->
<script>
    function handleFileLabel(id) {
        const input = document.getElementById(id);
        const label = document.getElementById(`${id}-label`);

        if (input.files.length > 0) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = '';
        }
    }

    function previewFile(id) {
        const input = document.getElementById(id);
        const file = input.files[0];

        if (file) {
            const fileURL = URL.createObjectURL(file);
            const previewWindow = window.open(fileURL, '_blank');
            previewWindow.focus();
        } else {
            alert("Tidak ada file yang dipilih untuk preview.");
        }
    }
</script>


<!-- hapus pengajuan -->
<script>
document.getElementById('hapusPengajuan').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form langsung terkirim

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim form secara manual
            document.getElementById('editPengajuanForm').submit();
        }
    });
});
</script>

<!-- MENGAMBIL DETAIL BIDANG ATAU LOWONGAN  -->
<script>
    $(document).ready(function() {
        $('#instansi').select2({
            placeholder: "-- Pilih Instansi --",
            allowClear: true
        });
    });
</script>

<script>
$(document).ready(function() {
    // Ambil bidang saat instansi berubah
    $("#instansi").change(function() {
        var id_instansi = $(this).val();

        $.ajax({
            url: "cek.php",
            type: "POST",
            data: { id_instansi: id_instansi },
            success: function(response) {
                $("#bidang").html('<option value="" disabled selected> -- Pilih Bidang --</option>' + response);
                $("#detailBidangContainer").hide(); // Sembunyikan detail bidang jika instansi berubah
                $("#formWrapper").removeClass("shift-left").addClass("center-form"); // Kembalikan posisi tengah
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    });

     // Ambil detail bidang saat bidang dipilih
     $("#bidang").change(function() {
        var id_bidang = $(this).val();

        $.ajax({
            url: "cek.php",
            type: "POST",
            data: { id_bidang: id_bidang },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    $("#detailBidangContainer").hide();
                } else {
                    $("#bidangNama").text(response.nama_bidang);
                    $("#bidangDeskripsi").text(response.deskripsi_bidang);
                    $("#bidangKriteria").text(response.kriteria_bidang);
                    $("#bidangDokumen").text(response.dokumen_prasyarat);
                    $("#bidangKuota").text(response.kuota_bidang);
                    $("#detailBidangContainer").show();
                    
                    // Geser form ke kiri setelah bidang dipilih
                    $("#formWrapper").removeClass("center-form").addClass("shift-left");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    });

});
</script>

<!-- SCRIPT UNTUK VALIDASI FORM -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const kelompokPribadi = document.getElementById("kelompok_pribadi");
    const jumlahAnggotaInput = document.getElementById("jumlah_anggota");
    const jumlahAnggotaContainer = jumlahAnggotaInput ? jumlahAnggotaInput.closest(".mb-3") : null;
    const nextButton = document.getElementById("nextButton");
    const submitButton = document.getElementById("submitButton");
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const anggotaContainer = document.getElementById("anggotaContainer");
    const bidang = document.getElementById("bidang");
    let maxKuota = 0;

    if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "none";
    if (step2) step2.style.display = "none";

    if (kelompokPribadi) {
        kelompokPribadi.addEventListener("change", function() {
            if (this.value === "Kelompok") {
                if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "block";
                if (nextButton) nextButton.style.display = "inline-block";
                if (submitButton) submitButton.style.display = "none";
            } else {
                if (jumlahAnggotaContainer) jumlahAnggotaContainer.style.display = "none";
                if (step2) step2.style.display = "none";
                if (nextButton) nextButton.style.display = "none";
                if (submitButton) submitButton.style.display = "inline-block";
            }
        });
    }

    if (bidang) {
        bidang.addEventListener("change", function() {
            maxKuota = parseInt(this.options[this.selectedIndex].getAttribute("data-kuota")) || 0;
        });
    }

    function showError(input, message) {
        let existingError = input.parentNode.querySelector(".error-message");
        if (existingError) {
            existingError.remove();
        }
        const error = document.createElement("small");
        error.classList.add("error-message");
        error.style.color = "red";
        error.textContent = message;
        input.parentNode.appendChild(error);
    }

    function clearError(input) {
        const error = input.parentNode.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }

    function validateStep1(formId) {
        let isValid = true;
        const form = document.getElementById(formId);
        if (!form) return false;

        const fields = [
            { id: "instansi", message: "Pilih instansi yang dituju!" },
            { id: "bidang", message: "Pilih bidang yang dipilih!" },
            { id: "jenis_pengajuan", message: "Pilih jenis pengajuan!" },
            { id: "tanggal_mulai", message: "Pilih tanggal mulai!" },
            { id: "tanggal_selesai", message: "Pilih tanggal selesai!" }
        ];

        // Hanya tambahkan validasi kelompok_pribadi jika form adalah pengajuanForm
        if (formId === "pengajuanForm") {
            fields.push({ id: "kelompok_pribadi", message: "Pilih personil!" });
        }

        fields.forEach(field => {
            const inputElement = form.querySelector(`#${field.id}`);
            console.log(`Validasi field: ${field.id}, Nilai:`, inputElement ? inputElement.value : "Tidak ditemukan");
            if (!inputElement || !inputElement.value.trim()) {
                if (inputElement) showError(inputElement, field.message);
                isValid = false;
            } else {
                if (inputElement) clearError(inputElement);
            }
        });

        // Validasi jumlah anggota hanya untuk pengajuanForm
        if (formId === "pengajuanForm" && kelompokPribadi && jumlahAnggotaInput) {
            const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
            if (kelompokPribadi.value === "Kelompok") {
                if (jumlahAnggota < 2) {
                    showError(jumlahAnggotaInput, "Jika memilih Kelompok, jumlah anggota harus minimal 2!");
                    isValid = false;
                } else if (jumlahAnggota > maxKuota) {
                    showError(jumlahAnggotaInput, "Jumlah anggota melebihi kuota bidang!");
                    isValid = false;
                } else {
                    clearError(jumlahAnggotaInput);
                }
            } else {
                clearError(jumlahAnggotaInput);
            }
        }

        // Validasi file upload
        const otherFields = [
            { id: "ktp", message: "Upload KTP dalam format PDF!" },
            { id: "cv", message: "Upload CV dalam format PDF!" }
        ];

        const maxFileSize = 1 * 1024 * 1024; // 1 MB
        const allowedMimeTypes = ["application/pdf"];

        otherFields.forEach(({ id }) => {
            const inputElement = document.getElementById(id);
            if (!inputElement) return;

            const file = inputElement.files?.[0];
            if (formId === "pengajuanForm" && !file) {
                showError(inputElement, "File wajib diunggah!");
                isValid = false;
            } else if (file) {
                if (file.size > maxFileSize) {
                    showError(inputElement, "File tidak boleh lebih dari 1 MB!");
                    isValid = false;
                } else if (!allowedMimeTypes.includes(file.type)) {
                    showError(inputElement, "File harus dalam format PDF!");
                    isValid = false;
                } else {
                    clearError(inputElement);
                }
            }
        });

        console.log(`Validasi form ${formId} selesai. Hasil:`, isValid ? "Berhasil" : "Gagal");
     
        return isValid;
    }

    // Validasi email anggota melalui AJAX
    async function checkEmail(emailInput) {
        const email = emailInput.value.trim();
        if (email === "") return;

        try {
            const response = await fetch("cek.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `email=${email}`
            });
            const result = await response.text();
            if (result === "exists") {
                showError(emailInput, "Email sudah digunakan!");
                return false;
            } else {
                clearError(emailInput);
                return true;
            }
        } catch (error) {
            console.error("Error checking email:", error);
        }
    }

    function validateAnggota() {
        let isValid = true;
        const emails = new Set();
        const anggotaInputs = document.querySelectorAll('#anggotaContainer .anggota-group');
        const nameRegex = /^[A-Za-z\s]+$/;

        anggotaInputs.forEach((anggota) => {
            const nama = anggota.querySelector("input[name='anggota_nama[]']");
            const email = anggota.querySelector("input[name='anggota_email[]']");
            const nik = anggota.querySelector("input[name='anggota_nik[]']");
            const nim = anggota.querySelector("input[name='anggota_nim[]']");

            if (!nama.value.trim()) {
                showError(nama, "Nama harus diisi!");
                isValid = false;
            } else if (!nameRegex.test(nama.value.trim())) {
                showError(nama, "Nama hanya boleh mengandung huruf!");
                isValid = false;
            } else {
                clearError(nama);
            }

            if (!email.value.trim()) {
                showError(email, "Email anggota harus diisi!");
                isValid = false;
            } else if (emails.has(email.value)) {
                showError(email, "Email anggota sudah digunakan!");
                isValid = false;
            } else {
                emails.add(email.value);
                checkEmail(email);
            }

            if (!nik.value.trim()) {
                showError(nik, "NIK wajib diisi!");
                isValid = false;
            } else if (nik.value.length !== 16 || !/^\d+$/.test(nik.value)) {
                showError(nik, "NIK harus terdiri dari 16 digit angka!");
                isValid = false;
            } else {
                clearError(nik);
            }

            if (!nim.value.trim()) {
                showError(nim, "NIM/NISN wajib diisi!");
                isValid = false;
            } else if (!(nim.value.length === 10 || nim.value.length === 12) || !/^\d+$/.test(nim.value)) {
                showError(nim, "NIM harus 12 digit dan NISN harus 10 digit!");
                isValid = false;
            } else {
                clearError(nim);
            }
        });

        return isValid;
    }

    function prevStep() {
        if (step2) step2.style.display = "none";
        if (step1) step1.style.display = "block";
        if (nextButton) nextButton.style.display = "inline-block";
        if (submitButton) submitButton.style.display = "none";
        if (anggotaContainer) anggotaContainer.innerHTML = "";
    }

    function nextStep(event) {
        event.preventDefault();
        if (!validateStep1("pengajuanForm")) return;

        const jumlahAnggota = parseInt(jumlahAnggotaInput.value) || 0;
        if (anggotaContainer && anggotaContainer.children.length !== jumlahAnggota - 1) {
            anggotaContainer.innerHTML = "";
            for (let i = 1; i < jumlahAnggota; i++) {
                const anggotaHTML = `
                <div class="mb-3 anggota-group d-flex align-items-center">
                    <span class="me-2 fw-bold">${i + 1}.</span>
                    <div class="row flex-grow-1 gx-2">
                        <div class="col"><input type="text" class="form-control" name="anggota_nama[]" placeholder="Nama"></div>
                        <div class="col"><input type="email" class="form-control anggota-email" name="anggota_email[]" placeholder="Email" onblur="checkEmail(this)"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nik[]" placeholder="NIK"></div>
                        <div class="col"><input type="number" class="form-control" name="anggota_nim[]" placeholder="NIM/NISN"></div>
                    </div>
                </div>`;
                anggotaContainer.insertAdjacentHTML("beforeend", anggotaHTML);
            }
        }

        if (step1) step1.style.display = "none";
        if (step2) step2.style.display = "block";
        if (nextButton) nextButton.style.display = "none";
        if (submitButton) submitButton.style.display = "inline-block";
    }

    const pengajuanForm = document.getElementById("pengajuanForm");
    if (pengajuanForm) {
        pengajuanForm.addEventListener("submit", function(event) {
            if (!validateStep1("pengajuanForm") || !validateAnggota()) {
                event.preventDefault();
            }
        });
    }

    const editForm = document.getElementById("editPengajuanForm");
    if (editForm) {
        editForm.addEventListener("submit", function(event) {
            console.log("Validasi form editPengajuanForm dimulai");
            if (!validateStep1("editPengajuanForm")) {
                console.log("Validasi gagal, form tidak di-submit");
                event.preventDefault();
            } else {
                console.log("Validasi berhasil, form akan di-submit");
            }
        });
    }

    window.nextStep = nextStep;
    window.prevStep = prevStep;
    window.checkEmail = checkEmail;
});
</script>