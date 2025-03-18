// Fungsi untuk menampilkan error
function showError(inputId, errorId, message) {
  const inputElement = document.getElementById(inputId);
  const errorElement = document.getElementById(errorId);
  
  if (errorElement) {
    errorElement.textContent = message;
    inputElement.focus();
    inputElement.scrollIntoView({ behavior: "smooth", block: "center" });
  }
}

// Fungsi untuk menghapus error ketika user mulai mengetik
function clearError(event) {
  const input = event.target;
  const errorId = input.dataset.errorId;
  const errorElement = document.getElementById(errorId);
  
  if (errorElement) {
    errorElement.textContent = "";
  }
}

// Tambahkan event listener ke semua input dan textarea agar error dihapus saat user mengetik
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("input, textarea, select").forEach(input => {
    input.addEventListener("input", clearError);
  });
});

function validateEditForm() {
  let isValid = true;

  // Reset semua pesan error sebelum validasi baru
  document.querySelectorAll(".text-danger").forEach(el => el.textContent = "");

  // Validasi Nama
  const nama = document.getElementById("nama").value.trim();
  if (nama === "") {
    showError("nama", "nama_error", "Nama tidak boleh kosong.");
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError("nama", "nama_error", "Nama hanya boleh berisi huruf, spasi, dan simbol (.,'-).");
    isValid = false;
  }

  // Validasi Tempat Lahir
  const tempatLahir = document.getElementById("tempat_lahir").value.trim();
  if (tempatLahir === "") {
    showError("tempat_lahir", "tempat_lahir_error", "Tempat lahir tidak boleh kosong.");
    isValid = false;
  } else if (!/^[a-zA-Z\s'-]+$/.test(tempatLahir)) {
    showError("tempat_lahir", "tempat_lahir_error", "Tempat lahir hanya boleh berisi huruf, spasi, dan simbol ('-).");
    isValid = false;
  }

  // Validasi Tanggal Lahir
  const tanggalLahir = document.getElementById("tanggal_lahir").value.trim();
  if (tanggalLahir === "") {
    showError("tanggal_lahir", "tanggal_lahir_error", "Tanggal lahir tidak boleh kosong.");
    isValid = false;
  }

  // Validasi Telepon
  const telepon = document.getElementById("no_telepone").value.trim();
  if (telepon === "") {
    showError("no_telepone", "telepon_error", "Nomor telepon tidak boleh kosong.");
    isValid = false;
  } else if (!/^\d{12,15}$/.test(telepon)) {
    showError("no_telepone", "telepon_error", "Telepon harus berisi angka (12-15 digit).");
    isValid = false;
  }

  // Validasi Alamat
  const alamat = document.getElementById("alamat").value.trim();
  if (alamat === "") {
    showError("alamat", "alamat_error", "Alamat tidak boleh kosong.");
    isValid = false;
  }

  // Validasi Gambar
  const gambarInput = document.getElementById("image");
  const gambar = gambarInput.files[0];
  if (gambar) {
    if (gambar.size > 1048576) {
      showError("image", "image_error", "Ukuran gambar tidak boleh lebih dari 1MB.");
      isValid = false;
    }
    if (!gambar.type.match("image.*")) {
      showError("image", "image_error", "File yang diupload harus berupa gambar.");
      isValid = false;
    }
  }

  return isValid; // Form hanya dikirim jika valid
}


//  Validasi inputan edit instansi
function validateEditInstansi() {
  let isValid = true;

  document.querySelectorAll(".text-danger").forEach(el => el.textContent = "");

  const namaPanjang = document.getElementById("nama_panjang").value.trim();
  if (namaPanjang === "") {
      showError("nama_panjang", "nama_panjang_error", "Nama panjang instansi tidak boleh kosong.");
      isValid = false;
  }

  const namaPendek = document.getElementById("nama_pendek").value.trim();
  if (namaPendek === "") {
      showError("nama_pendek", "nama_pendek_error", "Nama pendek instansi tidak boleh kosong.");
      isValid = false;
  }

  const deskripsiInstansi = document.getElementById("deskripsi_instansi").value.trim();
  if (deskripsiInstansi === "") {
      showError("deskripsi_instansi", "deskripsi_instansi_error", "Deskripsi instansi tidak boleh kosong.");
      isValid = false;
  }

  const alamatInstansi = document.getElementById("alamat_instansi").value.trim();
  if (alamatInstansi === "") {
      showError("alamat_instansi", "alamat_instansi_error", "Alamat tidak boleh kosong.");
      isValid = false;
  }

  const teleponInstansi = document.getElementById("telepone_instansi").value.trim();
  if (teleponInstansi === "") {
      showError("telepone_instansi", "telepone_instansi_error", "Nomor telepon tidak boleh kosong.");
      isValid = false;
  } else if (!/^[0-9]{10,15}$/.test(teleponInstansi)) {
      showError("telepone_instansi", "telepone_instansi_error", "Nomor telepon harus berisi 10-15 digit angka.");
      isValid = false;
  }

  const gambarInput = document.getElementById("gambar_instansi_edit");
  const gambar = gambarInput.files[0];
  if (gambar) {
      if (gambar.size > 1048576) {
          showError("gambar_instansi_edit", "gambar_instansi_error", "Ukuran gambar tidak boleh lebih dari 1MB.");
          isValid = false;
      }
      if (!gambar.type.match("image.*")) {
          showError("gambar_instansi_edit", "gambar_instansi_error", "File yang diupload harus berupa gambar.");
          isValid = false;
      }
  }

  return isValid;
}


// Fungsi validasi input tambah bidang
function validateTambahBidang() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document.querySelectorAll(".text-danger").forEach(el => el.textContent = "");

  const namaBidang = document.getElementById("nama_bidang").value.trim();
  if (namaBidang === "") {
      showError("nama_bidang", "nama_bidang_error", "Nama bidang tidak boleh kosong.");
      isValid = false;
  }

  const deskripsi = document.getElementById("deskripsi").value.trim();
  if (deskripsi === "") {
      showError("deskripsi", "deskripsi_error", "Deskripsi bidang tidak boleh kosong.");
      isValid = false;
  }

  const kriteria = document.getElementById("kriteria").value.trim();
  if (kriteria === "") {
      showError("kriteria", "kriteria_error", "Kriteria tidak boleh kosong.");
      isValid = false;
  } else if (!kriteria.includes(",")) {
      showError("kriteria", "kriteria_error", "Minimal harus ada satu koma untuk memisahkan kriteria.");
      isValid = false;
  }

  const kuota = document.getElementById("kuota").value.trim();
  if (kuota === "") {
      showError("kuota", "kuota_error", "Kuota tidak boleh kosong.");
      isValid = false;
  } else if (isNaN(kuota) || parseInt(kuota) <= 0) {
      showError("kuota", "kuota_error", "Kuota harus berupa angka positif.");
      isValid = false;
  }

  const dokumen = document.getElementById("dokumen").value.trim();
  if (dokumen === "") {
      showError("dokumen", "dokumen_error", "Dokumen prasyarat tidak boleh kosong.");
      isValid = false;
  } else if (!dokumen.includes(",")) {
      showError("dokumen", "dokumen_error", "Minimal harus ada satu koma untuk memisahkan dokumen prasyarat.");
      isValid = false;
  }

  return isValid;
}


