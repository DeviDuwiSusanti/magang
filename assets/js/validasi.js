/*===================================================================================
                          Fungsi untuk menampilkan error
===================================================================================*/
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

/*===================================================================================
                          Fungsi untuk menghapus error
===================================================================================*/
function clearError(event) {
  const input = event.target;
  const errorId = input.dataset.errorId;
  const errorElement = document.getElementById(errorId);

  if (errorElement) {
    errorElement.textContent = "";
  }
}

/*===================================================================================
                          Fungsi untuk mengambil value
===================================================================================*/
function getValue(id) {
  const element = document.getElementById(id);
  if (element.classList.contains("summernote")) {
    return $("#" + id)
      .summernote("code")
      .replace(/<[^>]*>?/gm, "")
      .trim();
  } else {
    return element.value.trim();
  }
}

// Tambahkan event listener ke semua input dan textarea agar error dihapus saat user mengetik
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("input, textarea, select").forEach((input) => {
    input.addEventListener("input", clearError);
  });

  // Tambahkan ini untuk Summernote
  i;
  if (typeof $ !== "undefined" && typeof $.fn.summernote !== "undefined") {
    $(".summernote").on(
      "summernote.change",
      function (we, contents, $editable) {
        const errorId = this.dataset.errorId;
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
          errorElement.textContent = "";
        }
      }
    );
  }
});

/*===================================================================================
                          Validasi Form Edit Instansi
===================================================================================*/
function validateEditInstansi() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // validasi input nama panjang instansi
  const namaPanjang = document.getElementById("nama_panjang").value.trim();
  if (namaPanjang === "") {
    showError(
      "nama_panjang",
      "nama_panjang_error",
      "Nama panjang instansi tidak boleh kosong."
    );
    isValid = false;
  }

  // validasi input nama pendek instansi
  const namaPendek = document.getElementById("nama_pendek").value.trim();
  if (namaPendek === "") {
    showError(
      "nama_pendek",
      "nama_pendek_error",
      "Nama pendek instansi tidak boleh kosong."
    );
    isValid = false;
  }

  // validasi input deskripsi instansi
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

  // validasi input alamat instansi
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

  // validasi input telepon instansi
  const phoneRegex = /^[0-9\s\+\-\.\(\)]+$/;

  const teleponInstansi = document
    .getElementById("telepone_instansi")
    .value.trim();

  const cleanValue = teleponInstansi.replace(/(<([^>]+)>)/gi, "").trim();

  if (cleanValue === "") {
    showError(
      "telepone_instansi",
      "telepone_instansi_error",
      "Nomor telepon tidak boleh kosong."
    );
    isValid = false;
  } else if (!phoneRegex.test(cleanValue)) {
    showError(
      "telepone_instansi",
      "telepone_instansi_error",
      "Nomor telepon hanya boleh berisi angka, spasi, tanda hubung (-), titik (.), atau tanda kurung."
    );
    isValid = false;
  } else {
    const numericOnly = cleanValue.replace(/\D/g, "");

    if (numericOnly.length < 8 || numericOnly.length > 15) {
      showError(
        "telepone_instansi",
        "telepone_instansi_error",
        "Nomor telepon harus terdiri dari 8 - 15 digit angka."
      );
      isValid = false;
    }
  }

  // Validasi gambar instansi
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

/*===================================================================================
                          Validasi Form Tambah Bidang
===================================================================================*/
function validateTambahBidang() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // validasi input nama bidang
  const namaBidang = document.getElementById("nama_bidang").value.trim();
  if (namaBidang === "") {
    showError(
      "nama_bidang",
      "nama_bidang_error",
      "Nama bidang tidak boleh kosong."
    );
    isValid = false;
  } else {
    const namaBidangLower = namaBidang.toLowerCase();
    const existingLower = existingNamaBidang.map((nama) => nama.toLowerCase());

    if (existingLower.includes(namaBidangLower)) {
      Swal.fire({
        icon: "error",
        title: "Nama Bidang Sudah Ada!",
        text: "Silakan gunakan nama bidang lain.",
      });
      isValid = false;
    }
  }

  // validasi input NIP pejabat
  const nip = document.getElementById("nip").value.trim();
  if (nip !== "" && !/^[0-9]{18}$/.test(nip)) {
    showError("nip", "nip_error", "NIP harus terdiri dari 18 digit angka.");
    isValid = false;
  }

  // validasi input deskripsi bidang
  const deskripsi = document.getElementById("deskripsi").value.trim();
  if (deskripsi === "") {
    showError(
      "deskripsi",
      "deskripsi_error",
      "Deskripsi bidang tidak boleh kosong."
    );
    isValid = false;
  }

  // validasi input kriteria bidang
  const kriteria = document.getElementById("kriteria").value.trim();
  if (kriteria === "") {
    showError("kriteria", "kriteria_error", "Kriteria tidak boleh kosong.");
    isValid = false;
  }

  // validasi input kuota bidang
  const kuota = document.getElementById("kuota").value.trim();
  if (kuota !== "") {
    if (isNaN(kuota) || parseInt(kuota) <= 0) {
      showError("kuota", "kuota_error", "Kuota harus berupa angka positif.");
      isValid = false;
    }
  }

  // validasi input dokumen bidang
  const dokumen = document.getElementById("dokumen").value.trim();
  if (dokumen === "") {
    showError(
      "dokumen",
      "dokumen_error",
      "Dokumen prasyarat tidak boleh kosong."
    );
    isValid = false;
  }

  return isValid;
}

