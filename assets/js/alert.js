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

// Edit profile admin instansi
function edit_profile_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data profile berhasil diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile.php";
    }
  })
}

function edit_profile_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data profile gagal diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile.php";
    }
  })
}

// Edit instansi admin instansi
function edit_instansi_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data instansi berhasil diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi.php";
    }
  })
}

function edit_instansi_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data instansi gagal diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "instansi.php";
    }
  })
}

// Tambah bidang admin instansi
function tambah_bidang_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data bidang berhasil ditambahkan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

function tambah_bidang_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data bidang gagal ditambahkan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

// Edit bidang admin instansi
function edit_bidang_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data bidang berhasil diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

function edit_bidang_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data bidang gagal diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

// Hapus bidang admin instansi
function hapus_bidang_admin_instansi(id_bidang) {
  Swal.fire({
    title: "Apakah Anda yakin?",
    icon: "warning",
    text: "Data bidang akan dihapus!",
    confirmButtonText: "Ya! Hapus",
    showCancelButton: true,
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php?id_bidang_ini=" + id_bidang;
    }
  });
}

function hapus_bidang_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data bidang berhasil dihapus",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

function hapus_bidang_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data bidang gagal dihapus",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "bidang.php";
    }
  })
}

// alert tidak ada perubahan profil
function tidak_ada_perubahan_profile() {
  Swal.fire({
    icon: "info",
    title: "Tidak Ada Perubahan!",
    text: "Data profile telah disimpan.",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "profile.php";
    }
  })
}

// Logout admin instansi
function logout_admin_instansi() {
  Swal.fire({
    title: "Apakah Anda yakin ingin logout?",
    text: "Anda harus login kembali untuk mengakses sistem.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, Logout",
    cancelButtonText: "Batal",
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("logout.php")
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            Swal.fire({
              title: "Berhasil Logout!",
              icon: "success",
              text: "Anda telah keluar dari sistem.",
              confirmButtonText: "OK"
            }).then(() => {
              window.location.href = "../login.php"; // Redirect ke halaman login
            });
          }
        });
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
      window.location.href = "profile.php";
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
      window.location.href = "profile.php";
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
      window.location.href = "instansi.php";
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
      window.location.href = "instansi.php";
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
      window.location.href = "instansi.php";
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
      window.location.href = "instansi.php";
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
      window.location.href = "instansi.php?id_instansi_ini=" + id_instansi;
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
      window.location.href = "instansi.php";
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
      window.location.href = "instansi.php";
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
      window.location.href = "user.php?id_user_ini=" + id_user;
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
      window.location.href = "user.php";
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
      window.location.href = "user.php";
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
      window.location.href = "user.php";
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
      window.location.href = "user.php";
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
      window.location.href = "user.php";
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
      window.location.href = "user.php";
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
      window.location.href = "pengajuan.php?id_pengajuan_ini=" + id_pengajuan;
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
      window.location.href = "pengajuan.php";
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
      window.location.href = "pengajuan.php";
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
      window.location.href = "admin_instansi.php";
    }
  })
}

function generate_admin_instansi_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Gagal Menjadikan Admin Instansi",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin_instansi.php";
    }
  })
}



// halaman pendidikan

// crud tabel user by super admin
function confirm_hapus_pendidikan_super_admin(id_pendidikan) {
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
      window.location.href = "pendidikan.php?id_pendidikan_ini=" + id_pendidikan;
    }
  });
}


function hapus_pendidikan_super_admin_success() {
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Data Pendidikan Berhasil Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pendidikan.php";
    }
  })
}

function hapus_pendidikan_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Data Pendidikan Gagal Dihapus",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pendidikan.php";
    }
  })
}



function edit_pendidikan_super_admin_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil",
    text : "Edit Data pendidikan Berhasil :)",
    confirmButtonColor : "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pendidikan.php";
    }
  })
}

function edit_pendidikan_super_admin_gagal() {
  Swal.fire({
    title: "Gagal",
    icon: "error",
    text: "Edit Data pendidikan Gagal :(",
    confirmButtonText : "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pendidikan.php";
    }
  })
}


















// halmaan settings
function confirm_edit_email_super_admin() {
  let emailBaru = document.getElementById("email_baru").value.trim();

  // Validasi email kosong
  if (emailBaru === "") {
    Swal.fire({
      title: "Gagal!",
      icon: "error",
      text: "Email tidak boleh kosong!",
      confirmButtonText: "OK",
      confirmButtonColor: "#d33"
    });
    return; // Hentikan eksekusi jika email kosong
  }

  // Validasi format email menggunakan regex
  let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(emailBaru)) {
    Swal.fire({
      title: "Gagal!",
      icon: "error",
      text: "Format email tidak valid! Gunakan format yang benar, misalnya: contoh@email.com",
      confirmButtonText: "OK",
      confirmButtonColor: "#d33"
    });
    return; // Hentikan eksekusi jika format email salah
  }

  // Jika email valid, tampilkan konfirmasi
  Swal.fire({
    title: "Apakah Anda Yakin?",
    icon: "warning",
    text: "Jika Anda mengganti email, Anda akan keluar dari dashboard dan harus login ulang.",
    showCancelButton: true,
    confirmButtonText: "Ya, Ubah Email",
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if (result.isConfirmed) {
      console.log("Form akan disubmit..."); // Debugging
      document.getElementById("edit-email-form").submit();
    }
  });
}






// Jika sukses mengganti email
function edit_email_super_admin_success() {
  Swal.fire({
    title: "Berhasil!",
    icon: "success",
    text: "Email berhasil diubah. Anda akan keluar dan harus login kembali.",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "../logout.php"; // Redirect ke halaman logout
    }
  });
}

// Jika gagal mengganti email
function edit_email_super_admin_gagal() {
  Swal.fire({
    title: "Gagal!",
    icon: "error",
    text: "Gagal mengubah email. Silakan coba lagi.",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "settings.php"; // Redirect kembali ke halaman settings
    }
  });
}








function logout(){
  Swal.fire({
    title: "Berhasil Logout!",
    icon: "success",
    text: "Anda Sudah Logout. Silahkan Login Ulang",
    confirmButtonText: "OK",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "login.php";
    }
  });
}
