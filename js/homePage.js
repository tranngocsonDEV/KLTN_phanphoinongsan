var swiper = new Swiper(".swiper", {
  spaceBetween: 30,
  centeredSlides: true,

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  }
});
let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");
menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};
window.onscroll = () => {
  menu.classList.remove("bx-x");
  navbar.classList.remove("active");
};

// Chọn phần tử nút cuộn lên đầu trang
const scrollTopButton = document.querySelector(".scrollTop");

// Hàm xử lý sự kiện cuộn
window.addEventListener("scroll", () => {
  // Kiểm tra vị trí cuộn hiện tại
  if (window.scrollY > 599) {
    // Hiển thị nút khi cuộn xuống quá 100px
    scrollTopButton.style.display = "block";
  } else {
    // Ẩn nút khi ở gần đầu trang
    scrollTopButton.style.display = "none";
  }
});
function scrollToTop() {
  window.scrollTo(0, 0);
}
