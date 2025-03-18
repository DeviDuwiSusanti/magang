function validateEditForm() {
  let nama = document.getElementById("nama").value;
  let tempatLahir = document.getElementById("tempat_lahir").value;
  let tanggalLahir = document.getElementById("tanggal_lahir").value;
  let telepon = document.getElementById("no_telepone").value;
  let alamat = document.getElementById("alamat").value;
  let gambar = document.getElementById("image").files[0];
  let isValid = true;

  // Reset semua pesan error
  document.querySelectorAll(".text-danger").forEach(function (el) {
    el.textContent = "";
  });

  // Validasi Nama
  if (!/^[a-zA-Z\s.,'-]+$/.test(nama)) {
    document.getElementById("nama_error").textContent =
      "Nama hanya boleh berisi huruf, spasi, dan simbol (.,'-).";
    document.getElementById("nama").focus(); // Fokus ke input nama
    document
      .getElementById("nama")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input nama
    return false;
  }

  // Validasi Tempat Lahir
  if (tempatLahir.trim() === "") {
    document.getElementById("tempat_lahir_error").textContent =
      "Tempat lahir tidak boleh kosong.";
    document.getElementById("tempat_lahir").focus(); // Fokus ke input tempat lahir
    document
      .getElementById("tempat_lahir")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input tempat lahir
    return false;
  } else if (!/^[a-zA-Z\s'-]+$/.test(tempatLahir)) {
    document.getElementById("tempat_lahir_error").textContent =
      "Tempat lahir hanya boleh berisi huruf, spasi, dan simbol ('-).";
    document.getElementById("tempat_lahir").focus(); // Fokus ke input tempat lahir
    document
      .getElementById("tempat_lahir")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input tempat lahir
    return false;
  }

  // Validasi Tanggal Lahir
  if (tanggalLahir.trim() === "") {
    document.getElementById("tanggal_lahir_error").textContent =
      "Tanggal lahir tidak boleh kosong.";
    document.getElementById("tanggal_lahir").focus(); // Fokus ke input tanggal lahir
    document
      .getElementById("tanggal_lahir")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input tanggal lahir
    return false;
  }

  // Validasi Telepon
  if (telepon.trim() === "") {
    document.getElementById("telepon_error").textContent =
      "Nomor telepon tidak boleh kosong.";
    document.getElementById("no_telepone").focus(); // Fokus ke input telepon
    document
      .getElementById("no_telepone")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input telepon
    return false;
  } else if (!/^\d{8,15}$/.test(telepon)) {
    document.getElementById("telepon_error").textContent =
      "Telepon hanya boleh berisi angka (8-15 digit).";
    document.getElementById("no_telepone").focus(); // Fokus ke input telepon
    document
      .getElementById("no_telepone")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input telepon
    return false;
  }

  // Validasi Alamat
  if (alamat.trim() === "") {
    document.getElementById("alamat_error").textContent =
      "Alamat tidak boleh kosong.";
    document.getElementById("alamat").focus(); // Fokus ke input alamat
    document
      .getElementById("alamat")
      .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input alamat
    return false;
  }

  // Validasi Gambar
  if (gambar) {
    if (gambar.size > 1048576) {
      // 1MB
      document.getElementById("image_error").textContent =
        "Ukuran gambar tidak boleh lebih dari 1MB.";
      document.getElementById("image").focus(); // Fokus ke input gambar
      document
        .getElementById("image")
        .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input gambar
      return false;
    }
    if (!gambar.type.match("image.*")) {
      document.getElementById("image_error").textContent =
        "File yang diupload harus berupa gambar.";
      document.getElementById("image").focus(); // Fokus ke input gambar
      document
        .getElementById("image")
        .scrollIntoView({ behavior: "smooth", block: "center" }); // Scroll ke input gambar
      return false;
    }
  }

  return isValid;
}
