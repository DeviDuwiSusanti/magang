<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File Dinamis</title>
    <script>
        function addFileInput() {
            let container = document.getElementById("file-container");
            let input = document.createElement("input");
            input.type = "file";
            input.name = "files[]";
            container.appendChild(document.createElement("br"));
            container.appendChild(input);
        }
    </script>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div id="file-container">
            <input type="file" name="files[]">
        </div>
        <button type="button" onclick="addFileInput()">Tambah</button>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
