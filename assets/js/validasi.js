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
  document.querySelectorAll("input, textarea, select").forEach((input) => {
    input.addEventListener("input", clearError);
  });
});

function validateEditForm() {
  let isValid = true;

  // Reset semua pesan error sebelum validasi baru
  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // Validasi Nama
  const nama = document.getElementById("nama").value.trim();
  if (nama === "") {
    showError("nama", "nama_error", "Nama tidak boleh kosong.");
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError(
      "nama",
      "nama_error",
      "Nama hanya boleh berisi huruf, spasi, dan simbol ('-)."
    );
    isValid = false;
  }

  // Validasi Tempat Lahir
  const tempatLahir = document.getElementById("tempat_lahir").value.trim();
  if (tempatLahir === "") {
    showError(
      "tempat_lahir",
      "tempat_lahir_error",
      "Tempat lahir tidak boleh kosong."
    );
    isValid = false;
  } else if (!/^[a-zA-Z\s'-]+$/.test(tempatLahir)) {
    showError(
      "tempat_lahir",
      "tempat_lahir_error",
      "Tempat lahir hanya boleh berisi huruf, spasi, dan simbol ('-)."
    );
    isValid = false;
  }

  // Validasi Tanggal Lahir
  const tanggalLahir = document.getElementById("tanggal_lahir").value.trim();
  if (tanggalLahir === "") {
    showError(
      "tanggal_lahir",
      "tanggal_lahir_error",
      "Tanggal lahir tidak boleh kosong."
    );
    isValid = false;
  }

  // Validasi Telepon
  const telepon = document.getElementById("no_telepone").value.trim();
  if (telepon === "") {
    showError(
      "no_telepone",
      "telepon_error",
      "Nomor telepon tidak boleh kosong."
    );
    isValid = false;
  } else if (!/^\d{12,15}$/.test(telepon)) {
    showError(
      "no_telepone",
      "telepon_error",
      "Telepon harus berisi angka (12-15 digit)."
    );
    isValid = false;
  }

  // Validasi Nama Bidang (opsional, hanya jika elemen ada)
  const NimInput = document.getElementById("nim");
  if (NimInput) {
    const Nim = NimInput.value.trim();

    if (Nim === "") {
      showError("nim", "nim_error", "NIM/NISN tidak boleh kosong.");
      isValid = false;
    } else if (!/^(?:\d{10}|\d{12})$/.test(Nim)) {
      showError(
        "nim",
        "nim_error",
        "NIM/NISN harus terdiri dari 10 digit untuk NISN atau 12 digit untuk NIM."
      );
      isValid = false;
    }
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
      showError(
        "image",
        "image_error",
        "Ukuran gambar tidak boleh lebih dari 1MB."
      );
      isValid = false;
    }
    if (!gambar.type.match("image.*")) {
      showError(
        "image",
        "image_error",
        "File yang diupload harus berupa gambar."
      );
      isValid = false;
    }
  }

  return isValid; // Form hanya dikirim jika valid
}

// // Tangkap form yang akan divalidasi
// const form = document.querySelector("#editForm"); // Sesuaikan selector ini dengan form Anda

// // Tambahkan event listener untuk event submit
// form.addEventListener("submit", function (event) {
//   // Panggil fungsi validasi
//   const isValid = validateEditForm();

//   // Jika validasi gagal, hentikan submit form
//   if (!isValid) {
//     event.preventDefault(); // Mencegah form dari pengiriman
//   }
// });

//  Validasi inputan edit instansi
function validateEditInstansi() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  const namaPanjang = document.getElementById("nama_panjang").value.trim();
  if (namaPanjang === "") {
    showError(
      "nama_panjang",
      "nama_panjang_error",
      "Nama panjang instansi tidak boleh kosong."
    );
    isValid = false;
  }

  const namaPendek = document.getElementById("nama_pendek").value.trim();
  if (namaPendek === "") {
    showError(
      "nama_pendek",
      "nama_pendek_error",
      "Nama pendek instansi tidak boleh kosong."
    );
    isValid = false;
  }

  const deskripsiInstansi = document
    .getElementById("deskripsi_instansi")
    .value.trim();
  if (deskripsiInstansi === "") {
    showError(
      "deskripsi_instansi",
      "deskripsi_instansi_error",
      "Deskripsi instansi tidak boleh kosong."
    );
    isValid = false;
  }

  const alamatInstansi = document
    .getElementById("alamat_instansi")
    .value.trim();
  if (alamatInstansi === "") {
    showError(
      "alamat_instansi",
      "alamat_instansi_error",
      "Alamat tidak boleh kosong."
    );
    isValid = false;
  }

  const teleponInstansi = document
    .getElementById("telepone_instansi")
    .value.trim();
  if (teleponInstansi === "") {
    showError(
      "telepone_instansi",
      "telepone_instansi_error",
      "Nomor telepon tidak boleh kosong."
    );
    isValid = false;
  } else if (!/^[0-9]{10,15}$/.test(teleponInstansi)) {
    showError(
      "telepone_instansi",
      "telepone_instansi_error",
      "Nomor telepon harus berisi 10-15 digit angka."
    );
    isValid = false;
  }

  const gambarInput = document.getElementById("gambar_instansi_edit");
  const gambar = gambarInput.files[0];
  if (gambar) {
    if (gambar.size > 1048576) {
      showError(
        "gambar_instansi_edit",
        "gambar_instansi_error",
        "Ukuran gambar tidak boleh lebih dari 1MB."
      );
      isValid = false;
    }
    if (!gambar.type.match("image.*")) {
      showError(
        "gambar_instansi_edit",
        "gambar_instansi_error",
        "File yang diupload harus berupa gambar."
      );
      isValid = false;
    }
  }

  return isValid;
}

