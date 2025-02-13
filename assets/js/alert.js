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
function alertEdit(
    linkHref,
    successMessage = "Data berhasil diperbarui."
) {
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
    })
}

// Ekspor ke global scope
window.alertEdit = alertEdit;

// ALert tambah
function alertTambah(
    linkHref,
    successMessage = "Data berhasil ditambahkan."
) {
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
    })
}

// Ekspor ke global scope
window.alertTambah = alertTambah;
