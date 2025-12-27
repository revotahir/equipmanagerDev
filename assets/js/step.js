"use strict";

const multiTabs = document.querySelectorAll(
  ".multi_tabs_content-container .multi_tab_content"
);

const multiTabsBtns = document.querySelectorAll(
  "#multiTabsBtnsContentSection .multi_tabs_btns-container .multi_tabs-btn"
);

const preferedStep = window.location.hash.slice(-1);

if (preferedStep) {
  multiTabsBtns.forEach((_tabBtn) => _tabBtn.classList.remove("active_tab"));

  multiTabsBtns[preferedStep - 1].classList.add("active_tab");
} else {
  multiTabsBtns[0].classList.add("active_tab");
}

console.log(multiTabs, multiTabsBtns);

multiTabsBtns.forEach((tabBtn, index) => {
  const btn = tabBtn.querySelector(".tab-btn");

  if (!btn.disabled) {
    if (tabBtn.classList.contains("active_tab"))
      multiTabs[index].classList.add("active");

    btn.addEventListener("click", () => {
      multiTabsBtns.forEach((_tabBtn) =>
        _tabBtn.classList.remove("active_tab")
      );

      tabBtn.classList.add("active_tab");

      multiTabs.forEach((tab) => tab.classList.remove("active"));

      multiTabs[index].classList.add("active");
    });
  }
});
