const swiper = new Swiper(".hero-swiper", {
    loop: true, // agar muter terus
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    // pagination: false (tidak perlu ditulis, pagination defaultnya tidak ada)
});
