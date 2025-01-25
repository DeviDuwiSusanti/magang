<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
        }

        .container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .image-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 50%;
            margin: 0 auto 15px;
            position: relative;
            background-color: #f8f9fa;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none; /* Default disembunyikan */
        }

        .default-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            color: #ccc;
            font-family: Arial, sans-serif;
        }

        input[type="file"] {
            display: none;
        }

        label {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        label:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-preview" id="imagePreview">
            <div class="default-text" id="defaultText">+</div>
            <img src="" alt="Image Preview" id="previewImage">
        </div>
        <label for="profileImage">Choose a Photo</label>
        <input type="file" id="profileImage" accept="image/*" onchange="previewFile()">
    </div>

    <script>
        function previewFile() {
            const fileInput = document.getElementById('profileImage');
            const previewImage = document.getElementById('previewImage');
            const defaultText = document.getElementById('defaultText');
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block"; // Tampilkan gambar
                    defaultText.style.display = "none"; // Hilangkan teks default
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = "";
                previewImage.style.display = "none"; // Sembunyikan gambar
                defaultText.style.display = "block"; // Tampilkan kembali teks default
            }
        }
    </script>
</body>
</html>
