<?php
session_start();

$pageClass = "index-page";

include('includes/header.php');
include('includes/topbar.php');
include_once("../app/config/config.php");
?>

<section class="registerOverlay">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col">
                <div class="card card-registration my-4">
                    <div class="row g-0">

                    <!-- ang right side na img, I figured na maka save ko og time and pag pangita if in ani ko ni hehe! --> 
                        <div class="col-xl-5 d-none d-xl-block registerSide"></div>

                        <!-- Right side ang form -->
                        <div class="col-xl-7">
                            <div class="card-body p-4 p-md-5 text-black">

                                <h3 class="mb-4 text-uppercase text-center">Create Account</h3>

                                <form id="registerForm" autocomplete="off">

                                    <!-- Names -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="firstName">
                                                First Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="firstName"
                                                   name="firstName" required autocomplete="given-name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="lastName">
                                                Last Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="lastName"
                                                   name="lastName" required autocomplete="family-name">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="middleName">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName"
                                               name="middleName" autocomplete="additional-name">
                                    </div>

                                    <!-- Contact -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="email">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" id="email"
                                                   name="email" required autocomplete="email">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="contact">
                                                Contact Number <span class="text-danger">*</span>
                                            </label>
                                            <input type="tel" class="form-control" id="contact"
                                                   name="contact" required autocomplete="tel">
                                        </div>
                                    </div>

                                    <!-- Account -->
                                    <div class="mb-3">
                                        <label class="form-label" for="username">
                                            Username <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="username"
                                               name="username" required autocomplete="username">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="password">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" id="password"
                                                   name="password" minlength="8" required
                                                   autocomplete="new-password">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="confirmPassword">
                                                Confirm Password <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" id="confirmPassword"
                                                   name="confirmPassword" minlength="8" required
                                                   autocomplete="new-password">
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <!-- <div class="mb-3">
                                        <label class="form-label" for="street">
                                            Street <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="street"
                                               name="street" required autocomplete="street-address">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="barangay">
                                                Barangay <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="barangay"
                                                   name="barangay" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="city">
                                                City <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="city"
                                                   name="city" required autocomplete="address-level2">
                                        </div>
                                    </div> -->

                                    <button type="submit" id="registerButton"
                                            class="btn btn-register w-100 mt-2 border-0">
                                        Register
                                    </button>

                                    <p class="text-center mt-3 mb-0">
                                        Already have an account?
                                        <a href="/SoftEcoms/public/login.php">Login</a>
                                    </p>

                                </form>

                            </div>
                        </div>

                    </div>
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