$(document).ready(function(){
  $("input, select, textarea, .bootstrap-tagsinput").focus(function () {
    $(this).addClass('focus');
  });
  
  $("input, select, textarea, .bootstrap-tagsinput").focusout(function () {
    $(this).removeClass('focus');
  });
})