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
