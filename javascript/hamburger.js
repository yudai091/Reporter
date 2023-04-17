jQuery(function ($) {
  $(function () {
    $("#nav-open").on("click", function () {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("#nav-content").removeClass("open").fadeOut(100);
      } else {
        $(this).addClass("active");
        $("#nav-content").fadeIn(100).addClass("open");
      }
    });
  });
});
