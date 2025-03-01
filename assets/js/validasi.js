// Fungsi Menampilkan Pesan Error di Bawah Input
function showError(id, message) {
    let inputField = document.getElementById(id);

    // Jika id 'gender', cari parent untuk menampilkan error
    if (id === "gender") {
        inputField = document.getElementById("gender_l").parentElement; // Ambil parent dari radio button
    }

    let existingError = inputField.parentElement.querySelector(".text-danger");
    if (!existingError) {
        let errorText = document.createElement("small");
        errorText.className = "text-danger";
        errorText.innerText = message;
        inputField.parentElement.appendChild(errorText);
    } else {
        existingError.innerText = message;
    }
}

// Fungsi Menghapus Pesan Error
function clearError(id) {
    let inputField = document.getElementById(id);

    // Jika id 'gender', cari parent dari radio button
    if (id === "gender") {
        inputField = document.getElementById("gender_l").parentElement;
    }

    let existingError = inputField.parentElement.querySelector(".text-danger");
    if (existingError) {
        existingError.remove();
    }
}

document.getElementById("editForm").addEventListener("submit", function (event) {
    let isValid = true;

    // Validasi Nama Lengkap (hanya huruf dan spasi)
    const nama = document.getElementById("nama_user").value.trim();
    if (!/^[a-zA-Z\s'-]+$/.test(nama)) {
        showError("nama_user", "Nama hanya boleh berisi huruf dan spasi.");
        isValid = false;
    } else {
        clearError("nama_user");
    }

    // Validasi Tempat Lahir (hanya huruf dan spasi)
    const tempatLahir = document.getElementById("tempat_lahir").value.trim();
    if (!/^[a-zA-Z\s]+$/.test(tempatLahir)) {
        showError("tempat_lahir", "Tempat lahir hanya boleh berisi huruf dan spasi.");
        isValid = false;
    } else {
        clearError("tempat_lahir");
    }

    // Validasi Tanggal Lahir (tidak boleh kosong)
    const tanggalLahir = document.getElementById("tanggal_lahir").value;
    if (!tanggalLahir) {
        showError("tanggal_lahir", "Tanggal lahir harus diisi.");
        isValid = false;
    } else {
        clearError("tanggal_lahir");
    }

    // Validasi Jenis Kelamin (harus dipilih salah satu)
    const genderL = document.getElementById("gender_l").checked;
    const genderP = document.getElementById("gender_p").checked;
    if (!genderL && !genderP) {
        showError("gender", "Pilih jenis kelamin.");
        isValid = false;
    } else {
        clearError("gender");
    }

    // Validasi No. Telepon (hanya angka, minimal 10-13 digit)
    const telepon = document.getElementById("no_telepone").value.trim();
    if (!/^\d{10,13}$/.test(telepon)) {
        showError("no_telepone", "No. telepon harus 10-13 digit angka.");
        isValid = false;
    } else {
        clearError("no_telepone");
    }

    // Validasi Alamat (tidak boleh kosong)
    const alamat = document.getElementById("alamat").value.trim();
    if (alamat === "") {
        showError("alamat", "Alamat tidak boleh kosong.");
        isValid = false;
    } else {
        clearError("alamat");
    }

    // Validasi Foto Profil (jika diunggah, harus format gambar yang benar)
    const fileInput = document.getElementById("image");
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!allowedTypes.includes(file.type)) {
            showError("image", "Format gambar harus jpg, jpeg, png, atau gif.");
            isValid = false;
        } else {
            clearError("image");
        }
    }

    // Jika ada kesalahan, batalkan submit
    if (!isValid) {
        event.preventDefault();
    }
});
