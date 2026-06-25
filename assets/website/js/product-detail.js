function normalizeDetailColumns() {
  const root = document.querySelector(".inner-product-detail");
  if (!root) return;

  const heavyDutyMain = Array.from(root.children).find(
    (child) => child.classList && child.classList.contains("heavy-duty-main")
  );
  if (!heavyDutyMain) return;

  const alreadyNormalized = Array.from(heavyDutyMain.children).some(
    (child) => child.classList && child.classList.contains("detail-left-column")
  );
  if (alreadyNormalized) return;

  const heavyDuty = Array.from(heavyDutyMain.children).find(
    (child) => child.classList && child.classList.contains("heavy-duty")
  );
  const specsCard = Array.from(heavyDutyMain.children).find(
    (child) => child.classList && child.classList.contains("heavy-duty-feature")
  );
  const ownerCard = Array.from(heavyDutyMain.children).find(
    (child) => child.classList && child.classList.contains("owner-sidebar-card")
  );

  if (!heavyDuty || !specsCard || !ownerCard) return;

  const calendarMain = Array.from(root.children).find(
    (child) => child.classList && child.classList.contains("calender-main")
  );

  const isRentalLayout =
    calendarMain && !calendarMain.classList.contains("purchase-layout");

  const leftColumn = document.createElement("div");
  leftColumn.className = "detail-left-column";
  leftColumn.appendChild(heavyDuty);

  if (isRentalLayout) {
    const bookingForm = calendarMain.querySelector(".booking-form");
    const calendarCard = calendarMain.querySelector(".calender");

    if (bookingForm && calendarCard) {
      heavyDutyMain.classList.add("rental-quad-layout");

      bookingForm.classList.add("rental-form-slot");
      specsCard.classList.add("rental-specs-slot");
      ownerCard.classList.add("rental-owner-slot");
      calendarCard.classList.add("rental-calendar-slot");

      const rentalGrid = document.createElement("div");
      rentalGrid.className = "rental-grid-layout";
      rentalGrid.appendChild(specsCard);
      rentalGrid.appendChild(ownerCard);
      rentalGrid.appendChild(bookingForm);
      rentalGrid.appendChild(calendarCard);

      leftColumn.appendChild(rentalGrid);
      heavyDutyMain.appendChild(leftColumn);
      return;
    }
  }

  if (calendarMain) {
    leftColumn.appendChild(calendarMain);
  }

  const rightColumn = document.createElement("div");
  rightColumn.className = "detail-right-column";
  rightColumn.appendChild(specsCard);
  rightColumn.appendChild(ownerCard);

  heavyDutyMain.appendChild(leftColumn);
  heavyDutyMain.appendChild(rightColumn);
}

function initImageGallery() {
  const gallery = document.querySelector(".product-img-showcase");
  if (!gallery) return;

  const mainImg = gallery.querySelector(".product-showcase-main-img img");
  const subImgs = Array.from(gallery.querySelectorAll(".product-showcase-sub-img img"));
  const prevBtn = gallery.querySelector(".gallery-nav-prev");
  const nextBtn = gallery.querySelector(".gallery-nav-next");

  if (!mainImg) return;

  const sourceSet = [mainImg.src, ...subImgs.map((img) => img.src)].filter(Boolean);
  const sources = [...new Set(sourceSet)];
  if (sources.length === 0) return;

  let currentIndex = 0;

  function render() {
    mainImg.src = sources[currentIndex];
    subImgs.forEach((img, idx) => {
      img.src = sources[(currentIndex + idx + 1) % sources.length];
    });
  }

  subImgs.forEach((img) => {
    img.addEventListener("click", () => {
      const pickedIndex = sources.indexOf(img.src);
      if (pickedIndex >= 0) {
        currentIndex = pickedIndex;
        render();
      }
    });
  });

  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + sources.length) % sources.length;
      render();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % sources.length;
      render();
    });
  }

  render();
}

