<div class="form_daftar">
                    <h3 style="text-align: center;">Formulir Pendaftaran</h3>
                    <div class="card">
                        <form action="" method="POST">
                        <div class="form-group">
                            <select name="jenis_pengajuan" required>
                                <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                                <option value="magang">Magang</option>
                                <option value="magang">Kerja Praktek</option>
                                <option value="kp">PKL</option>
                                <option value="penelitian">Penelitian</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <input type="number" name="jumlah" placeholder="Jumlah" required />
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai" required />
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai:</label>
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai" required />
                            </div>
                            <div class="form-group">
                                <label for="cv">Unggah CV:</label>
                                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required />
                            </div>
                            <div class="form-group">
                                <button class="button" name="kirim">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
</html>
