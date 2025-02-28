<script>
document.addEventListener('DOMContentLoaded', function () {
    const formProfile = document.querySelector('.form-profile');
    if (formProfile) {
        formProfile.addEventListener('submit', function (e) {
            if (!validateProfileForm()) {
                e.preventDefault(); // Hentikan submit jika validasi gagal
            }
        });
    }
});

function validateProfileForm() {
    let isValid = true;

    // Validasi Nama
    const nama = document.getElementById('nama').value.trim();
    if (!/^[a-zA-Z\s]+$/.test(nama)) {
        showError('nama', 'Nama hanya boleh berisi huruf.');
        isValid = false;
    } else {
        clearError('nama');
    }

    // Validasi Tempat Lahir
    const tempatLahir = document.getElementById('tempat_lahir').value.trim();
    if (!/^[a-zA-Z\s]+$/.test(tempatLahir)) {
        showError('tempat_lahir', 'Tempat lahir hanya boleh berisi huruf.');
        isValid = false;
    } else {
        clearError('tempat_lahir');
    }

    // Validasi NIK
    const nik = document.getElementById('nik').value.trim();
    if (nik.length !== 16 || isNaN(nik)) {
        showError('nik', 'NIK harus terdiri dari 16 angka.');
        isValid = false;
    } else {
        clearError('nik');
    }

    // Validasi NIM/NISN
    const nim = document.getElementById('nim').value.trim();
    if (!/^\d{10,12}$/.test(nim)) {
        showError('nim', 'NIM/NISN harus terdiri dari 10-12 digit angka.');
        isValid = false;
    } else {
        clearError('nim');
    }

    // Validasi Telepon
    const telepon = document.getElementById('telepon').value.trim();
    if (!/^(\d{11,12})$/.test(telepon)) {
        showError('telepon', 'Nomor telepon harus terdiri dari 11-12 digit.');
        isValid = false;
    } else {
        clearError('telepon');
    }

    // Validasi Foto Profil
    const image = document.getElementById('image').files[0];
    if (image && image.size > 1024 * 1024) { // 1MB
        showError('image', 'Ukuran file tidak boleh lebih dari 1MB.');
        isValid = false;
    } else {
        clearError('image');
    }

    return isValid;
}

function showError(inputId, message) {
    document.getElementById(`error-${inputId}`).textContent = message;
}

function clearError(inputId) {
    document.getElementById(`error-${inputId}`).textContent = '';
}
