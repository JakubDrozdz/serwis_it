function hamburger() {
    const hamburger = document.querySelector(".hamburger");
    hamburger.classList.toggle("hamburger--active");
    const links = document.getElementById("links");
    var logged = document.getElementById("logged");
    if (links.style.display === "block") {
        setTimeout(function () {
            links.style.display = "none";
            hamburger.style = "top:50%;";
            logged.style = "top:50%;";
        }, 300);

    } else {
        if (window.screen.availWidth <= 1000) {
            setTimeout(function () {
                links.style.display = "block";
                hamburger.style = "top:16%;";
            }, 300);
        } else {
            setTimeout(function () {
                links.style.display = "block";
                hamburger.style = "top:11.2%;";
                logged.style = "top:11.2%;";
            }, 300);
        }
    }
}

function create_user() {
    var password = document.getElementById("password");
    var pass = document.getElementById("pass");
    if (password.style.display === "none") {
        password.style.display = "block";
        pass.required = "required";


    } else {
        password.style.display = "none";
        pass.required = false;
    }
}

function logout_button() {
    var logged = document.getElementById("logged");
    logged.innerHTML = "<h2>WYLOGUJ SIĘ</h2>";
    logged.addEventListener("click", function () {
        window.location.replace('http://127.0.0.1/serwis_it/site/php/logout.php');
    })
}

function login() {
    window.location.replace('http://127.0.0.1/serwis_it/site/php/login_form.php');
}