/*===================================================================================
                          Validasi Form Edit Bidang
===================================================================================*/
function validateEditBidang() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // validasi input nama bidang
  const namaBidang = document.getElementById("edit_nama_bidang").value.trim();
  const oldNamaBidang = document
    .getElementById("edit_bidang_lama")
    .value.trim();

  if (namaBidang === "") {
    showError(
      "edit_nama_bidang",
      "edit_nama_bidang_error",
      "Nama bidang tidak boleh kosong."
    );
    isValid = false;
  } else if (namaBidang !== oldNamaBidang) {
    const namaBidangLower = namaBidang.toLowerCase();
    const existingLower = existingNamaBidang.map((bidang) =>
      bidang.toLowerCase()
    );
    if (existingLower.includes(namaBidangLower)) {
      Swal.fire({
        icon: "error",
        title: "Nama Bidang Sudah Ada!",
        text: "Silakan gunakan nama bidang lain.",
      });
      isValid = false;
    }
  }

  // validasi input NIP pejabat
  const nip = document.getElementById("edit_nip").value.trim();
  if (nip !== "" && !/^[0-9]{18}$/.test(nip)) {
    showError("edit_nip", "edit_nip_error", "NIP harus terdiri dari 18 digit angka.");
    isValid = false;
  }

  // validasi input deskripsi bidang
  const deskripsi = document.getElementById("edit_deskripsi").value.trim();
  if (deskripsi === "") {
    showError(
      "edit_deskripsi",
      "edit_deskripsi_error",
      "Deskripsi bidang tidak boleh kosong."
    );
    isValid = false;
  }

  // validasi input kriteria bidang
  const kriteria = document.getElementById("edit_kriteria").value.trim();
  if (kriteria === "") {
    showError(
      "edit_kriteria",
      "edit_kriteria_error",
      "Kriteria tidak boleh kosong."
    );
    isValid = false;
  }

  // validasi input kuota bidang
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

  // validasi input dokumen bidang
  const dokumen = document.getElementById("edit_dokumen").value.trim();
  if (dokumen === "") {
    showError(
      "edit_dokumen",
      "edit_dokumen_error",
      "Dokumen prasyarat tidak boleh kosong."
    );
    isValid = false;
  }

  return isValid;
}

/*===================================================================================
                          Validasi Form Tambah Pembimbing
===================================================================================*/
function validateTambahPembimbing() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // validasi input nama pembimbing
  const nama = document.getElementById("nama_pembimbing").value.trim();
  if (nama === "") {
    showError(
      "nama_pembimbing",
      "nama_pembimbing_error",
      "Nama tidak boleh kosong."
    );
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError(
      "nama_pembimbing",
      "nama_pembimbing_error",
      "Nama hanya boleh berisi huruf, spasi, dan simbol ('-)."
    );
    isValid = false;
  }

  // validasi input email pembimbing
  const email = document.getElementById("email").value.trim();

  if (email === "") {
    showError("email", "email_error", "Email tidak boleh kosong.");
    isValid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    showError("email", "email_error", "Format email tidak valid.");
    isValid = false;
  } else {
    const emailPembimbing = email.toLowerCase();
    const existingLower = existingDataPembimbing.map((pembimbing) =>
      pembimbing.email.toLowerCase()
    );
    if (existingLower.includes(emailPembimbing)) {
      Swal.fire({
        icon: "error",
        title: "Email Sudah Terdaftar!",
        text: "Silakan gunakan email lain.",
      });
      isValid = false;
    }
  }

  // validasi input NIK pembimbing
  const nik = document.getElementById("nik_pembimbing").value.trim();
  if (nik !== "" && !/^[0-9]{16}$/.test(nik)) {
    showError(
      "nik_pembimbing",
      "nik_pembimbing_error",
      "NIK harus terdiri dari 16 digit angka."
    );
    isValid = false;
  }

  // validasi input NIP pembimbing
  const nip = document.getElementById("nip").value.trim();
  if (nip !== "" && !/^[0-9]{18}$/.test(nip)) {
    showError("nip", "nip_error", "NIP harus terdiri dari 18 digit angka.");
    isValid = false;
  }

  // validasi input jenis kelamin pembimbing
  const genderL = document.getElementById("gender_l").checked;
  const genderP = document.getElementById("gender_p").checked;
  if (!genderL && !genderP) {
    showError("gender_p", "gender_error", "Jenis kelamin harus dipilih.");
    isValid = false;
  }

  // validasi input telepon pembimbing
  const telepon = document.getElementById("telepone_pembimbing").value.trim();
  if (telepon !== "" && !/^[0-9]{11,13}$/.test(telepon)) {
    showError(
      "edit_telepone_pembimbing",
      "telepone_error",
      "Nomor telepon harus terdiri dari 11-13 digit angka."
    );
    isValid = false;
  }

  // validasi input bidang pembimbing
  const bidang = document.getElementById("id_bidang").value;
  if (bidang === "") {
    showError("id_bidang", "bidang_error", "Bidang harus dipilih.");
    isValid = false;
  }

  return isValid;
}

