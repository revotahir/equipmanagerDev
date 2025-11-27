const mainImg = document.querySelector(".product-showcase-main-img img");
const subImgs = document.querySelectorAll(".product-showcase-sub-img img");

subImgs.forEach((img) => {
  img.addEventListener("click", () => {
    // Swap the clicked sub image with the main image
    const tempSrc = mainImg.src;
    mainImg.src = img.src;
    img.src = tempSrc;
  });
});

// calender
document.addEventListener("DOMContentLoaded", () => {
  const yearList = document.querySelector(".year");
  const monthList = document.querySelector(".month");
  const main = document.querySelector(".booking-calender-main");
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  const panels = [
    {
      headerMonth: document.querySelector(".prev-section .month-calender"),
      headerYear: document.querySelector(".prev-section .year-calender"),
      days: document.querySelector(".first-month .days-date"),
    },
    {
      headerMonth: document.querySelector(".next-section .month-calender"),
      headerYear: document.querySelector(".next-section .year-calender"),
      days: document.querySelector(".second-month .days-date"),
    },
  ];

  let activePanel = 0;

  const monthIndex = (name) =>
    monthNames.findIndex((m) => m.toLowerCase() === name.trim().toLowerCase());

  function render(panelIndex, year, mIndex) {
    const container = panels[panelIndex].days;
    container.innerHTML = "";
    const firstDay = new Date(year, mIndex, 1).getDay();
    const lead = firstDay === 0 ? 6 : firstDay - 1;
    for (let i = 0; i < lead; i++)
      container.innerHTML += '<span class="text-day-num empty"></span>';
    const daysInMonth = new Date(year, mIndex + 1, 0).getDate();
    for (let d = 1; d <= daysInMonth; d++)
      container.innerHTML += `<span class="text-day-num" data-day="${d}" data-month="${mIndex}" data-year="${year}">${d}</span>`;
  }

  function updateBoth(year, monthIndexLeft) {
    let m1 = monthIndexLeft,
      y1 = year;
    let m2 = m1 + 1,
      y2 = y1;
    if (m2 > 11) {
      m2 = 0;
      y2++;
    }
    render(0, y1, m1);
    render(1, y2, m2);
    panels[0].headerMonth.textContent = monthNames[m1];
    panels[1].headerMonth.textContent = monthNames[m2];
    panels[0].headerYear.textContent = y1;
    panels[1].headerYear.textContent = y2;
  }

  function openSelector(panel, type) {
    activePanel = panel;
    main.classList.add("hidden");
    yearList.classList.toggle("hide", type !== "year");
    monthList.classList.toggle("hide", type !== "month");
  }

  panels.forEach((p, i) => {
    p.headerYear.addEventListener("click", () => openSelector(i, "year"));
    p.headerMonth.addEventListener("click", () => openSelector(i, "month"));
  });

  // ✅ Generate years 2025–2035 with the required classes
  yearList.innerHTML = Array.from(
    { length: 11 },
    (_, i) => `<span class="text-month-name text-dark-gray">${2025 + i}</span>`
  ).join("");

  yearList.addEventListener("click", (e) => {
    if (!e.target.matches("span")) return;
    const y = +e.target.textContent;
    panels[activePanel].headerYear.textContent = y;
    yearList.classList.add("hide");
    monthList.classList.remove("hide");
  });

  monthList.addEventListener("click", (e) => {
    if (!e.target.matches("span")) return;
    const picked = monthIndex(e.target.textContent);
    const y =
      +panels[activePanel].headerYear.textContent || new Date().getFullYear();
    updateBoth(y, picked);
    monthList.classList.add("hide");
    main.classList.remove("hidden");
  });

  // prev / next buttons
  document.querySelectorAll(".prev, .next").forEach((btn) => {
    btn.addEventListener("click", () => {
      const isNext = btn.classList.contains("next");
      const currentMonth = monthIndex(panels[0].headerMonth.textContent);
      let year = +panels[0].headerYear.textContent;
      let newMonth = isNext ? currentMonth + 1 : currentMonth - 1;
      if (newMonth < 0) {
        newMonth = 11;
        year--;
      }
      if (newMonth > 11) {
        newMonth = 0;
        year++;
      }
      updateBoth(year, newMonth);
    });
  });

  // day active toggle
  document.addEventListener("click", (e) => {
    if (
      !e.target.classList.contains("text-day-num") ||
      e.target.classList.contains("empty")
    )
      return;
    const panel = panels.find((p) => p.days.contains(e.target));
    if (!panel) return;
    panel.days
      .querySelectorAll(".text-day-num.active")
      .forEach((el) => el.classList.remove("active"));
    e.target.classList.add("active");
  });

  // click outside
  document.addEventListener("click", (e) => {
    if (e.target.closest(".year, .month, .mon-year")) return;
    yearList.classList.add("hide");
    monthList.classList.add("hide");
    main.classList.remove("hidden");
  });

  // initial render (current month)
  const now = new Date();
  updateBoth(now.getFullYear(), now.getMonth());
});
