/*FORM TAMBAH KERJAAN*/
const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");

if (openModal && closeModal && modal) {
    openModal.addEventListener("click", () => {
        modal.classList.remove("hidden");
    });

    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.add("hidden");
    });
}

// === AKTIFKAN TOMBOL EDIT DAN DELETE ===
document.querySelectorAll(".btn-edit").forEach((button) => {
    button.addEventListener("click", () => {
        // Ambil judul & deskripsi dari item yang diklik
        const parent = button.closest("div.flex.justify-between");
        const title = parent.querySelector("h3").textContent;
        const desc = parent.querySelector("p").textContent;

        openEditModal(title, desc);
    });
});

document.querySelectorAll(".btn-delete").forEach((button) => {
    button.addEventListener("click", () => {
        const parent = button.closest("div.flex.justify-between");
        const title = parent.querySelector("h3").textContent;

        openDeleteModal(title);
    });
});

/* MODAL EDIT */
const editModal = document.getElementById("editModal");
const closeEditModal = document.getElementById("closeEditModal");
const editTitle = document.getElementById("editTitle");
const editDesc = document.getElementById("editDesc");

function openEditModal(title, desc) {
    editTitle.value = title;
    editDesc.value = desc;
    editModal.classList.remove("hidden");
}
closeEditModal.addEventListener("click", () =>
    editModal.classList.add("hidden")
);
editModal.addEventListener("click", (e) => {
    if (e.target === editModal) editModal.classList.add("hidden");
});

/* MODAL DELETE */
const deleteModal = document.getElementById("deleteModal");
const cancelDelete = document.getElementById("cancelDelete");
const deleteTarget = document.getElementById("deleteTarget");

function openDeleteModal(name) {
    deleteTarget.textContent = `Apakah Anda yakin ingin menghapus "${name}"?`;
    deleteModal.classList.remove("hidden");
}
cancelDelete.addEventListener("click", () =>
    deleteModal.classList.add("hidden")
);
deleteModal.addEventListener("click", (e) => {
    if (e.target === deleteModal) deleteModal.classList.add("hidden");
});

const profileButton = document.getElementById("profileButton");
const profileMenu = document.getElementById("profileMenu");

// Toggle dropdown saat diklik
profileButton.addEventListener("click", () => {
    profileMenu.classList.toggle("hidden");
});

// Tutup dropdown kalau klik di luar
window.addEventListener("click", (e) => {
    if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add("hidden");
    }
});
