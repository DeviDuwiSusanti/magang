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
// edit profile
function edit_profile_super_admin_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil Edit Profile Saya",
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
    title: "Gagal Edit Profile Saya",
    text: "Edit Profile Gagal Dilakukan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile_edit.php";
    }
  })
}


// crud tabel instansi
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


function edit_instansi_super_admin_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil",
    text : "Edit Data Instansi Berhasil :)",
    confirmButtonColor : "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_view.php";
    }
  })
}

function edit_instansi_super_admin_gagal() {
  Swal.fire({
    title: "Gagal",
    icon: "error",
    text: "Edit Data Instansi Gagal :(",
    confirmButtonText : "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_edit.php";
    }
  })
}


function confirm_hapus_instansi_super_admin(id_instansi) {
  Swal.fire ({
    title: "Apakah Anda Yakin Ingin Hapus Data Ini?",
    icon: "warning",
    text: "Data yang Anda hapus tidak bisa dikembalikan lagi.",
    confirmButtonText: "YA! Hapus",
    showCancelButton: true,
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_view.php?id_instansi_ini=" + id_instansi;
    }
  });
}


function hapus_instansi_super_admin_success() {
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Data Instansi Berhasil Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_view.php";
    }
  })
}

function hapus_instansi_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Data Instansi Gagal Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi_view.php";
    }
  })
}




// crud tabel user by super admin
function confirm_hapus_user_super_admin(id_user) {
  Swal.fire ({
    title: "Apakah Anda Yakin Ingin Hapus Data Ini?",
    icon: "warning",
    text: "Data yang Anda hapus tidak bisa dikembalikan lagi.",
    confirmButtonText: "YA! Hapus",
    showCancelButton: true,
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_view.php?id_user_ini=" + id_user;
    }
  });
}


function hapus_user_super_admin_success() {
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Data User Berhasil Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_view.php";
    }
  })
}

function hapus_user_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Data User Gagal Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_view.php";
    }
  })
}



function tambah_user_super_admin_success() {
  Swal.fire ({
    title: "Berhasil",
    icon : "success",
    text : "Tambah Admin Instansi Berhasil",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then ((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_view.php";
    }
  })
}


function tambah_user_super_admin_gagal() {
  Swal.fire ({
    title: "Gagal",
    icon : "error",
    text : "Tambah Admin Instansi Gagal",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then ((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_tambah.php";
    }
  })
}


function edit_user_super_admin_success() {
  Swal.fire ({
    title: "Berhasil",
    icon : "success",
    text : "Edit User Berhasil",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then ((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_view.php";
    }
  })
}


function edit_user_super_admin_gagal() {
  Swal.fire ({
    title: "Gagal",
    icon : "error",
    text : "Edit User Gagal",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then ((result) => {
    if(result.isConfirmed) {
      window.location.href = "user_edit.php";
    }
  })
}


// hapus tabel Pengajuan
function hapus_pengajuan_by_super_admin(id_pengajuan) {
  Swal.fire({
    title: "Apakah Anda yakin Ingin Menghapus Pengajuan Ini",
    icon: "warning",
    text: "Data Yang Dihapus Tidak Dapat Dikembalikan Lagi",
    confirmButtonText: "Ya! Hapus",
    confirmButtonColor: "#3085d6",
    cancelButtonColor : "#d33",
    cancelButtonText : "Batal",
    showCancelButton: true,
  }).then((result) =>  {
    if(result.isConfirmed) {
      window.location.href = "pengajuan_view.php?id_pengajuan_ini=" + id_pengajuan;
    }
  })
}


function hapus_pengajuan_super_admin_success() {
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Pengajuan User Berhasil Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pengajuan_view.php";
    }
  })
}

function hapus_pengajuan_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Pengajuan User Gagal Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pengajuan_view.php";
    }
  })
}

// generate admin instansi
function generate_admin_instansi_success(){
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Berhasil Menjadikan Admin Instansi",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin_instansi_view.php";
    }
  })
}

function hapus_pengajuan_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Gagal Menjadikan Admin Instansi",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin_instansi_generate.php";
    }
  })
}