var openBtn = document.querySelectorAll(".openBtn");
var closeBtn = document.querySelectorAll(".closeBtn");
var modal = document.querySelector("#modal");

for (var i = 0; i < openBtn.length; i++) {
  openBtn[i].addEventListener("click", function () {
    modal.style.display = "block";
  });
  closeBtn[i].addEventListener("click", function () {
    modal.style.display = "none";
  });
}
