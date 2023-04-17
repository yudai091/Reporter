"use strict";
var form = document.getElementById("registrationform");
var input_studentId = document.getElementById("student_id");
var submit = document.getElementById("button");

input_studentId.addEventListener("input", function () {
  if (!input_studentId.value) {
    input_studentId.setCustomValidity("");
  } else if (false === form.checkValidity()) {
    input_studentId.setCustomValidity("半角英数字で入力して下さい");
    submit.click();
    return;
  }
  input_studentId.setCustomValidity("");
});
