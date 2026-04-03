/* === MODAL TAMBAH === */
const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");

if (openModal && closeModal && modal) {
    openModal.addEventListener("click", () => modal.classList.remove("hidden"));
    closeModal.addEventListener("click", () => modal.classList.add("hidden"));
    modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.add("hidden");
    });
}

/* === MODAL EDIT === */
const editModal = document.getElementById("editModal");
const closeEditModal = document.getElementById("closeEditModal");
const editForm = document.getElementById("editForm");
const editTitle = document.getElementById("editTitle");
const editDesc = document.getElementById("editDesc");
const editGambar = document.getElementById("editGambar");
const editPreview = document.getElementById("editPreview");

// buka modal edit dengan data dynamic
function openEditModalDynamic(id, title, desc, imagesJSON) {

    const images = JSON.parse(imagesJSON);

    // isi field
    editTitle.value = title;
    editDesc.value = desc;

    // preview gambar lama (gambar pertama)
    if (images.length > 0) {
        editPreview.src = "/storage/" + images[0];
        editPreview.classList.remove("hidden");
    } else {
        editPreview.classList.add("hidden");
    }

    // generate action edit form
    editForm.action = `/admin/compro/portofolio/${id}`;

    // buka modal
    editModal.classList.remove("hidden");
}

// preview gambar baru jika diubah
editGambar?.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            editPreview.src = ev.target.result;
            editPreview.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    }
});

// tutup modal edit
closeEditModal?.addEventListener("click", () =>
    editModal.classList.add("hidden")
);

editModal?.addEventListener("click", (e) => {
    if (e.target === editModal) editModal.classList.add("hidden");
});

/* === AKTIFKAN EDIT BUTTON === */
document.querySelectorAll(".btn-edit").forEach((btn) => {
    btn.addEventListener("click", () => {
        openEditModalDynamic(
            btn.dataset.id,
            btn.dataset.title,
            btn.dataset.desc,
            btn.dataset.images
        );
    });
});

/* === MODAL DELETE === */
const deleteModal = document.getElementById("deleteModal");
const cancelDelete = document.getElementById("cancelDelete");
const deleteTarget = document.getElementById("deleteTarget");

function openDeleteModal(name) {
    deleteTarget.textContent = `Apakah Anda yakin ingin menghapus "${name}"?`;
    deleteModal.classList.remove("hidden");
}

cancelDelete?.addEventListener("click", () =>
    deleteModal.classList.add("hidden")
);

deleteModal?.addEventListener("click", (e) => {
    if (e.target === deleteModal) deleteModal.classList.add("hidden");
});

/* === AKTIFKAN DELETE BUTTON === */
document.querySelectorAll(".btn-delete").forEach((btn) => {
    btn.addEventListener("click", () => {
        const title = btn.dataset.title;
        openDeleteModal(title);
    });
});

/* === PROFILE DROPDOWN === */
const profileButton = document.getElementById("profileButton");
const profileMenu = document.getElementById("profileMenu");

profileButton?.addEventListener("click", () => {
    profileMenu.classList.toggle("hidden");
});

window.addEventListener("click", (e) => {
    if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add("hidden");
    }
});