// Fungsi validasi input tambah bidang
function validateTambahBidang() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  const namaBidang = document.getElementById("nama_bidang").value.trim();
  if (namaBidang === "") {
    showError(
      "nama_bidang",
      "nama_bidang_error",
      "Nama bidang tidak boleh kosong."
    );
    isValid = false;
  }

  const deskripsi = document.getElementById("deskripsi").value.trim();
  if (deskripsi === "") {
    showError(
      "deskripsi",
      "deskripsi_error",
      "Deskripsi bidang tidak boleh kosong."
    );
    isValid = false;
  }

  const kriteria = document.getElementById("kriteria").value.trim();
  if (kriteria === "") {
    showError("kriteria", "kriteria_error", "Kriteria tidak boleh kosong.");
    isValid = false;
  } else if (!kriteria.includes(",")) {
    showError(
      "kriteria",
      "kriteria_error",
      "Minimal harus ada satu koma untuk memisahkan kriteria."
    );
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
    showError(
      "dokumen",
      "dokumen_error",
      "Dokumen prasyarat tidak boleh kosong."
    );
    isValid = false;
  } else if (!dokumen.includes(",")) {
    showError(
      "dokumen",
      "dokumen_error",
      "Minimal harus ada satu koma untuk memisahkan dokumen prasyarat."
    );
    isValid = false;
  }

  return isValid;
}

// Fungsi validasi input edit bidang
function validateEditBidang() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  const namaBidang = document.getElementById("edit_nama_bidang").value.trim();
  if (namaBidang === "") {
    showError(
      "edit_nama_bidang",
      "edit_nama_bidang_error",
      "Nama bidang tidak boleh kosong."
    );
    isValid = false;
  }

  const deskripsi = document.getElementById("edit_deskripsi").value.trim();
  if (deskripsi === "") {
    showError(
      "edit_deskripsi",
      "edit_deskripsi_error",
      "Deskripsi bidang tidak boleh kosong."
    );
    isValid = false;
  }

  const kriteria = document.getElementById("edit_kriteria").value.trim();
  if (kriteria === "") {
    showError(
      "edit_kriteria",
      "edit_kriteria_error",
      "Kriteria tidak boleh kosong."
    );
    isValid = false;
  } else if (!kriteria.includes(",")) {
    showError(
      "edit_kriteria",
      "edit_kriteria_error",
      "Minimal harus ada satu koma untuk memisahkan kriteria."
    );
    isValid = false;
  }

  const kuota = document.getElementById("edit_kuota").value.trim();
  if (kuota === "") {
    showError("edit_kuota", "edit_kuota_error", "Kuota tidak boleh kosong.");
    isValid = false;
  } else if (isNaN(kuota) || parseInt(kuota) <= 0) {
    showError(
      "edit_kuota",
      "edit_kuota_error",
      "Kuota harus berupa angka positif."
    );
    isValid = false;
  }

  const dokumen = document.getElementById("edit_dokumen").value.trim();
  if (dokumen === "") {
    showError(
      "edit_dokumen",
      "edit_dokumen_error",
      "Dokumen prasyarat tidak boleh kosong."
    );
    isValid = false;
  } else if (!dokumen.includes(",")) {
    showError(
      "edit_dokumen",
      "edit_dokumen_error",
      "Minimal harus ada satu koma untuk memisahkan dokumen prasyarat."
    );
    isValid = false;
  }

  return isValid;
}

