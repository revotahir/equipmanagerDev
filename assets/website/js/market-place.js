document.querySelectorAll(".hamburger-options li").forEach((li) => {
  li.addEventListener("click", () => {
    document.querySelector(".equipment-grid").classList.toggle("compact-grid");
    document.querySelector(".hamburger .checkbox").checked = false;
  });
});
