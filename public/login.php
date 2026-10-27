<?php
session_start();

$pageClass = "index-page";

include(__DIR__ . '/includes/header.php');
include(__DIR__ . '/includes/topbar.php');
?>

<section class="loginOverlay">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="/SoftEcoms/public/assets/img/svg/logo.svg"
                                        style="width: 100px;" alt="Sweetclaire">
                                    <h4 class="greet_login mt-1 mb-3 pb-1">Welcome to SweetClaire!</h4>
                                </div>




                                <form id="loginForm">
                                    <p>Please login to your account</p>

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" class="form-control"
                                            placeholder="Email Address">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" id="password" class="form-control"
                                            placeholder="Password">
                                    </div>

                                    <div class="d-grid pt-1 mb-3 pb-1">
                                        <button class="btn btn-primary gradient-custom-3 mb-3" type="submit">Login</button>
                                        <a class="text-muted text-center" href="forgetpassword.php">Forgot password?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Don't have an account?</p>
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button>
                                    </div>



                                </form>


                            </div>
                        </div>

                        <!-- The right side sa login  -->
                        <!-- <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div> -->

                        <!-- The right side sa login -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="/SoftEcoms/public/assets/img/Top_Viewclair.jpg"
                                alt=""
                                class="login-side-img">
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const loginForm = document.getElementById("loginForm");
    const loginButton = document.getElementById("loginButton");

    loginForm.addEventListener("submit", async function(event) {
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
                body: JSON.stringify({
                    email,
                    password
                })
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