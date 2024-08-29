$(document).ready(function() {
    $(".eyeicon").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var passwordInput = $("input[name='password']");
        passwordInput.attr("type", passwordInput.attr("type") === "password"? "text" : "password");
    });
});