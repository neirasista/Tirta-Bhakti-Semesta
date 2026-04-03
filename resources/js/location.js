const editModal = document.getElementById("editModal");
const deleteModal = document.getElementById("deleteModal");
const closeEditModal = document.getElementById("closeEditModal");
const cancelDelete = document.getElementById("cancelDelete");
const confirmDelete = document.getElementById("confirmDelete");
const mapFrame = document.getElementById("mapFrame");
const mapInput = document.getElementById("mapInput");

document.getElementById("editLocationBtn").addEventListener("click", () => {
    mapInput.value = mapFrame.src;
    editModal.classList.remove("hidden");
});

closeEditModal.addEventListener("click", () =>
    editModal.classList.add("hidden")
);
editModal.addEventListener("click", (e) => {
    if (e.target === editModal) editModal.classList.add("hidden");
});

document.getElementById("saveLocation").addEventListener("click", () => {
    const newUrl = mapInput.value.trim();
    if (newUrl) {
        mapFrame.src = newUrl;
        editModal.classList.add("hidden");
    }
});

document.getElementById("deleteLocationBtn").addEventListener("click", () => {
    deleteModal.classList.remove("hidden");
});

cancelDelete.addEventListener("click", () =>
    deleteModal.classList.add("hidden")
);
deleteModal.addEventListener("click", (e) => {
    if (e.target === deleteModal) deleteModal.classList.add("hidden");
});

confirmDelete.addEventListener("click", () => {
    mapFrame.src = "";
    deleteModal.classList.add("hidden");
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
