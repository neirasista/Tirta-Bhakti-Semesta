document.addEventListener("DOMContentLoaded", () => {
    /* === MODAL TAMBAH === */
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
    const addImage = document.getElementById("addImage");
    const addPreview = document.getElementById("addPreview");

    if (openModal && closeModal && modal) {
        openModal.addEventListener("click", () =>
            modal.classList.remove("hidden")
        );
        closeModal.addEventListener("click", () =>
            modal.classList.add("hidden")
        );
        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.add("hidden");
        });
    }

    if (addImage) {
        addImage.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    addPreview.src = ev.target.result;
                    addPreview.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                addPreview.classList.add("hidden");
            }
        });
    }

    /* === MODAL EDIT === */
    const editModal = document.getElementById("editModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const editTitle = document.getElementById("editTitle");
    const editLink = document.getElementById("editLink");
    const editGambar = document.getElementById("editGambar");
    const editPreview = document.getElementById("editPreview");

    function openEditModal(title, link, imageSrc) {
        if (editTitle) editTitle.value = title || "";
        if (editLink) editLink.value = link || "";

        if (imageSrc) {
            editPreview.src = imageSrc;
            editPreview.classList.remove("hidden");
        } else {
            editPreview.classList.add("hidden");
        }

        editGambar.value = "";
        editModal.classList.remove("hidden");
    }

    if (editGambar) {
        editGambar.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    editPreview.src = ev.target.result;
                    editPreview.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            } else {
                editPreview.classList.add("hidden");
            }
        });
    }

    if (closeEditModal) {
        closeEditModal.addEventListener("click", () =>
            editModal.classList.add("hidden")
        );
    }
    editModal.addEventListener("click", (e) => {
        if (e.target === editModal) editModal.classList.add("hidden");
    });

    /* === MODAL DELETE === */
    const deleteModal = document.getElementById("deleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const deleteTarget = document.getElementById("deleteTarget");

    function openDeleteModal(name) {
        if (deleteTarget) {
            deleteTarget.textContent = `Apakah Anda yakin ingin menghapus "${name}"?`;
        }
        deleteModal.classList.remove("hidden");
    }

    if (cancelDelete) {
        cancelDelete.addEventListener("click", () =>
            deleteModal.classList.add("hidden")
        );
    }
    deleteModal.addEventListener("click", (e) => {
        if (e.target === deleteModal) deleteModal.classList.add("hidden");
    });

    /* === AKTIFKAN SEMUA TOMBOL EDIT & DELETE DI CARD === */
    document.querySelectorAll(".btn-edit").forEach((button) => {
        button.addEventListener("click", () => {
            const title = button.getAttribute("data-title");
            const link = button.getAttribute("data-link");
            const imageSrc = button.getAttribute("data-image");
            openEditModal(title, link, imageSrc);
        });
    });

    document.querySelectorAll(".btn-delete").forEach((button) => {
        button.addEventListener("click", () => {
            const title = button.getAttribute("data-title");
            openDeleteModal(title);
        });
    });
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
