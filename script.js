document.addEventListener("DOMContentLoaded", () => {
  initFaqToggle();
  initViewTabs();
  enforceMobileView();
  window.addEventListener("resize", enforceMobileView);
});

function initFaqToggle() {
  const MAX_CHARS = 40;
  const cards = document.querySelectorAll(".faqContentListContainer");

  cards.forEach((card) => {
    const sub = card.querySelector(".faqSub");
    if (!sub) return;

    const fullText = sub.textContent.trim();
    if (fullText.length <= MAX_CHARS) return;

    const shortText = fullText.slice(0, MAX_CHARS) + "…";

    sub.dataset.full = fullText;
    sub.dataset.short = shortText;
    sub.textContent = shortText;
    card.classList.add("is-collapsed");

    function toggleCard() {
      const isCollapsed = card.classList.contains("is-collapsed");

      if (isCollapsed) {
        sub.textContent = sub.dataset.full;
        card.classList.remove("is-collapsed");
        card.classList.add("is-expanded");
      } else {
        sub.textContent = sub.dataset.short;
        card.classList.remove("is-expanded");
        card.classList.add("is-collapsed");
      }
    }

    card.addEventListener("click", (e) => {
      // optional: don't toggle when clicking the View button
      if (e.target.closest(".viewBtn")) return;
      toggleCard();
    });
  });
}

function initViewTabs() {
  const gridTab = document.getElementById("gridViewTab");
  const listTab = document.getElementById("listViewTab");
  const listWrapper = document.querySelector(".faqContentListWrapper");

  if (!gridTab || !listTab || !listWrapper) return;

  function setView(mode) {
    if (mode === "grid") {
      listWrapper.classList.remove("list-view");
      listWrapper.classList.add("grid-view");

      gridTab.classList.add("selectedTabContainer");
      listTab.classList.remove("selectedTabContainer");
    } else {
      listWrapper.classList.remove("grid-view");
      listWrapper.classList.add("list-view");

      listTab.classList.add("selectedTabContainer");
      gridTab.classList.remove("selectedTabContainer");
    }
  }

  gridTab.addEventListener("click", () => setView("grid"));
  listTab.addEventListener("click", () => setView("list"));
}

function enforceMobileView() {
  const listWrapper = document.querySelector(".faqContentListWrapper");
  const gridTab = document.getElementById("gridViewTab");
  const listTab = document.getElementById("listViewTab");

  if (!listWrapper || !gridTab || !listTab) return;

  if (window.innerWidth <= 992) {
    listWrapper.classList.remove("grid-view");
    listWrapper.classList.add("list-view");

    listTab.classList.add("selectedTabContainer");
    gridTab.classList.remove("selectedTabContainer");
  }
}
