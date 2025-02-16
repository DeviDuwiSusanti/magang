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
                <div class="file-input-group d-flex align-items-center mb-2">
                    <label for="persyaratan" class="form-label me-2">Dokumen Persyaratan - <span class="file-number">1</span></label>
                    <input type="file" class="form-control me-2" name="persyaratan[]" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFileInput(this)">−</button>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addFileInput()">Tambah</button><br>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Unggah Persyaratan</button>
        </form>
    </div>
</div>

<script>
    let fileCount = 1;
    function addFileInput() {
        fileCount++;
        let container = document.getElementById("file-container");
        let div = document.createElement("div");
        div.className = "file-input-group d-flex align-items-center mb-2";
        div.innerHTML = `
            <label class="form-label me-2">Dokumen Persyaratan - <span class="file-number">${fileCount}</span></label>
            <input type="file" class="form-control me-2" name="persyaratan[]" accept=".pdf,.doc,.docx,.jpg,.png" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeFileInput(this)">−</button>
        `;
        container.appendChild(div);
    }

    function removeFileInput(button) {
        let container = document.getElementById("file-container");
        if (container.children.length > 1) {
            button.parentElement.remove();
        }
    }
</script>

<?php include "../layout/footerDashboard.php"; ?>
