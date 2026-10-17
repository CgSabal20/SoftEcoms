```php
<?php
session_start();

$pageClass = "register-page";

include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");
?>

<section class="login py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="p-4">

                    <h2 class="mb-4 text-center">Create Account</h2>

                    <form id="registerForm" autocomplete="off">

                        <label for="firstName">
                            First Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="firstName"
                            name="firstName"
                            required
                            autocomplete="given-name"
                        >

                        <label for="lastName">
                            Last Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="lastName"
                            name="lastName"
                            required
                            autocomplete="family-name"
                        >

                        <label for="middleName">Middle Name</label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="middleName"
                            name="middleName"
                            autocomplete="additional-name"
                        >

                        <label for="email">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control mb-3"
                            id="email"
                            name="email"
                            required
                            autocomplete="email"
                        >

                        <label for="contact">
                            Contact Number <span class="text-danger">*</span>
                        </label>
                        <input
                            type="tel"
                            class="form-control mb-3"
                            id="contact"
                            name="contact"
                            required
                            autocomplete="tel"
                        >

                        <label for="username">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="username"
                            name="username"
                            required
                            autocomplete="username"
                        >

                        <label for="password">
                            Password <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            class="form-control mb-3"
                            id="password"
                            name="password"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >

                        <label for="confirmPassword">
                            Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            class="form-control mb-3"
                            id="confirmPassword"
                            name="confirmPassword"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >

                        <label for="street">
                            Street <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="street"
                            name="street"
                            required
                            autocomplete="street-address"
                        >

                        <label for="barangay">
                            Barangay <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="barangay"
                            name="barangay"
                            required
                        >

                        <label for="city">
                            City <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="city"
                            name="city"
                            required
                            autocomplete="address-level2"
                        >

                        <button
                            type="submit"
                            id="registerButton"
                            class="btn btn-success w-100 mt-2"
                        >
                            Register
                        </button>

                        <p class="text-center mt-3">
                            Already have an account?
                            <a href="/SoftEcoms/public/login.php">Login</a>
                        </p>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const registerForm = document.getElementById("registerForm");
const registerButton = document.getElementById("registerButton");

registerForm.addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(registerForm);

    const data = Object.fromEntries(formData.entries());

    if (data.password !== data.confirmPassword) {
        Swal.fire({
            icon: "error",
            title: "Password mismatch",
            text: "Your passwords do not match."
        });
        return;
    }

    registerButton.disabled = true;
    registerButton.textContent = "Registering...";

    try {
        const response = await fetch("http://localhost:3000/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || "Registration failed.");
        }

        await Swal.fire({
            icon: "success",
            title: "Check your email!",
            text: result.message,
            confirmButtonText: "Go to Login"
        });

        window.location.href =
            result.redirect || "/SoftEcoms/public/login.php";

    } catch (error) {
        console.error("Registration error:", error);

        Swal.fire({
            icon: "error",
            title: "Registration failed",
            text: error.message ||
                "Could not connect to the server. Please try again."
        });
    } finally {
        registerButton.disabled = false;
        registerButton.textContent = "Register";
    }
});
</script>

</body>
</html>
```