// Fungsi validasi input tambah pembimbing
function validateTambahPembimbing() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // Validasi Nama
  const nama = document.getElementById("nama_pembimbing").value.trim();
  if (nama === "") {
    showError("nama_pembimbing", "nama_pembimbing_error", "Nama tidak boleh kosong.");
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError(
      "nama_pembimbing",
      "nama_pembimbing_error",
      "Nama hanya boleh berisi huruf, spasi, dan simbol ('-)."
    );
    isValid = false;
  }

  const email = document.getElementById("email").value.trim();
  if (email === "") {
    showError("email", "email_error", "Email tidak boleh kosong.");
    isValid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    showError("email", "email_error", "Format email tidak valid.");
    isValid = false;
  }

  const nik = document.getElementById("nik_pembimbing").value.trim();
  if (nik === "") {
    showError("nik_pembimbing", "nik_pembimbing_error", "NIK tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{16}$/.test(nik)) {
    showError(
      "nik_pembimbing",
      "nik_pembimbing_error",
      "NIK harus terdiri dari 16 digit angka."
    );
    isValid = false;
  }

  const nip = document.getElementById("nip").value.trim();
  if (nip === "") {
    showError("nip", "nip_error", "NIP tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{18}$/.test(nip)) {
    showError(
      "nip",
      "nip_error",
      "NIP harus terdiri dari 18 digit angka."
    );
    isValid = false;
  }

  const jabatan = document.getElementById("jabatan").value.trim();
  if (jabatan === "") {
    showError("jabatan", "jabatan_error", "Jabatan tidak boleh kosong.");
    isValid = false;
  }

  const genderL = document.getElementById("gender_l").checked;
  const genderP = document.getElementById("gender_p").checked;
  if (!genderL && !genderP) {
    showError("gender_p", "gender_error", "Jenis kelamin harus dipilih.");
    isValid = false;
  }

  const telepon = document.getElementById("telepone_pembimbing").value.trim();
  if (telepon === "") {
    showError("telepone_pembimbing", "telepone_error", "Nomor telepon tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{11,12}$/.test(telepon)) {
    showError("edit_telepone_pembimbing", "telepone_error", "Nomor telepon harus terdiri dari 11-12 digit angka.");
    isValid = false;
  }

  const bidang = document.getElementById("id_bidang").value;
  if (bidang === "") {
    showError("id_bidang", "bidang_error", "Bidang harus dipilih.");
    isValid = false;
  }

  return isValid;
}

// Fungsi validasi input edit pembimbing
function validateEditPembimbing() {
  let isValid = true;

  // Reset pesan error sebelumnya
  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // Validasi Nama
  const nama = document.getElementById("edit_nama_pembimbing").value.trim();
  if (nama === "") {
    showError("edit_nama_pembimbing", "edit_nama_pembimbing_error", "Nama tidak boleh kosong.");
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError("edit_nama_pembimbing", "edit_nama_pembimbing_error", "Nama hanya boleh berisi huruf, spasi, dan simbol ('-).");
    isValid = false;
  }

  const nik = document.getElementById("edit_nik_pembimbing").value.trim();
  if (nik === "") {
    showError("edit_nik_pembimbing", "edit_nik_pembimbing_error", "NIK tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{16}$/.test(nik)) {
    showError("edit_nik_pembimbing", "edit_nik_pembimbing_error", "NIK harus terdiri dari 16 digit angka.");
    isValid = false;
  }

  const nip = document.getElementById("edit_nip").value.trim();
  if (nip === "") {
    showError("edit_nip", "edit_nip_error", "NIP tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{18}$/.test(nip)) {
    showError("edit_nip", "edit_nip_error", "NIP harus terdiri dari 18 digit angka.");
    isValid = false;
  }

  const jabatan = document.getElementById("edit_jabatan").value.trim();
  if (jabatan === "") {
    showError("edit_jabatan", "edit_jabatan_error", "Jabatan tidak boleh kosong.");
    isValid = false;
  }

  const telepon = document.getElementById("edit_telepone_pembimbing").value.trim();
  if (telepon === "") {
    showError("edit_telepone_pembimbing", "edit_telepone_error", "Nomor telepon tidak boleh kosong.");
    isValid = false;
  } else if (!/^[0-9]{11,12}$/.test(telepon)) {
    showError("edit_telepone_pembimbing", "edit_telepone_error", "Nomor telepon harus terdiri dari 11-12 digit angka.");
    isValid = false;
  }

  const bidang = document.getElementById("edit_bidang").value;
  if (bidang === "") {
    showError("edit_bidang", "edit_bidang_error", "Bidang harus dipilih.");
    isValid = false;
  }

  return isValid;
}

// Fungsi validasi input informasi zoom
function validateZoomForm() {
  let isValid = true;

  // Reset pesan error
  document.querySelectorAll(".text-danger").forEach((el) => (el.textContent = ""));

  // Ambil nilai
  const tanggal = document.getElementById("tanggal_pelaksanaan").value.trim();
  const jam = document.getElementById("jam_pelaksanaan").value.trim();
  const pembimbing = document.getElementById("pembimbing").value.trim();
  const linkZoom = document.getElementById("link_zoom").value.trim();

  // Validasi Tanggal
  if (tanggal === "") {
    showError("tanggal_pelaksanaan", "tanggal_pelaksanaan_error", "Tanggal pelaksanaan tidak boleh kosong.");
    isValid = false;
  }

  // Validasi Jam
  if (jam === "") {
    showError("jam_pelaksanaan", "jam_pelaksanaan_error", "Jam pelaksanaan tidak boleh kosong.");
    isValid = false;
  }

  // Validasi Pembimbing
  if (pembimbing === "") {
    showError("pembimbing", "pembimbing_error", "Pilih pembimbing terlebih dahulu.");
    isValid = false;
  }

  // Validasi Link Zoom
  if (linkZoom === "") {
    showError("link_zoom", "link_zoom_error", "Link Zoom tidak boleh kosong.");
    isValid = false;
  } else if (!/^https?:\/\/.+/.test(linkZoom)) {
    showError("link_zoom", "link_zoom_error", "Format link Zoom tidak valid.");
    isValid = false;
  }

  return isValid;
}
