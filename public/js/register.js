(function () {
    // additional smoothness: live age validation hint (just ui feedback)
    const ageInput = document.querySelector('input[name="age"]');
    if (ageInput) {
        ageInput.addEventListener("input", function (e) {
            let val = parseInt(this.value, 10);
            if (val < 18) this.value = 18;
            if (val > 90) this.value = 90;
            if (isNaN(val)) this.value = 18;
        });
    }

    // password confirmation real-time hint (optional but nice)
    const passwordField = document.querySelector('input[name="password"]');
    const confirmField = document.querySelector(
        'input[name="password_confirmation"]'
    );
    if (passwordField && confirmField) {
        function checkMatch() {
            let pass = passwordField.value;
            let conf = confirmField.value;
            let parent = confirmField.closest(".input-group");
            let existingError = parent.querySelector(".confirm-match-error");
            if (conf.length > 0 && pass !== conf) {
                if (!existingError) {
                    let errSpan = document.createElement("div");
                    errSpan.className = "input-error confirm-match-error";
                    errSpan.innerHTML =
                        '<i class="fas fa-times-circle"></i> كلمات المرور غير متطابقة';
                    parent.appendChild(errSpan);
                }
            } else {
                if (existingError) existingError.remove();
            }
        }
        passwordField.addEventListener("input", checkMatch);
        confirmField.addEventListener("input", checkMatch);
    }

    // provide styling for any server side error that appears from blade @error or $errors
    let errorBlocks = document.querySelectorAll(".input-error");
    errorBlocks.forEach((err) => {
        if (err.innerText.trim() !== "") {
            err.style.marginTop = "0.5rem";
            err.style.fontSize = "0.75rem";
            err.style.background = "rgba(239, 68, 68, 0.12)";
            err.style.borderRadius = "12px";
            err.style.padding = "0.35rem 0.8rem";
            err.style.fontWeight = "500";
        }
    });
})();
