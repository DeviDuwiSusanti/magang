// Sidebar expand
const eventAdmin = document.querySelector("#toggle-btn");

eventAdmin.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand")
})

// Sidebar active
document.addEventListener("DOMContentLoaded", function () {
    let links = document.querySelectorAll(".sidebar-link");

    let currentUrl = window.location.pathname;

    links.forEach(link => {
        let linkPath = new URL(link.href, window.location.origin).pathname;

        if (currentUrl === linkPath || (currentUrl === "/" && linkPath.includes("index.html"))) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
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

// Fungsi helper untuk cek apakah tampilan mobile
function isMobile() {
    return window.innerWidth < 992;
  }
  
  const sidebar = document.getElementById('sidebar');
  const toggleButton = document.getElementById('hamburger-menu');
  const menuItems = document.querySelectorAll('#sidebar .sidebar-item .sidebar-link');
  
  toggleButton.addEventListener('click', () => {
    if (isMobile()) {
      sidebar.classList.toggle('hide');
    }
  });
  
  menuItems.forEach((item) => {
    item.addEventListener('click', () => {
      if (isMobile()) {
        sidebar.classList.add('hide');
      }
    });
  });
  



