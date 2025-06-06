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





// ================== super admin =================
function alert_berhasil_gagal_super_admin(icon, title, text, link) {
  Swal.fire({
    icon : icon,
    title : title,
    text : text,
    confirmButtonColor : "#3085d6",
    confirmButtonText : "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = link;
    }
  })
}

// Fungsi konfirmasi SweetAlert
function confirm_hapus_unggahan_pembimbing(event, id_dokumen) {
  event.preventDefault(); // Menghentikan aksi default
  
  Swal.fire({
    title: "Apakah Anda Yakin Ingin Hapus Data Ini?",
    icon: "warning",
    text: "Data yang Anda hapus tidak bisa dikembalikan lagi.",
    showCancelButton: true,
    confirmButtonText: "YA! Hapus",
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "pembimbing4.php?id_dokumenHapus=" + id_dokumen;
    }
  });
  
  return false;
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
      window.location.href = "super1_instansi.php?id_instansi_ini=" + id_instansi;
    }
  });
}



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
      window.location.href = "super1_user.php?id_user_ini=" + id_user;
    }
  });
}


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
      window.location.href = "super1_pengajuan.php?id_pengajuan_ini=" + id_pengajuan;
    }
  })
}


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
      window.location.href = "pendidikan_user.php?id_pendidikan_ini=" + id_pendidikan;
    }
  });
}


// ============================= end bagian super admin =======================
















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
      window.location.href = "admin2_instansi.php";
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
      window.location.href = "admin2_instansi.php";
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
      window.location.href = "admin2_bidang.php";
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
      window.location.href = "admin2_bidang.php";
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
      window.location.href = "admin2_bidang.php";
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
      window.location.href = "admin2_bidang.php";
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
      window.location.href = "admin2_bidang.php?id_bidang_ini=" + id_bidang;
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
      window.location.href = "admin2_bidang.php";
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
      window.location.href = "admin2_bidang.php";
    }
  })
}

// Tambah pembimbing admin instansi 
function tambah_pembimbing_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data pembimbing berhasil ditambahkan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
    }
  })
}

function tambah_pembimbing_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data pembimbing gagal ditambahkan",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
    }
  })
}

// Edit pembimbing admin instansi
function edit_pembimbing_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data pembimbing berhasil diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
    }
  })
}

function edit_pembimbing_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data pembimbing gagal diperbarui",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
    }
  })
}

// Hapus pembimbing admin instansi
function hapus_pembimbing_admin_instansi(id_pembimbing) {
  Swal.fire({
    title: "Apakah Anda yakin?",
    icon: "warning",
    text: "Data pembimbing akan dihapus!",
    confirmButtonText: "Ya! Hapus",
    showCancelButton: true,
    cancelButtonText: "Batal",
    cancelButtonColor: "#d33",
    confirmButtonColor: "#3085d6"
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php?id_pembimbing_ini=" + id_pembimbing;
  }})
}

function hapus_pembimbing_admin_instansi_success() {
  Swal.fire({
    icon: "success",
    title: "Berhasil!",
    text: "Data pembimbing berhasil dihapus",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
    }
  })
}

function hapus_pembimbing_admin_instansi_gagal() {
  Swal.fire({
    icon: "error",
    title: "Gagal!",
    text: "Data pembimbing gagal dihapus",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  }).then((result) => {
    if(result.isConfirmed) {
      window.location.href = "admin2_pembimbing.php";
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




//============================ halmaan settings ===========================

function confirm_edit_email_user() {
  const emailBaru = document.getElementById("email_baru").value.trim();

  // 1. Validasi kosong
  if (emailBaru === "") {
    Swal.fire({
      title: "Gagal!",
      icon: "error",
      text: "Email tidak boleh kosong!",
      confirmButtonText: "OK",
      confirmButtonColor: "#d33"
    });
    return;
  }

  // 2. Validasi format email
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(emailBaru)) {
    Swal.fire({
      title: "Gagal!",
      icon: "error",
      text: "Format email tidak valid! Contoh: user@example.com",
      confirmButtonText: "OK",
      confirmButtonColor: "#d33"
    });
    return;
  }

  // 3. Konfirmasi sebelum submit
  Swal.fire({
    title: "Apakah Anda Yakin?",
    text: "Mengubah email akan membuat Anda logout dan harus login ulang.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, Ubah Email",
    cancelButtonText: "Batal",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33"
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById("edit-email-form").submit();
    }
  });
}

// ============================ alert otp ============================
function otp_expired() {
  Swal.fire({
      title: 'Waktu Habis!',
      text: 'Anda akan dialihkan ke halaman login dalam 5 detik...',
      icon: 'info',
      timer: 5000,
      timerProgressBar: true,
      showConfirmButton: false,
      allowOutsideClick: false,
      didClose: () => {
        // localStorage.removeItem('otp_expired_time');
        window.location.href = 'login.php';
      }
  });
}

function showSwalAlert(type, title, message, redirectUrl = null) {
  Swal.fire({
      icon: type,
      title: title,
      text: message,
      confirmButtonText: 'OK'
  }).then(() => {
      if (redirectUrl) {
        // localStorage.removeItem('otp_expired_time');
        window.location.href = redirectUrl;
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
