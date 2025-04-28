const menu = document.getElementById("mobile-menu");

document.getElementById("menu-button").addEventListener("click", () => {
  menu.classList.remove("translate-x-full");
});

document.getElementById("close-menu").addEventListener("click", () => {
  menu.classList.add("translate-x-full");
});