document.addEventListener("DOMContentLoaded", function () {
  var prevScrollPos = window.pageYOffset;
  var header = document.getElementById("main-header");

  window.onscroll = function () {
    var currentScrollPos = window.pageYOffset;

    if (prevScrollPos > currentScrollPos) {
      header.classList.remove("header-scrolled");
    } else {
      header.classList.add("header-scrolled");
    }

    prevScrollPos = currentScrollPos;
  };
});
