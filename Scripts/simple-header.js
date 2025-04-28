const menu = document.getElementById("mobile-menu");
const openBtn = document.getElementById("menu-button");
const closeBtn = document.getElementById("close-menu");

openBtn.addEventListener("click", () => {
  menu.classList.remove("translate-x-full");
});

closeBtn.addEventListener("click", () => {
  menu.classList.add("translate-x-full");
});