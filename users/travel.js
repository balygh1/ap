let searchBtn = document.querySelector("#search-btn")
let searchForm = document.querySelector(".search-form") 
let loginForm = document.querySelector(".login-form")
let menuBar = document.querySelector("#menu-bar")
let amenu = document.querySelector(".navbar")
let vidBtn = document.querySelectorAll(".video-btn")

function showbar(){
    searchBtn.classList.toggle("fa-times")
    searchForm.classList.toggle("active")
}
function showform(){
    loginForm.classList.add("active")
}
function hideform(){
    loginForm.classList.remove("active")

}
function showmenu(){
    menuBar.classList.toggle("fa-times")
    amenu.classList.toggle("active")
}
vidBtn.forEach(slide =>{let searchBtn = document.querySelector("#search-btn");
let searchForm = document.querySelector(".search-form");
let loginForm = document.querySelector(".login-form");
let signupForm = document.querySelector(".signup-form"); // إضافة للنموذج الجديد
let menuBar = document.querySelector("#menu-bar");
let amenu = document.querySelector(".navbar");
let vidBtn = document.querySelectorAll(".video-btn");

function showbar() {
    searchBtn.classList.toggle("fa-times");
    searchForm.classList.toggle("active");
}

function showLoginForm() {
    loginForm.classList.add("active");
    if (signupForm) signupForm.classList.remove("active"); // إخفاء نموذج التسجيل إذا كان ظاهرًا
}

function hideLoginForm() {
    loginForm.classList.remove("active");
}

function showSignupForm() {
    if (signupForm) signupForm.classList.add("active");
    loginForm.classList.remove("active"); // إخفاء نموذج تسجيل الدخول إذا كان ظاهرًا
}

function hideSignupForm() {
    if (signupForm) signupForm.classList.remove("active");
}

function showmenu() {
    menuBar.classList.toggle("fa-times");
    amenu.classList.toggle("active");
}
function hideMessage() {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000); // 5000 مللي ثانية = 5 ثوانٍ
    }

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000); // 5000 مللي ثانية = 5 ثوانٍ
    }
}

// استدعاء الدالة عند تحميل الصفحة
window.onload = hideMessage;

if (vidBtn) {
    vidBtn.forEach(slide => {
        slide.addEventListener("click", function () {
            document.querySelector(".controls .blue").classList.remove("blue");
            slide.classList.add("blue");
            let src = slide.getAttribute("data-src");
            document.querySelector("#video-slider").src = src;
        });
    });
}

if (document.querySelector(".review-slider")) {
    var swiper = new Swiper(".review-slider", {
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 2500
        },
        breakpoints: {
            640: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
}
    slide.addEventListener("click" , function(){
        document.querySelector(".controls .blue").classList.remove("blue");
        slide.classList.add("blue");
        let src = slide.getAttribute("data-src");
        document.querySelector("#video-slider").src = src;
    })
})

var swiper = new Swiper(".review-slider", {
    spaceBetween :20,
    loop:true,
    autoplay:{
        delay:2500
    },
    breakpoints:{
        640:{
            slidesPerView:1
        },
        768:{
            slidesPerView:2
        },
        1024:{
            slidesPerView:3
        }
    }
});