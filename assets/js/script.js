const eventAdmin = document.querySelector("#toggle-btn");

eventAdmin.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand")
})

document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua elemen dengan class sidebar-link
    const links = document.querySelectorAll('.sidebar-link');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Hapus class 'active' dari semua link
            links.forEach(l => l.classList.remove('active'));
            
            // Tambahkan class 'active' pada link yang diklik
            this.classList.add('active');
        });
    });
});

const modeToggle = document.getElementById("mode-toggle");
const modeIcon = document.getElementById("mode-icon");

function toggleMode() {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        modeIcon.classList.replace("bi-moon-fill", "bi-sun-fill");
    } else {
        localStorage.setItem("theme", "light");
        modeIcon.classList.replace("bi-sun-fill", "bi-moon-fill");
    }
}

window.onload = function() {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
        modeIcon.classList.replace("bi-moon-fill", "bi-sun-fill");
    }
};

modeToggle.addEventListener("click", toggleMode);


// 
// Jika ingin menggunakan modal untuk menampilkan daftar dokumen sebagai link
document.addEventListener("DOMContentLoaded", function() {
    var docLinks = document.querySelectorAll('.show-doc');
    docLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Parse data dokumen dari attribute data-doc (berformat JSON)
            var docs = JSON.parse(this.getAttribute('data-doc'));
            var docList = document.getElementById("dokumenList");
            // Kosongkan daftar dokumen yang ada sebelumnya
            docList.innerHTML = "";
            // Buat list item untuk setiap dokumen
            docs.forEach(function(doc) {
                var li = document.createElement("li");
                // Membuat elemen link untuk dokumen
                var a = document.createElement("a");
                a.href = doc.url;
                a.textContent = doc.name;
                a.target = "_blank"; // Buka dokumen di tab baru
                li.appendChild(a);
                docList.appendChild(li);
            });
            // Tampilkan modal menggunakan Bootstrap 5
            var modal = new bootstrap.Modal(document.getElementById('dokumenModal'));
            modal.show();
        });
    });
});
