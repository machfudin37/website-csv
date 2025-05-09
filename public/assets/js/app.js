let switchMode = document.getElementById("switch-mode");

switchMode.addEventListener("change", (e) => {
  if (e.target.checked) {
    document.body.classList.add("dark");
    // Simpan preferensi mode dalam cookie, misalnya dengan nama "theme_mode"
    document.cookie = "theme_mode=dark; expires=365; path=/";
  } else {
    document.body.classList.remove("dark");
    // Simpan preferensi mode dalam cookie, misalnya dengan nama "theme_mode"
    document.cookie = "theme_mode=light; expires=365; path=/";
  }
});

// Ketika halaman dimuat, periksa cookie dan atur tema sesuai preferensi
document.addEventListener("DOMContentLoaded", () => {
  let themeMode = getCookie("theme_mode");
  if (themeMode === "dark") {
    document.body.classList.add("dark");
    switchMode.checked = true;
  } else {
    document.body.classList.remove("dark");
    switchMode.checked = false;
  }
});

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length === 2) return parts.pop().split(";").shift();
};
let menuBar = document.querySelector(".menu-btn");
let sideBar = document.querySelector(".sidebar");
menuBar.addEventListener("click", () => {
  sideBar.classList.toggle("hide");
});