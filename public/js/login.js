(function () {
    // Enhance form with simple client-side validation for empty fields
    const form = document.getElementById("loginForm");
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');

    // Function to remove error borders
    function removeErrorBorder(input) {
        input.classList.remove("error-border");
    }

    function addErrorBorder(input) {
        input.classList.add("error-border");
        setTimeout(() => {
            if (input) input.classList.remove("error-border");
        }, 2500);
    }

    if (form) {
        form.addEventListener("submit", function (e) {
            let hasError = false;
            const emailVal = emailInput ? emailInput.value.trim() : "";
            const passVal = passwordInput ? passwordInput.value : "";

            if (emailVal === "") {
                e.preventDefault();
                addErrorBorder(emailInput);
                hasError = true;
                // show temporary floating hint?
                if (
                    emailInput &&
                    !emailInput.nextElementSibling?.classList?.contains(
                        "inline-error"
                    )
                ) {
                    const errSpan = document.createElement("div");
                    errSpan.className = "redirect-message red";
                    errSpan.style.marginTop = "0.5rem";
                    errSpan.style.marginBottom = "0";
                    errSpan.style.padding = "0.4rem 0.8rem";
                    errSpan.innerHTML =
                        '<i class="fas fa-exclamation-circle"></i> Email is required';
                    emailInput.parentNode.insertBefore(
                        errSpan,
                        emailInput.nextSibling
                    );
                    setTimeout(() => errSpan.remove(), 3000);
                }
            }
            if (passVal === "") {
                e.preventDefault();
                addErrorBorder(passwordInput);
                hasError = true;
                if (
                    passwordInput &&
                    !passwordInput.nextElementSibling?.classList?.contains(
                        "inline-error"
                    )
                ) {
                    const errSpan = document.createElement("div");
                    errSpan.className = "redirect-message red";
                    errSpan.style.marginTop = "0.5rem";
                    errSpan.style.marginBottom = "0";
                    errSpan.style.padding = "0.4rem 0.8rem";
                    errSpan.innerHTML =
                        '<i class="fas fa-exclamation-circle"></i> Password is required';
                    passwordInput.parentNode.insertBefore(
                        errSpan,
                        passwordInput.nextSibling
                    );
                    setTimeout(() => errSpan.remove(), 3000);
                }
            }
            if (hasError) {
                e.preventDefault();
            }
        });
    }

    // remove error border on focus
    if (emailInput)
        emailInput.addEventListener("focus", () =>
            removeErrorBorder(emailInput)
        );
    if (passwordInput)
        passwordInput.addEventListener("focus", () =>
            removeErrorBorder(passwordInput)
        );

    // automatically fade out redirect messages after 5 seconds? (optional smooth)
    const messages = document.querySelectorAll(".redirect-message");
    messages.forEach((msg) => {
        setTimeout(() => {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = "0";
            setTimeout(() => {
                if (msg.parentNode) msg.remove();
            }, 500);
        }, 5000);
    });

    // if there's any session fail or success message, they stay but auto-hide is user-friendly.
    // additionally, support for old() values persistence
    const urlParams = new URLSearchParams(window.location.search);
    if (
        urlParams.has("error") &&
        !document.querySelector(".redirect-message.red")
    ) {
        // optional: if fail from server but not via session, keep consistent.
    }
})();
