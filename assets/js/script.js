// Sidebar expand
const eventAdmin = document.querySelector("#toggle-btn");

eventAdmin.addEventListener("click", function () {
    const sidebar = document.querySelector("#sidebar");
    const dropdowns = document.querySelectorAll(".sidebar .collapse");
    const dropdownLinks = document.querySelectorAll(".sidebar-link.has-dropdown");

    sidebar.classList.toggle("expand");

    if (!sidebar.classList.contains("expand")) {
        // Tutup semua dropdown dengan Bootstrap collapse
        dropdowns.forEach(drop => {
            // Kalau dropdown lagi terbuka
            if (drop.classList.contains("show")) {
                const bsCollapse = bootstrap.Collapse.getInstance(drop);
                if (bsCollapse) {
                    bsCollapse.hide(); // Pakai instance Bootstrap untuk nutup
                } else {
                    new bootstrap.Collapse(drop, { toggle: false }).hide();
                }
            }
        });

        // Reset aria-expanded
        dropdownLinks.forEach(link => {
            link.setAttribute("aria-expanded", "false");
        });
    }
});



// Sidebar active
// document.addEventListener("DOMContentLoaded", function () {
//     let links = document.querySelectorAll(".sidebar-link");

//     let currentUrl = window.location.pathname;

//     links.forEach(link => {
//         let linkPath = new URL(link.href, window.location.origin).pathname;

//         if (currentUrl === linkPath || (currentUrl === "/" && linkPath.includes("index.html"))) {
//             link.classList.add("active");
//         } else {
//             link.classList.remove("active");
//         }
//     });
// });

// Sidebar active
document.addEventListener("DOMContentLoaded", function () {
    let links = document.querySelectorAll(".sidebar-link");

    let currentUrl = window.location.pathname;

    links.forEach(link => {
        let href = link.getAttribute('href');

        // Skip processing "#" or javascript:void(0)
        if (href === "#" || href === "javascript:void(0)") return;

        let linkPath = new URL(link.href, window.location.origin).pathname;

        if (currentUrl === linkPath || (currentUrl === "/" && linkPath.includes("index.html"))) {
            link.classList.add("active");

            // Tambahan: jika link ini nested di dropdown, tandai parent-nya juga aktif
            let parentCollapse = link.closest(".collapse");
            if (parentCollapse) {
                let parentToggle = parentCollapse.previousElementSibling;
                if (parentToggle && parentToggle.classList.contains("has-dropdown")) {
                    parentToggle.classList.add("active");
                }
            }

        } else {
            link.classList.remove("active");
        }
    });

    // Saat klik link sidebar, hapus semua "active" dari link #
    // links.forEach(link => {
    //     link.addEventListener("click", function () {
    //         links.forEach(l => {
    //             if (l.getAttribute("href") === "#" || l.getAttribute("href") === "javascript:void(0)") {
    //                 l.classList.remove("active");
    //             }
    //         });
    //     });
    // });
});




// Toggle dark mode
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


// Modal untuk kelengkapan dokumen
document.addEventListener("DOMContentLoaded", function() {
    var docLinks = document.querySelectorAll('.show-doc');
    docLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var docs = JSON.parse(this.getAttribute('data-doc'));
            var docList = document.getElementById("dokumenList");
            docList.innerHTML = "";
            docs.forEach(function(doc) {
                var li = document.createElement("li");
                var a = document.createElement("a");
                a.href = doc.url;
                a.textContent = doc.name;
                a.target = "_blank";
                li.appendChild(a);
                docList.appendChild(li);
            });
            var modal = new bootstrap.Modal(document.getElementById('dokumenModal'));
            modal.show();
        });
    });
});
  
  
  



