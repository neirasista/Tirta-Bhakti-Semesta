document.addEventListener("DOMContentLoaded", () => {
    loadCatalog();
    initSearch();
    initGradeFilter();   // ✅ tambah ini
});

// ===============================
// STATE FILTER + SEARCH
// ===============================
let ALL_ITEMS = [];
let ACTIVE_CATEGORY_ID = null;
let ACTIVE_GRADE_KEY = "";   // ✅ tambah state grade
let SEARCH_KEYWORD = "";

// ===============================
// LOAD LIST
// ===============================
async function loadCatalog() {
    try {
        const res = await fetch("/admin/catalogue/list");
        const data = await res.json();

        ALL_ITEMS = data || [];
        applyFilterAndRender();
    } catch (err) {
        console.error("Load error:", err);
    }
}

// ===============================
// APPLY FILTER + SEARCH + GRADE
// ===============================
function applyFilterAndRender() {
    let items = [...ALL_ITEMS];

    // filter kategori
    if (ACTIVE_CATEGORY_ID) {
        items = items.filter(
            (it) => Number(it.category_id) === Number(ACTIVE_CATEGORY_ID)
        );
    }

    // ✅ filter grade (modelnya pakai relasi grade)
    if (ACTIVE_GRADE_KEY && ACTIVE_GRADE_KEY !== "") {
        const map = {
            gradeA: "grade a",
            gradeB: "grade b",
            gradeC: "grade c",
        };

        const target = map[ACTIVE_GRADE_KEY] || ACTIVE_GRADE_KEY.toLowerCase();

        items = items.filter(
            (it) =>
                it.grade &&
                it.grade.gradeName &&
                it.grade.gradeName.toLowerCase() === target
        );
    }

    // search
    if (SEARCH_KEYWORD.trim() !== "") {
        const k = SEARCH_KEYWORD.toLowerCase();
        items = items.filter(
            (it) =>
                (it.name || "").toLowerCase().includes(k) ||
                (it.description || "").toLowerCase().includes(k)
        );
    }

    renderCatalog(items);
}

// ===============================
// RENDER GRID
// ===============================
function renderCatalog(items) {
    const container = document.querySelector("#katalogGrid");
    container.innerHTML = "";

    if (!items.length) {
        container.innerHTML = `
            <p class="col-span-full text-center text-gray-500 py-5">
                Tidak ada produk ditemukan.
            </p>`;
        return;
    }

    items.forEach((item) => {
        const images = item.images || [];
        const imgTag = images.length
            ? `<img src="/storage/${images[0]}" class="w-full h-48 object-contain mb-3" />`
            : `<div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">Tidak ada gambar</div>`;

        container.innerHTML += `
            <div class="bg-white p-4 rounded-xl shadow">
                ${imgTag}

                <h3 class="font-semibold">${item.name}</h3>
                <p class="text-sm text-gray-500">${item.description ?? ""}</p>
                <p class="text-sm text-gray-700">Rp ${Number(item.price).toLocaleString()}</p>

                <div class="flex gap-2 mt-3">
                    <button onclick="editCatalog(${item.id})" class="px-3 py-1 bg-blue-600 text-white rounded">Edit</button>
                    <button onclick="deleteCatalog(${item.id})" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        `;
    });
}

// ===============================
// CREATE
// ===============================
window.addCatalog = async function () {
    const form = document.querySelector("#catalogForm");
    const formData = new FormData(form);

    try {
        const res = await fetch("/admin/catalogue", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!res.ok) throw new Error(await res.text());

        closeAddModal();
        form.reset();
        loadCatalog(); // reload
    } catch (err) {
        console.error(err);
        alert("Gagal menambah produk");
    }
};

// ===============================
// FETCH DETAIL (EDIT)
// ===============================
window.editCatalog = async function (id) {
    const res = await fetch(`/admin/catalogue/${id}/edit`);
    const item = await res.json();

    document.querySelector("#edit_id").value = item.id;
    document.querySelector("#edit_name").value = item.name;
    document.querySelector("#edit_description").value = item.description;
    document.querySelector("#edit_grade_id").value = item.grade_id;
    document.querySelector("#edit_category_id").value = item.category_id;
    document.querySelector("#edit_price").value = item.price;

    const images = item.images || [];
    const preview = document.querySelector("#edit_preview_img");

    if (images.length) {
        preview.src = `/storage/${images[0]}`;
        preview.classList.remove("hidden");
    } else {
        preview.classList.add("hidden");
    }

    openEditModal();
};

// ===============================
// UPDATE
// ===============================
window.updateCatalog = async function () {
    const id = document.querySelector("#edit_id").value;
    const form = document.querySelector("#editCatalogForm");
    const formData = new FormData(form);

    try {
        const res = await fetch(`/admin/catalogue/${id}`, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!res.ok) throw new Error(await res.text());

        closeEditModal();
        loadCatalog();
    } catch (err) {
        console.error(err);
        alert("Gagal mengupdate");
    }
};

// ===============================
// DELETE
// ===============================
window.deleteCatalog = async function (id) {
    if (!confirm("Hapus produk ini?")) return;

    const res = await fetch(`/admin/catalogue/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    });

    if (res.ok) loadCatalog();
    else alert("Gagal menghapus");
};

// ===============================
// FILTER KATEGORI
// ===============================
window.filterByCategory = function (catId) {
    ACTIVE_CATEGORY_ID = catId;
    applyFilterAndRender();
};

window.resetFilter = function () {
    ACTIVE_CATEGORY_ID = null;
    applyFilterAndRender();
};

// ===============================
// SEARCH BAR
// ===============================
function initSearch() {
    const input = document.querySelector("#searchInput"); // ✅ lebih aman pakai id
    if (!input) return;

    input.addEventListener("input", (e) => {
        SEARCH_KEYWORD = e.target.value;
        applyFilterAndRender();
    });
}

// ===============================
// ✅ FILTER GRADE DROPDOWN
// ===============================
function initGradeFilter() {
    const select = document.querySelector("#gradeFilterSelect");
    if (!select) return;

    select.addEventListener("change", (e) => {
        ACTIVE_GRADE_KEY = e.target.value; // gradeA/gradeB/gradeC/empty
        applyFilterAndRender();
    });
}

// ===============================
// FILTER MENU TOGGLE
// ===============================
window.toggleFilter = function () {
    const menu = document.getElementById("filterMenu");
    if (!menu) return;
    menu.classList.toggle("hidden");
};

// ===============================
// MODAL
// ===============================
window.openAddModal = () => document.getElementById("addModal").classList.remove("hidden");
window.closeAddModal = () => document.getElementById("addModal").classList.add("hidden");

window.openEditModal = () => document.getElementById("editModal").classList.remove("hidden");
window.closeEditModal = () => document.getElementById("editModal").classList.add("hidden");
