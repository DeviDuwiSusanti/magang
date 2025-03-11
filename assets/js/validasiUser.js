    // Fungsi validasi
    function validateForm() {
        let isValid = true;

        // Ambil nilai form
        let tanggal = $('#tanggal').val();
        let kegiatan = $('#kegiatan').val().trim();
        let keterangan = $('#keterangan').val().trim();
        let jam_mulai = $('#jam_mulai').val();
        let jam_selesai = $('#jam_selesai').val();
        let gambar = $('#gambar_kegiatan')[0].files[0];
        let ttd = $('#signature-data').val();

        // Bersihkan error sebelumnya
        $('.text-danger').remove();

        // Validasi Kegiatan
        if (kegiatan === '') {
            $('#kegiatan').after('<small class="text-danger">Kegiatan harus diisi</small>');
            isValid = false;
        }

        // Validasi Keterangan
        if (keterangan === '') {
            $('#keterangan').after('<small class="text-danger">Keterangan harus diisi</small>');
            isValid = false;
        }

        // Validasi Tanggal
        if (tanggal === '') {
            $('#tanggal').after('<small class="text-danger">Tanggal harus diisi</small>');
            isValid = false;
        }

        // Validasi Waktu
        if (jam_mulai === '') {
            $('#jam_mulai').after('<small class="text-danger">Jam mulai harus diisi</small>');
            isValid = false;
        }

        if (jam_selesai === '') {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus diisi</small>');
            isValid = false;
        }

        if (jam_mulai && jam_selesai && jam_mulai >= jam_selesai) {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus lebih dari jam mulai</small>');
            isValid = false;
        }

        // Validasi Gambar
        if (!gambar) {
            $('#gambar_kegiatan').after('<small class="text-danger">Gambar kegiatan harus diunggah</small>');
            isValid = false;
        } else if (gambar.size > 1048576) {
            $('#gambar_kegiatan').after('<small class="text-danger">Ukuran gambar tidak boleh lebih dari 1 MB</small>');
            isValid = false;
        }

        // Validasi Tanda Tangan
        if (ttd === '') {
            $('#signature-pad').after('<small class="text-danger">Tanda tangan wajib diisi</small>');
            isValid = false;
        }

        return isValid;
    }
