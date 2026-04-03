import Swiper from "swiper/bundle";
import "swiper/css/bundle";

// 🔹 Opsi Swiper default
const swiperOptions = {
    pagination: { el: ".swiper-pagination", clickable: true },
    loop: true,
    autoplay: { delay: 3500, disableOnInteraction: false },
    effect: "fade",
    fadeEffect: { crossFade: true },
};

// 🔹 INISIALISASI SEMUA SWIPER DINAMIS
document.querySelectorAll(".swiper").forEach((swiperEl) => {
    new Swiper(swiperEl, swiperOptions);
});

// 🔹 Elemen-elemen modal
const modal = document.getElementById("modal");
const modalTitle = document.getElementById("modalTitle");
const modalDesc = document.getElementById("modalDesc");
const modalImages = document.getElementById("modalImages");
const closeModal = document.getElementById("closeModal");

let modalSwiper = null;

// 🔹 Event listener untuk setiap card portofolio
document.querySelectorAll(".card").forEach((card) => {
    card.addEventListener("click", () => {
        const title = card.getAttribute("data-title");
        const desc = card.getAttribute("data-longdesc");

        const imageElements = card.querySelectorAll(".swiper-slide img");
        const images = Array.from(imageElements).map((img) => img.src);

        modalTitle.textContent = title;
        modalDesc.textContent = desc;

        modalImages.innerHTML = images
            .map(
                (img) => `
            <div class="swiper-slide flex justify-center items-center">
                <img src="${img}" class="w-auto max-w-full max-h-[80vh] object-contain rounded-xl shadow-md mx-auto">
            </div>
        `
            )
            .join("");

        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden";

        // Destroy modal swiper lama
        if (modalSwiper) modalSwiper.destroy(true, true);

        // Buat swiper modal baru
        modalSwiper = new Swiper(".modal-swiper", {
            loop: true,
            effect: "fade",
            fadeEffect: { crossFade: true },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                bulletClass:
                    "swiper-pagination-bullet !w-4 !h-4 !bg-blue-900/70 !opacity-100",
                bulletActiveClass:
                    "swiper-pagination-bullet-active !bg-blue-900",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    });
});

// 🔹 CLOSE MODAL
closeModal.addEventListener("click", () => {
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
});
