document.addEventListener("DOMContentLoaded", () => {
  initFaqToggle();
  initViewTabs();
  enforceMobileView();
  initScrollToTop(); // ✅ add this
  window.addEventListener("resize", enforceMobileView);
});

/* ===========================
   FAQ COLLAPSE / EXPAND
=========================== */

function initFaqToggle() {
  const MAX_CHARS = 450;

  const cards = document.querySelectorAll(
    ".faqContentListContainer, .customFaqContentListContainer"
  );

  cards.forEach((card) => {
    const sub = card.querySelector(".faqSub");
    if (!sub) return;

    const fullText = sub.textContent.trim();
    const shouldTruncate = fullText.length > MAX_CHARS;

    const shortText = shouldTruncate
      ? fullText.slice(0, MAX_CHARS) + "…"
      : fullText;

    sub.dataset.full = fullText;
    sub.dataset.short = shortText;
    sub.textContent = shortText;

    const plusBtn = card.querySelector(".viewMoreBtn.viewMore");
    const minusBtn = card.querySelector(".viewMoreBtn.viewLess");
    const mblPlusBtn = card.querySelector(".mblViewWrapper.mblViewMore");
    const mblMinusBtn = card.querySelector(".mblViewWrapper.mblViewLess");

    // initial state
    card.classList.add("is-collapsed");
    card.classList.remove("is-expanded");
    setButtons(false);

    function setButtons(isExpanded) {
      if (plusBtn) plusBtn.style.display = isExpanded ? "none" : "inline-flex";
      if (minusBtn)
        minusBtn.style.display = isExpanded ? "inline-flex" : "none";
      if (mblPlusBtn)
        mblPlusBtn.style.display = isExpanded ? "none" : "inline-flex";
      if (mblMinusBtn)
        mblMinusBtn.style.display = isExpanded ? "inline-flex" : "none";
    }

    function expand() {
      sub.textContent = sub.dataset.full;
      card.classList.remove("is-collapsed");
      card.classList.add("is-expanded");
      setButtons(true);
    }

    function collapse() {
      sub.textContent = sub.dataset.short;
      card.classList.remove("is-expanded");
      card.classList.add("is-collapsed");
      setButtons(false);
    }

    // Card click toggle (ignore buttons + links)
    card.addEventListener("click", (e) => {
      if (e.target.closest(".viewBtn")) return;
      if (e.target.closest(".viewMoreBtn")) return;

      if (card.classList.contains("is-collapsed")) expand();
      else collapse();
    });

    if (plusBtn || mblPlusBtn) {
      plusBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        expand();
      });
    }

    if (minusBtn || mblMinusBtn) {
      minusBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        collapse();
      });
    }
  });
}

/* ===========================
   VIEW MODE TABS
=========================== */

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

/* ===========================
   MOBILE ENFORCED LIST VIEW
=========================== */

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

/* ===========================
   Scroll to top
=========================== */

function initScrollToTop() {
  const scrollBtn = document.getElementById("scrollToTopBtn");
  if (!scrollBtn) return; // button not in DOM

  function toggleScrollBtn() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;

    const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;

    if (scrollPercent > 30) scrollBtn.classList.add("show");
    else scrollBtn.classList.remove("show");
  }

  window.addEventListener("scroll", toggleScrollBtn, { passive: true });
  toggleScrollBtn(); // run once at load

  scrollBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}