// Fungsi validasi input edit bidang
function validateEditBidang() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document.querySelectorAll(".text-danger").forEach(el => el.textContent = "");

  const namaBidang = document.getElementById("edit_nama_bidang").value.trim();
  if (namaBidang === "") {
      showError("edit_nama_bidang", "edit_nama_bidang_error", "Nama bidang tidak boleh kosong.");
      isValid = false;
  }

  const deskripsi = document.getElementById("edit_deskripsi").value.trim();
  if (deskripsi === "") {
      showError("edit_deskripsi", "edit_deskripsi_error", "Deskripsi bidang tidak boleh kosong.");
      isValid = false;
  }

  const kriteria = document.getElementById("edit_kriteria").value.trim();
  if (kriteria === "") {
      showError("edit_kriteria", "edit_kriteria_error", "Kriteria tidak boleh kosong.");
      isValid = false;
  } else if (!kriteria.includes(",")) {
      showError("edit_kriteria", "edit_kriteria_error", "Minimal harus ada satu koma untuk memisahkan kriteria.");
      isValid = false;
  }

  const kuota = document.getElementById("edit_kuota").value.trim();
  if (kuota === "") {
      showError("edit_kuota", "edit_kuota_error", "Kuota tidak boleh kosong.");
      isValid = false;
  } else if (isNaN(kuota) || parseInt(kuota) <= 0) {
      showError("edit_kuota", "edit_kuota_error", "Kuota harus berupa angka positif.");
      isValid = false;
  }

  const dokumen = document.getElementById("edit_dokumen").value.trim();
  if (dokumen === "") {
      showError("edit_dokumen", "edit_dokumen_error", "Dokumen prasyarat tidak boleh kosong.");
      isValid = false;
  } else if (!dokumen.includes(",")) {
      showError("edit_dokumen", "edit_dokumen_error", "Minimal harus ada satu koma untuk memisahkan dokumen prasyarat.");
      isValid = false;
  }

  return isValid;
}