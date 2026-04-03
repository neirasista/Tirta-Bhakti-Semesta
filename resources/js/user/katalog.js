// =======================
// GLOBAL STATE (USER)
// =======================
let productCategories = [];
let grades = [];
let catalogs = [];

let currentCategoryId = "";
let currentGradeKey = "";
let currentQuery = "";

// =======================
// INIT LOAD
// =======================
document.addEventListener("DOMContentLoaded", async () => {
  try {
    const [catRes, gradeRes, catalogRes] = await Promise.all([
      fetch("/api/categories"),
      fetch("/api/grades"),
      fetch("/api/catalogs"),
    ]);

    productCategories = await catRes.json();
    grades = await gradeRes.json();
    catalogs = await catalogRes.json();

    renderCategoryButtons();
    renderGradeDropdown();
    renderCatalog(catalogs);
    setupSearchListener();
  } catch (err) {
    console.error("Gagal load data katalog user:", err);
  }
});

// =======================
// RENDER CATEGORY BUTTONS
// =======================
function renderCategoryButtons() {
  const container = document.getElementById("categoryButtons");
  if (!container) return;

  container.innerHTML = "";
  container.appendChild(createCategoryButton("Semua", ""));

  productCategories.forEach((cat) => {
    container.appendChild(createCategoryButton(cat.categoryName, cat.id));
  });

  highlightCategoryButtons("");
}

function createCategoryButton(label, id) {
  const btn = document.createElement("button");
  btn.className =
    "px-6 py-2 rounded-xl border border-gray-300 text-gray-700 bg-white shadow-sm hover:bg-blue-600 hover:text-white hover:shadow-md transition duration-200";
  btn.textContent = label;
  btn.dataset.categoryId = id;

  btn.addEventListener("click", () => {
    currentCategoryId = id;
    highlightCategoryButtons(id);
    applyFiltersLocal();

    if (currentQuery.trim() !== "") runServerSearch();
  });

  return btn;
}

function highlightCategoryButtons(activeId) {
  document.querySelectorAll("[data-category-id]").forEach((btn) => {
    const isActive = btn.dataset.categoryId == activeId;
    btn.classList.toggle("bg-blue-600", isActive);
    btn.classList.toggle("text-white", isActive);
    btn.classList.toggle("bg-white", !isActive);
    btn.classList.toggle("text-gray-700", !isActive);
  });
}

// =======================
// RENDER GRADE DROPDOWN
// =======================
function renderGradeDropdown() {
  const select = document.getElementById("gradeFilter");
  if (!select) return;

  select.innerHTML = `<option value="">Semua</option>`;

  grades.forEach((g) => {
    select.innerHTML += `
      <option value="${g.gradeName.toLowerCase()}">${g.gradeName}</option>
    `;
  });

  select.addEventListener("change", () => {
    currentGradeKey = select.value;
    applyFiltersLocal();

    if (currentQuery.trim() !== "") runServerSearch();
  });
}

// =======================
// LOCAL FILTER
// =======================
function applyFiltersLocal() {
  let filtered = catalogs;

  if (currentCategoryId !== "") {
    filtered = filtered.filter((item) => item.category_id == currentCategoryId);
  }

  if (currentGradeKey !== "") {
    filtered = filtered.filter(
      (item) =>
        item.grade &&
        item.grade.gradeName &&
        item.grade.gradeName.toLowerCase() === currentGradeKey
    );
  }

  if (currentQuery.trim() === "") {
    renderCatalog(filtered);
  }
}

// =======================
// RENDER CATALOG GRID
// =======================
function renderCatalog(items) {
  const container = document.getElementById("productGrid");
  if (!container) return;

  container.innerHTML = "";

  if (!items.length) {
    container.innerHTML = `
      <p class="col-span-full text-center text-gray-500 py-5">
        Tidak ada produk ditemukan.
      </p>`;
    return;
  }

  items.forEach((item) => {
    let images = [];

    if (Array.isArray(item.images)) {
      images = item.images;
    } else {
      try {
        images = item.images ? JSON.parse(item.images) : [];
      } catch {
        images = [];
      }
    }

    const imgUrl = images.length
      ? `/storage/${images[0]}`
      : `/images/noimage.png`;

    const card = `
      <div onclick="showDetail(
            '${escapeHtml(item.name)}',
            \`${escapeHtml(item.description || "")}\`,
            '${imgUrl}'
          )"
          class="bg-white p-4 rounded-xl shadow hover:shadow-lg cursor-pointer transition">

          <div class="w-full h-48 rounded mb-3 flex items-center justify-center overflow-hidden">
            <img src="${imgUrl}" class="object-contain w-full h-full" alt="${escapeHtml(item.name)}">
          </div>

          <h4 class="font-semibold text-gray-800">${escapeHtml(item.name)}</h4>
          <p class="text-sm text-gray-500">
            Rp ${(item.price || 0).toLocaleString()}
          </p>
      </div>
    `;

    container.innerHTML += card;
  });
}

// =======================
// SEARCH (SERVER)
// =======================
function setupSearchListener() {
  const searchInput = document.getElementById("searchInput");
  if (!searchInput) return;

  searchInput.addEventListener("keyup", () => {
    currentQuery = searchInput.value;

    if (currentQuery.trim() === "") {
      applyFiltersLocal();
      return;
    }

    runServerSearch();
  });
}

function runServerSearch() {
  const q = currentQuery.trim();

  fetch(
    `/katalog/search?q=${encodeURIComponent(q)}&category_id=${currentCategoryId}&grade=${currentGradeKey}`
  )
    .then((res) => res.json())
    .then((data) => renderCatalog(data))
    .catch((err) => console.error("Search error user:", err));
}

// =======================
// DETAIL PANEL (FIXED)
// =======================
function showDetail(name, desc, imgUrl) {
  document.getElementById("detailName").textContent = name;
  document.getElementById("detailDesc").textContent = desc || "";

  const imgEl = document.getElementById("detailImage");
  if (imgEl) imgEl.src = imgUrl || "/images/noimage.png";

  document.getElementById("productDetail").classList.remove("hidden");
}

function closeDetail() {
  document.getElementById("productDetail").classList.add("hidden");
}

// =======================
// FILTER MENU TOGGLE
// =======================
function toggleFilter() {
  const menu = document.getElementById("filterMenu");
  if (menu) menu.classList.toggle("hidden");
}

// =======================
// HELPERS
// =======================
function escapeHtml(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

window.showDetail = showDetail;
window.closeDetail = closeDetail;
window.toggleFilter = toggleFilter;
