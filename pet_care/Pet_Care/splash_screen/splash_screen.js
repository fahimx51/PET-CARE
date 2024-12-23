document.addEventListener("DOMContentLoaded", function () {
    const loader = document.querySelector(".loader");
    const splashScreen = document.querySelector(".splash-screen");
    loader.style.display = "none";
    splashScreen.style.display = "block";
    const email = '';
    setTimeout(function () {
        window.location.href = "../home/index.php?email="+ encodeURIComponent(email);
    }, 3000);//count in milisec (3sec)
});