/*===================================================================================
                          Validasi Form Edit Pembimbing
===================================================================================*/
function validateEditPembimbing() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // validasi input nama pembimbing
  const nama = document.getElementById("edit_nama_pembimbing").value.trim();
  if (nama === "") {
    showError(
      "edit_nama_pembimbing",
      "edit_nama_pembimbing_error",
      "Nama tidak boleh kosong."
    );
    isValid = false;
  } else if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    showError(
      "edit_nama_pembimbing",
      "edit_nama_pembimbing_error",
      "Nama hanya boleh berisi huruf, spasi, dan simbol ('-)."
    );
    isValid = false;
  }

  // validasi input email pembimbing
  const email = document.getElementById("edit_email").value.trim();
  const oldEmail = document.getElementById("edit_email_lama").value.trim();

  if (email === "") {
    showError("edit_email", "edit_email_error", "Email tidak boleh kosong.");
    isValid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    showError("edit_email", "edit_email_error", "Format email tidak valid.");
    isValid = false;
  } else if (email.toLowerCase() !== oldEmail.toLowerCase()) {
    const existingEmails = existingDataPembimbing
      .filter((p) => p.email.toLowerCase() !== oldEmail.toLowerCase())
      .map((p) => p.email.toLowerCase());

    if (existingEmails.includes(email.toLowerCase())) {
      Swal.fire("Error", "Email sudah digunakan oleh pembimbing lain", "error");
      isValid = false;
    }
  }

  // validasi input NIK pembimbing
  const nik = document.getElementById("edit_nik_pembimbing").value.trim();
  if (nik !== "" && !/^[0-9]{16}$/.test(nik)) {
    showError(
      "edit_nik_pembimbing",
      "edit_nik_pembimbing_error",
      "NIK harus terdiri dari 16 digit angka."
    );
    isValid = false;
  }

  // validasi input NIP pembimbing
  const nip = document.getElementById("edit_nip").value.trim();
  if (nip !== "" && !/^[0-9]{18}$/.test(nip)) {
    showError(
      "edit_nip",
      "edit_nip_error",
      "NIP harus terdiri dari 18 digit angka."
    );
    isValid = false;
  }

  // validasi input jenis kelamin pembimbing
  const telepon = document
    .getElementById("edit_telepone_pembimbing")
    .value.trim();
  if (telepon !== "" && !/^[0-9]{11,13}$/.test(telepon)) {
    showError(
      "edit_telepone_pembimbing",
      "edit_telepone_error",
      "Nomor telepon harus terdiri dari 11-13 digit angka."
    );
    isValid = false;
  }

  // validasi input bidang pembimbing
  const bidang = document.getElementById("edit_bidang").value;
  if (bidang === "") {
    showError("edit_bidang", "edit_bidang_error", "Bidang harus dipilih.");
    isValid = false;
  }

  return isValid;
}

/*===================================================================================
                          Validasi Form Zoom
===================================================================================*/
function validateZoomForm() {
  let isValid = true;

  document
    .querySelectorAll(".text-danger")
    .forEach((el) => (el.textContent = ""));

  // Ambil nilai input dari form Zoom
  const tanggal = document.getElementById("tanggal_pelaksanaan").value.trim();
  const jam = document.getElementById("jam_pelaksanaan").value.trim();
  const linkZoom = document.getElementById("link_zoom").value.trim();

  // Validasi Tanggal Pelaksanaan
  if (tanggal === "") {
    showError(
      "tanggal_pelaksanaan",
      "tanggal_pelaksanaan_error",
      "Tanggal pelaksanaan tidak boleh kosong."
    );
    isValid = false;
  }

  // Validasi Jam Pelaksanaan
  if (jam === "") {
    showError(
      "jam_pelaksanaan",
      "jam_pelaksanaan_error",
      "Jam pelaksanaan tidak boleh kosong."
    );
    isValid = false;
  }

  // Validasi Link Meeting (Zoom atau Gmeet)
  if (linkZoom === "") {
    showError(
      "link_zoom",
      "link_zoom_error",
      "Link meeting tidak boleh kosong."
    );
    isValid = false;
  } else if (
    !/^https?:\/\/(www\.)?(zoom\.us|meet\.google\.com)\/.+/.test(linkZoom)
  ) {
    showError(
      "link_zoom",
      "link_zoom_error",
      "Link meeting harus berasal dari zoom.us atau meet.google.com."
    );
    isValid = false;
  }

  return isValid;
}