function initBookingCalendar() {
  const yearList = document.querySelector(".year");
  const monthList = document.querySelector(".month");
  const main = document.querySelector(".booking-calender-main");
  const primaryMonthLabel = document.querySelector(".prev-section .month-calender");
  const primaryYearLabel = document.querySelector(".prev-section .year-calender");
  const primaryDays = document.querySelector(".first-month .days-date");

  if (!yearList || !monthList || !main || !primaryMonthLabel || !primaryYearLabel || !primaryDays) {
    return;
  }

  const secondaryMonthLabel = document.querySelector(".next-section .month-calender");
  const secondaryYearLabel = document.querySelector(".next-section .year-calender");
  const secondaryDays = document.querySelector(".second-month .days-date");

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

  const panel = {
    headerMonth: primaryMonthLabel,
    headerYear: primaryYearLabel,
    days: primaryDays,
  };

  const secondaryPanel = {
    headerMonth: secondaryMonthLabel,
    headerYear: secondaryYearLabel,
    days: secondaryDays,
  };

  let today = new Date();
  today.setHours(0, 0, 0, 0);

  function parseAvailabilityDate(dateStr) {
    if (!dateStr || typeof dateStr !== "string") return null;
    const parts = dateStr.split("-").map((val) => parseInt(val, 10));
    if (parts.length !== 3 || parts.some(Number.isNaN)) return null;
    return new Date(parts[0], parts[1] - 1, parts[2]);
  }

  let availableStart = null;
  let availableEnd = null;
  let hasBookableDates = true;

  const availabilityData = window.equipmentAvailability || window.workforceAvailability;

  if (availabilityData && availabilityData.startDate && availabilityData.endDate) {
    const serverToday = parseAvailabilityDate(availabilityData.todayDate || "");
    if (serverToday) {
      today = serverToday;
      today.setHours(0, 0, 0, 0);
    }

    availableStart = parseAvailabilityDate(availabilityData.startDate);
    availableEnd = parseAvailabilityDate(availabilityData.endDate);

    if (availableStart && availableStart < today) {
      availableStart = new Date(today);
    }

    if (!availableStart || !availableEnd || availableEnd < today || availableStart > availableEnd) {
      hasBookableDates = false;
    }
  }

  if (!hasBookableDates) {
    const submitButton = document.getElementById("submit-rental");
    if (submitButton) {
      submitButton.disabled = true;
    }
    if (window.toastr && typeof window.toastr.warning === "function") {
      window.toastr.warning("This rental listing has no remaining future availability.", "Unavailable");
    }
  }

  let selectedStartDate = null;
  let selectedEndDate = null;

  window.calendarSync = {
    getSelectedDates: function () {
      return {
        startDate: selectedStartDate,
        endDate: selectedEndDate,
      };
    },
    setDates: function (start, end) {
      if (start) {
        const startParts = start.split("-");
        selectedStartDate = {
          year: parseInt(startParts[0], 10),
          month: parseInt(startParts[1], 10) - 1,
          day: parseInt(startParts[2], 10),
        };
      }
      if (end) {
        const endParts = end.split("-");
        selectedEndDate = {
          year: parseInt(endParts[0], 10),
          month: parseInt(endParts[1], 10) - 1,
          day: parseInt(endParts[2], 10),
        };
      }
      const currentMonth = monthIndex(panel.headerMonth.textContent);
      const year = parseInt(panel.headerYear.textContent, 10);
      updateCalendar(year, currentMonth);
    },
    clearSelection: function () {
      selectedStartDate = null;
      selectedEndDate = null;
      const currentMonth = monthIndex(panel.headerMonth.textContent);
      const year = parseInt(panel.headerYear.textContent, 10);
      updateCalendar(year, currentMonth);
    },
    onDateSelected: null,
  };

  function formatDateForInput(dateObj) {
    if (!dateObj) return "";
    const year = dateObj.year;
    const month = String(dateObj.month + 1).padStart(2, "0");
    const day = String(dateObj.day).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  function notifyFormOfDateChange() {
    const formattedDates = {
      startDate: formatDateForInput(selectedStartDate),
      endDate: formatDateForInput(selectedEndDate),
    };

    if (window.calendarSync.onDateSelected) {
      try {
        window.calendarSync.onDateSelected(formattedDates);
      } catch (error) {
        console.error("Error in calendar callback:", error);
      }
    }
  }

  function isDateAvailable(year, month, day) {
    const checkDate = new Date(year, month, day);
    checkDate.setHours(0, 0, 0, 0);

    if (checkDate < today) return false;
    if (!hasBookableDates) return false;
    if (!availableStart || !availableEnd) return true;

    return checkDate >= availableStart && checkDate <= availableEnd;
  }

  function compareDates(date1, date2) {
    const d1 = new Date(date1.year, date1.month, date1.day);
    const d2 = new Date(date2.year, date2.month, date2.day);
    if (d1 < d2) return -1;
    if (d1 > d2) return 1;
    return 0;
  }

  function daysBetween(date1, date2) {
    const t1 = Date.UTC(date1.year, date1.month, date1.day);
    const t2 = Date.UTC(date2.year, date2.month, date2.day);
    const diffDays = Math.abs(t2 - t1) / (1000 * 60 * 60 * 24);
    return diffDays + 1;
  }

  function isDateInRange(year, month, day) {
    if (!selectedStartDate || !selectedEndDate) return false;
    const checkDate = new Date(year, month, day);
    const start = new Date(selectedStartDate.year, selectedStartDate.month, selectedStartDate.day);
    const end = new Date(selectedEndDate.year, selectedEndDate.month, selectedEndDate.day);
    return checkDate >= start && checkDate <= end;
  }

  const monthIndex = (name) =>
    monthNames.findIndex((m) => m.toLowerCase() === name.trim().toLowerCase());

  function renderDays(container, year, mIndex) {
    if (!container) return;
    container.innerHTML = "";

    const firstDay = new Date(year, mIndex, 1).getDay();
    const lead = firstDay === 0 ? 6 : firstDay - 1;
    for (let i = 0; i < lead; i += 1) {
      container.innerHTML += '<span class="text-day-num empty"></span>';
    }

    const daysInMonth = new Date(year, mIndex + 1, 0).getDate();
    for (let d = 1; d <= daysInMonth; d += 1) {
      const available = isDateAvailable(year, mIndex, d);
      const disabledClass = available ? "" : " disabled";

      let additionalClasses = "";
      if (
        selectedStartDate &&
        selectedStartDate.year === year &&
        selectedStartDate.month === mIndex &&
        selectedStartDate.day === d
      ) {
        additionalClasses = " selected-start";
      } else if (
        selectedEndDate &&
        selectedEndDate.year === year &&
        selectedEndDate.month === mIndex &&
        selectedEndDate.day === d
      ) {
        additionalClasses = " selected-end";
      } else if (isDateInRange(year, mIndex, d)) {
        additionalClasses = " in-range";
      }

      container.innerHTML += `<span class="text-day-num${disabledClass}${additionalClasses}" data-day="${d}" data-month="${mIndex}" data-year="${year}">${d}</span>`;
    }
  }

  function getNextMonthYear(year, month) {
    if (month === 11) {
      return { month: 0, year: year + 1 };
    }
    return { month: month + 1, year };
  }

  function updateCalendar(year, currentMonthIndex) {
    renderDays(panel.days, year, currentMonthIndex);
    panel.headerMonth.textContent = monthNames[currentMonthIndex];
    panel.headerYear.textContent = year;

    if (secondaryPanel.days && secondaryPanel.headerMonth && secondaryPanel.headerYear) {
      const next = getNextMonthYear(year, currentMonthIndex);
      renderDays(secondaryPanel.days, next.year, next.month);
      secondaryPanel.headerMonth.textContent = monthNames[next.month];
      secondaryPanel.headerYear.textContent = next.year;
    }
  }

  function openSelector(type) {
    main.classList.add("hidden");
    yearList.classList.toggle("hide", type !== "year");
    monthList.classList.toggle("hide", type !== "month");
  }

  panel.headerYear.addEventListener("click", () => openSelector("year"));
  panel.headerMonth.addEventListener("click", () => openSelector("month"));

  const selectorStartYear = today.getFullYear();
  const selectorEndYear = availableEnd
    ? Math.max(selectorStartYear + 10, availableEnd.getFullYear())
    : selectorStartYear + 10;

  yearList.innerHTML = Array.from(
    { length: selectorEndYear - selectorStartYear + 1 },
    (_, i) => `<span class="text-month-name text-dark-gray">${selectorStartYear + i}</span>`
  ).join("");

  yearList.addEventListener("click", (e) => {
    if (!e.target.matches("span")) return;
    const y = parseInt(e.target.textContent, 10);
    panel.headerYear.textContent = y;
    yearList.classList.add("hide");
    monthList.classList.remove("hide");
  });

  monthList.addEventListener("click", (e) => {
    if (!e.target.matches("span")) return;
    const picked = monthIndex(e.target.textContent);
    const y = parseInt(panel.headerYear.textContent, 10) || new Date().getFullYear();
    updateCalendar(y, picked);
    monthList.classList.add("hide");
    main.classList.remove("hidden");
  });

  document.querySelectorAll(".prev, .next").forEach((btn) => {
    btn.addEventListener("click", () => {
      const isNext = btn.classList.contains("next");
      const currentMonth = monthIndex(panel.headerMonth.textContent);
      let year = parseInt(panel.headerYear.textContent, 10);
      let newMonth = isNext ? currentMonth + 1 : currentMonth - 1;
      if (newMonth < 0) {
        newMonth = 11;
        year -= 1;
      }
      if (newMonth > 11) {
        newMonth = 0;
        year += 1;
      }
      updateCalendar(year, newMonth);
    });
  });

  document.addEventListener("click", (e) => {
    if (
      !e.target.classList.contains("text-day-num") ||
      e.target.classList.contains("empty") ||
      e.target.classList.contains("disabled")
    ) {
      return;
    }

    const clickedDate = {
      day: parseInt(e.target.dataset.day, 10),
      month: parseInt(e.target.dataset.month, 10),
      year: parseInt(e.target.dataset.year, 10),
    };

    if (
      selectedStartDate &&
      selectedStartDate.day === clickedDate.day &&
      selectedStartDate.month === clickedDate.month &&
      selectedStartDate.year === clickedDate.year
    ) {
      selectedStartDate = null;
      selectedEndDate = null;
      const currentMonth = monthIndex(panel.headerMonth.textContent);
      const year = parseInt(panel.headerYear.textContent, 10);
      updateCalendar(year, currentMonth);
      notifyFormOfDateChange();
      return;
    }

    if (
      selectedEndDate &&
      selectedEndDate.day === clickedDate.day &&
      selectedEndDate.month === clickedDate.month &&
      selectedEndDate.year === clickedDate.year
    ) {
      selectedEndDate = null;
      const currentMonth = monthIndex(panel.headerMonth.textContent);
      const year = parseInt(panel.headerYear.textContent, 10);
      updateCalendar(year, currentMonth);
      notifyFormOfDateChange();
      return;
    }

    if (!selectedStartDate || (selectedStartDate && selectedEndDate)) {
      selectedStartDate = clickedDate;
      selectedEndDate = null;
    } else {
      const comparison = compareDates(clickedDate, selectedStartDate);

      if (comparison === 0) {
        return;
      } else if (comparison < 0) {
        selectedEndDate = selectedStartDate;
        selectedStartDate = clickedDate;
      } else {
        selectedEndDate = clickedDate;
      }

      const days = daysBetween(selectedStartDate, selectedEndDate);
      if (days < 2) {
        if (window.toastr) {
          window.toastr.warning(
            "Minimum rental period is 2 days. Please select an end date at least 2 days after the start date.",
            "Invalid Selection"
          );
        }
        selectedEndDate = null;
      }
    }

    const currentMonth = monthIndex(panel.headerMonth.textContent);
    const year = parseInt(panel.headerYear.textContent, 10);
    updateCalendar(year, currentMonth);
    notifyFormOfDateChange();
  });

  document.addEventListener("click", (e) => {
    if (e.target.closest(".year, .month, .mon-year")) return;
    yearList.classList.add("hide");
    monthList.classList.add("hide");
    main.classList.remove("hidden");
  });

  if (hasBookableDates && availableStart) {
    updateCalendar(availableStart.getFullYear(), availableStart.getMonth());
  } else {
    updateCalendar(today.getFullYear(), today.getMonth());
  }
}

function syncDetailFormAlignment() {
  const isDesktop = window.matchMedia("(min-width: 992px)").matches;
  const roots = document.querySelectorAll(".inner-product-detail");

  roots.forEach((root) => {
    const leftColumn = root.querySelector(".detail-left-column");
    const rightColumn = root.querySelector(".detail-right-column");
    if (!leftColumn || !rightColumn) return;

    const bookingWrapper = leftColumn.querySelector(".calender-main .booking-form");
    const formCard = bookingWrapper ? bookingWrapper.querySelector(".cnt-form") : null;
    if (!bookingWrapper || !formCard) return;

    bookingWrapper.style.minHeight = "";
    formCard.style.minHeight = "";
    if (!isDesktop) return;

    const headerBlock = leftColumn.querySelector(".heavy-duty");
    if (!headerBlock) return;

    const leftStyle = window.getComputedStyle(leftColumn);
    const columnGap = parseFloat(leftStyle.rowGap || leftStyle.gap || "0") || 0;
    const rightHeight = rightColumn.getBoundingClientRect().height;
    const headerHeight = headerBlock.getBoundingClientRect().height;
    const targetHeight = Math.round(rightHeight - headerHeight - columnGap);

    if (targetHeight > 220) {
      bookingWrapper.style.minHeight = `${targetHeight}px`;
      formCard.style.minHeight = `${targetHeight}px`;
    }
  });
}

let detailSyncResizeTimer = null;

function runDetailAlignmentSync() {
  syncDetailFormAlignment();
  window.requestAnimationFrame(syncDetailFormAlignment);
  window.setTimeout(syncDetailFormAlignment, 140);
}

document.addEventListener("DOMContentLoaded", () => {
  normalizeDetailColumns();
  initImageGallery();
  initBookingCalendar();
  runDetailAlignmentSync();

  window.addEventListener("load", runDetailAlignmentSync);
  window.addEventListener("resize", () => {
    window.clearTimeout(detailSyncResizeTimer);
    detailSyncResizeTimer = window.setTimeout(runDetailAlignmentSync, 120);
  });
});
