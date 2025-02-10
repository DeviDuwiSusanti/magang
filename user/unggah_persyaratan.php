<?php include "../layout/sidebarUser.php"; ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Persyaratan</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Persyaratan yang ditentukan Instansi</li>
        </ol>
        
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
            <div id="file-container" class="mb-3">
                <?php $no = 1; ?>
                <label for="persyaratan" class="form-label">Dokumen Persyaratan - <span id="file-number">1</span></label>
                <input type="file" class="form-control" id="persyaratan" name="persyaratan[]" accept=".pdf,.doc,.docx,.jpg,.png" required>
            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addFileInput()">Tambah</button><br>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Logbook</button>
        </form>
    </div>
</div>

<script>
    let fileCount = 1;
    function addFileInput() {
        fileCount++;
        let container = document.getElementById("file-container");
        let label = document.createElement("label");
        label.innerHTML = `Dokumen Persyaratan - ${fileCount}`;
        label.className = "mt-2";
        let input = document.createElement("input");
        input.type = "file";
        input.className = "form-control mt-2";
        input.name = "lampiran[]";
        input.accept = ".pdf,.doc,.docx,.jpg,.png";
        container.appendChild(label);
        container.appendChild(input);
    }
</script>