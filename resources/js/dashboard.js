document.addEventListener("DOMContentLoaded", () => {
    /* ================================
       BADGE (Status dan Jenis Dropdown)
    ================================= */
    function toggleMenu(button) {
        const menuId = button.getAttribute("data-menu");
        const menu = document.getElementById(menuId);

        // Tutup semua dropdown lain
        document.querySelectorAll('[id^="menu-"]').forEach((m) => {
            if (m !== menu) m.classList.add("hidden");
        });

        // Toggle dropdown yang dipilih
        menu.classList.toggle("hidden");
    }

    function setStatus(element, text, styleClasses) {
        const menu = element.closest("div[id^='menu-']");
        const button = document.querySelector(`[data-menu="${menu.id}"]`);

        // Update teks dan warna
        button.textContent = text;
        button.className = `flex items-center gap-2 px-3 py-1 text-xs font-medium rounded-full hover:bg-opacity-80 transition ${styleClasses}`;

        // Tutup menu
        menu.classList.add("hidden");
    }

    // Tutup dropdown jika klik di luar
    document.addEventListener("click", (e) => {
        if (
            e.target.closest("[data-menu]") ||
            e.target.closest("div[id^='menu-']")
        )
            return;
        document
            .querySelectorAll('[id^="menu-"]')
            .forEach((m) => m.classList.add("hidden"));
    });

    /* ================================
       FORM TAMBAH KERJAAN (Modal)
    ================================= */
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");

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

    /* ================================
       DROPDOWN DI CARD STATISTIK
    ================================= */
    document.querySelectorAll(".dropdown-btn").forEach((button) => {
        const card = button.closest("div.relative");
        const menu = card.querySelector(".dropdown-menu");
        const selectedPeriod = card.querySelector(".selected-period");

        button.addEventListener("click", (e) => {
            e.stopPropagation();
            document
                .querySelectorAll(".dropdown-menu")
                .forEach((m) => m.classList.add("hidden"));
            menu.classList.toggle("hidden");
        });

        menu.querySelectorAll("li").forEach((item) => {
            item.addEventListener("click", () => {
                selectedPeriod.textContent = item.textContent;
                menu.classList.add("hidden");
            });
        });
    });

    document.addEventListener("click", () => {
        document
            .querySelectorAll(".dropdown-menu")
            .forEach((menu) => menu.classList.add("hidden"));
    });

    /* ================================
   MODAL HAPUS PEKERJAAN
================================ */
    const deleteModal = document.getElementById("deleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const confirmDelete = document.getElementById("confirmDelete");

    // Buka modal saat tombol hapus diklik
    document.querySelectorAll(".fa-trash").forEach((btn) => {
        btn.addEventListener("click", () => {
            deleteModal.classList.remove("hidden");
        });
    });

    // Tutup modal
    cancelDelete.addEventListener("click", () => {
        deleteModal.classList.add("hidden");
    });

    // Klik luar area modal = tutup
    deleteModal.addEventListener("click", (e) => {
        if (e.target === deleteModal) deleteModal.classList.add("hidden");
    });

    // Konfirmasi hapus
    confirmDelete.addEventListener("click", () => {
        alert("Data berhasil dihapus (contoh aksi)");
        deleteModal.classList.add("hidden");
    });

    /* ================================
       EXPORT FUNCTION (JIKA PERLU)
    ================================= */
    window.toggleMenu = toggleMenu;
    window.setStatus = setStatus;
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

let currentRow = null; // baris yang sedang diedit

// Buka modal edit saat klik tombol edit
document.querySelectorAll(".fa-pen").forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const row = e.target.closest("tr");
        currentRow = row;

        const currentName = row
            .querySelector("td:first-child")
            .textContent.trim();
        document.getElementById("editNamaPekerjaan").value = currentName;

        document.getElementById("editModal").classList.remove("hidden");
    });
});

// Tutup modal edit
document.getElementById("cancelEdit").addEventListener("click", () => {
    document.getElementById("editModal").classList.add("hidden");
});

// Simpan perubahan nama pekerjaan
document.getElementById("editForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const newName = document.getElementById("editNamaPekerjaan").value.trim();

    if (newName && currentRow) {
        currentRow.querySelector("td:first-child").textContent = newName;
    }

    document.getElementById("editModal").classList.add("hidden");
});
