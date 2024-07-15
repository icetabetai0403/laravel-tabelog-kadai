document.addEventListener("DOMContentLoaded", function () {
    var forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var submitButton = form.querySelector(".nagoyameshi-submit-button");
            if (submitButton) {
                if (!submitButton.disabled) {
                    submitButton.disabled = true;
                } else {
                    e.preventDefault(); // フォームの送信を阻止
                }
            }
        });
    });
});
