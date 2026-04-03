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
