$('document').ready(function() {
    setTimeout(() => {
        $('.splash-screen').fadeOut(50);
        window.location.href = "../../index.php";
    }, 3000);
});