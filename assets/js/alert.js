function showDeleteConfirmation(
  linkHref,
  message = "Kamu tidak bisa mengembalikan data ini!",
  successMessage = "Data berhasil dihapus."
) {
  Swal.fire({
    title: "Yakin?",
    text: message,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Terhapus!", successMessage, "success").then(() => {
        if (linkHref) {
          window.location.href = linkHref;
        }
      });
    }
  });
}

// Ekspor ke global scope
window.showDeleteConfirmation = showDeleteConfirmation;

// Alert edit profile
function alertEdit(successMessage = "Data berhasil diperbarui.") {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: successMessage,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  })
}

// Ekspor ke global scope
window.alertEdit = alertEdit;

// ALert tambah
function alertTambah(linkHref, successMessage = "Data berhasil ditambahkan.") {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: successMessage,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if (result.isConfirmed) {
      if (linkHref) {
        window.location.href = linkHref;
      }
    }
  });
}

// Ekspor ke global scope
window.alertTambah = alertTambah;

// Alert berhasil register
function alertSuccessRegister(message, redirectUrl) {
  Swal.fire({
    title: "Berhasil!",
    text: message,
    icon: "success",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if (result.isConfirmed && redirectUrl) {
      window.location.href = redirectUrl;
    }
  });
}

// Ekspor ke global scope
window.alertSuccessRegister = alertSuccessRegister;

function alertErrorRegister(message) {
  Swal.fire({
      title: 'Gagal!',
      text: message,
      icon: 'error',
      confirmButtonText: 'Coba Lagi'
  });
}

// Ekspor ke global scope 
window.alertErrorRegister = alertErrorRegister;

function alertSuccessEdit(message, redirectUrl) {
  Swal.fire({
    title: "Berhasil!",
    text: message,
    icon: "success",
    confirmButtonColor: "#4e73df",
    confirmButtonText: "OK",
  }).then((result) => {
    if (result.isConfirmed && redirectUrl) {
      window.location.href = redirectUrl;
    }
  });
}




// =================================== SWEET ALERT SUPER ADMIN LEVEL(1) =======================================
function edit_profile_super_admin_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil",
    text: "Edit Profile Berhasil Dilakukan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile_view.php";
    }
  })
}

function edit_profile_super_admin_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "Edit Profile Gagal Dilakukan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile_edit.php";
    }
  })
}

function tambah_instansi_super_admin_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil",
    text: "Tambah Instansi Berhasil Dilakukan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_view.php";
    }
  })
}


function tambah_instansi_super_admin_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "Tambah Instansi Gagal Dilakukan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_tambah.php";
    }
  })
}




