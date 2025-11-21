document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const email = document.getElementById("loginEmail").value.trim();
            const password = document.getElementById("loginPassword").value.trim();

            let isValid = true;

            if (email === "") {
                document.getElementById("loginEmailError").innerText = "Email is required.";
                isValid = false;
            } else {
                document.getElementById("loginEmailError").innerText = "";
            }

            if (password.length < 6) {
                document.getElementById("loginPasswordError").innerText = "Password must be at least 6 characters.";
                isValid = false;
            } else {
                document.getElementById("loginPasswordError").innerText = "";
            }

            if (isValid) {
                alert("Login successful (front-end only)");
            }
        });
    }

    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const name = document.getElementById("regName").value.trim();
            const email = document.getElementById("regEmail").value.trim();
            const password = document.getElementById("regPassword").value.trim();
            const confirmPassword = document.getElementById("regConfirmPassword").value.trim();

            let isValid = true;

            if (name === "") {
                document.getElementById("regNameError").innerText = "Full name is required.";
                isValid = false;
            } else {
                document.getElementById("regNameError").innerText = "";
            }

            if (email === "") {
                document.getElementById("regEmailError").innerText = "Email is required.";
                isValid = false;
            } else {
                document.getElementById("regEmailError").innerText = "";
            }

            if (password.length < 6) {
                document.getElementById("regPasswordError").innerText = "Password must be at least 6 characters.";
                isValid = false;
            } else {
                document.getElementById("regPasswordError").innerText = "";
            }

            if (confirmPassword !== password) {
                document.getElementById("regConfirmPasswordError").innerText = "Passwords do not match.";
                isValid = false;
            } else {
                document.getElementById("regConfirmPasswordError").innerText = "";
            }

            if (isValid) {
                alert("Registration successful (front-end only)");
            }
        });
    }
});
