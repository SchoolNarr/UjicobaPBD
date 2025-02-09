(function ($) {
    "use strict";

    $("body").on("click", "[data-ma-action]", function (e) {
        e.preventDefault();
        var $this = $(this),
            action = $this.data("ma-action");

        switch (action) {
            case "nk-login-switch":
                var loginblock = $this.data("ma-block"),
                    loginParent = $this.closest(".nk-block");
                loginParent.removeClass("toggled");
                setTimeout(function () {
                    $(loginblock).addClass("toggled");
                });
                break;

            case "print":
                window.print();
                break;

            case "login":
                var username = $('input[placeholder="Username"]').val();
                var password = $('input[placeholder="Password"]').val();

                // Contoh validasi sederhana
                if (username === "admin" && password === "password123") {
                    alert("Login berhasil! Mengalihkan ke dashboard...");
                    window.location.href = "dashboard.php"; // Redirect ke dashboard
                } else {
                    alert("Username atau password salah!");
                }
                break;
        }
    });

})(jQuery);
