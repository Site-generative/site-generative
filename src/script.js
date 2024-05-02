document.getElementById("email").autocomplete = "on";

// Skript pro odesílání formuláře pomocí AJAXu
$(document).ready(function() {
  $('#contact-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        console.log('AJAX call successful');
        $('#result').html(response);
      }
    });
  });
});

// Skript pro otevírání a zavírání FAQ položek
document.querySelectorAll(".accordion-item").forEach((item) => {
  item
    .querySelector(".accordion-item-header")
    .addEventListener("click", () => {
      item.classList.toggle("open");
    });
});

// Skript pro posun na danou sekci po kliknutí na odkazy v navbaru
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();

    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth",
    });
  });
});

// Skript pro posun na danou sekci po kliknutí na tlačítko v hero sekci
function smoothScroll(target) {
  document.querySelector(target).scrollIntoView({
    behavior: "smooth",
  });
}

// Skript pro otevírání a zavírání mobilního menu
function toggleMenu() {
  var mobileMenu = document.getElementById("mobileMenu");
  mobileMenu.classList.toggle("hidden");
}

function onSubmit(token) {
  document.getElementById("contact-form").submit();
}

window.addEventListener('scroll', function() {
  var heroSection = document.getElementById('hero');
  var scrollPosition = document.documentElement.scrollTop;
  var documentHeight = document.documentElement.scrollHeight;
  
  if (scrollPosition > documentHeight / 2) {
    heroSection.classList.add('disabled');
  } else {
    heroSection.classList.remove('disabled');
  }
});