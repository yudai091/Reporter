var openBtn = document.getElementById("openBtn");
var closeBtn = document.getElementById("closeBtn");
var modal = document.getElementById("modal");

// 表示（openBtnというidのボタンがクリックされたら、display:blockになる）
openBtn.addEventListener("click", function () {
  modal.style.display = "block";
});
// 非表示（closeBtnというidのボタンがクリックされたら、display:noneになる）
closeBtn.addEventListener("click", function () {
  modal.style.display = "none";
});
