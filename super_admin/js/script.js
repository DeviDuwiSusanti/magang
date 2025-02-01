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
