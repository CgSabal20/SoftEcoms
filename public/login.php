<?php
session_start();

$pageClass = "login-page";

include('admin/includes/header.php');
include('admin/includes/topbar.php');
?>

<section class="login d-flex align-items-center" style="height: 90vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 m-auto text-center">
                <h2 class="mb-4">Login</h2>

                <form id="loginForm" autocomplete="on">
                    <input
                        type="email"
                        class="form-control mb-3"
                        placeholder="Email"
                        name="email"
                        id="email"
                        autocomplete="username"
                        required
                    >

                    <input
                        type="password"
                        class="form-control mb-3"
                        placeholder="Password"
                        name="password"
                        id="password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="submit"
                        class="btn1 w-100 mb-3"
                        id="loginButton"
                    >
                        Login
                    </button>

                    <p>
                        Don't have an account?
                        <a href="register">Register</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const loginForm = document.getElementById("loginForm");
const loginButton = document.getElementById("loginButton");

loginForm.addEventListener("submit", async function (event) {
    event.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    if (!email || !password) {
        Swal.fire({
            icon: "warning",
            title: "Missing information",
            text: "Please enter your email and password."
        });
        return;
    }

    loginButton.disabled = true;
    loginButton.textContent = "Logging in...";

    try {
        const response = await fetch("http://localhost:3000/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify({ email, password })
        });

   
        const responseText = await response.text();
        let data;

        try {
            data = JSON.parse(responseText);
        } catch {
            console.error("Unexpected server response:", responseText);
            throw new Error(
                "The authentication server returned an invalid response."
            );
        }

        if (!response.ok) {
            await Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: data.message || `Login failed (${response.status})`,
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true
            });
            return;
        }

        await Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: data.message || "Login successful!",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });

        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            console.error("No redirect URL returned by the server.");
        }

    } catch (error) {
        console.error("Login request failed:", error);

        Swal.fire({
            icon: "error",
            title: "Unable to log in",
            text: error.message || "Could not connect to the authentication server. Check that Node.js is running."
        });

    } finally {
        loginButton.disabled = false;
        loginButton.textContent = "Login";
    }
});
</script>

</body>
</html>
