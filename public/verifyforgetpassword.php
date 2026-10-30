<<<<<<< HEAD
<?php
session_start();

$pageClass = "index-page";

include('includes/header.php');
include('includes/topbar.php');
?>

<section class="resetOverlay d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 m-auto">

                <form id="forgetpasswordForm" autocomplete="on" class="reset-card bg-white p-5 rounded-4 shadow">

                    <h3 class="reset-title mb-3 fw-bold text-center">New Password</h3>

                    <p class="small text-start mb-3">
                        To make sure your account is secure, Don't use the same old password.
                    </p>

                    <label for="password" class="d-block text-start small mb-1">
                        New Password<span class="text-danger">*</span>
                    </label>
                    <input
                        type="password"
                        class="form-control reset-input mb-3"
                        id="password"
                        name="password"
                        minlength="8"
                        required
                        autocomplete="new-password"
                    >

                    <label for="confirmPassword" class="d-block text-start small mb-1">
                        Confirm New Password<span class="text-danger">*</span>
                    </label>
                    <input
                        type="password"
                        class="form-control reset-input mb-3"
                        id="confirmPassword"
                        name="confirmPassword"
                        minlength="8"
                        required
                        autocomplete="new-password"
                    >

                    <button
                        type="submit"
                        class="btn reset-btn w-100 mb-3 rounded-pill py-2 fw-bold text-uppercase"
                        id="loginButton"
                    >
                        Change Password
                    </button>

                    <p class="mb-0 small text-center">
                        <a href="register" class="reset-link text-decoration-none">Back to Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</section>
=======

<?php
// public/verifyforgetpassword.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Sweet!</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #fff8f0;
            color: #333;
        }

        .reset-card {
            width: 100%;
            max-width: 430px;
            padding: 35px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.09);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #8b4513;
            text-align: center;
        }

        .description {
            margin-bottom: 25px;
            color: #666;
            line-height: 1.6;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 16px;
        }

        input:focus {
            outline: 2px solid #d9a47e;
            border-color: #8b4513;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #8b4513;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #71370e;
        }

        button:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #8b4513;
            text-align: center;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <main class="reset-card">
        <h1>Reset Your Password</h1>

        <p class="description">
            Choose a new password for your Sweet! account.
        </p>

        <form id="resetPasswordForm">
            <label for="password">New Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your new password"
                minlength="8"
                maxlength="72"
                autocomplete="new-password"
                required
            >

            <label for="confirmPassword">Confirm New Password</label>

            <input
                type="password"
                id="confirmPassword"
                name="confirmPassword"
                placeholder="Confirm your new password"
                minlength="8"
                maxlength="72"
                autocomplete="new-password"
                required
            >

            <button type="submit" id="resetPasswordButton">
                Reset Password
            </button>
        </form>

        <a class="back-link" href="login.php">
            Back to Login
        </a>
    </main>
>>>>>>> cg's--progress

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("resetPasswordForm");
            const passwordInput = document.getElementById("password");
            const confirmInput = document.getElementById("confirmPassword");
            const button = document.getElementById("resetPasswordButton");

            const token = new URLSearchParams(
                window.location.search
            ).get("token") || "";

            if (!/^[a-f0-9]{64}$/i.test(token)) {
                form.querySelectorAll("input, button").forEach((element) => {
                    element.disabled = true;
                });

                Swal.fire({
                    title: "Invalid Reset Link",
                    text: "This link is invalid or missing. Please request a new password-reset email.",
                    icon: "error",
                    confirmButtonColor: "#8b4513"
                });

                return;
            }

            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;

                if (password.length < 8 || password.length > 72) {
                    await Swal.fire({
                        title: "Invalid Password",
                        text: "Your password must be between 8 and 72 characters.",
                        icon: "warning",
                        confirmButtonColor: "#8b4513"
                    });
                    return;
                }

                if (password !== confirmPassword) {
                    await Swal.fire({
                        title: "Passwords Do Not Match",
                        text: "Please make sure both password fields match.",
                        icon: "warning",
                        confirmButtonColor: "#8b4513"
                    });
                    return;
                }

                const originalText = button.textContent;
                button.disabled = true;
                button.textContent = "Resetting...";

                try {
                    const response = await fetch(
                        "http://localhost:3000/reset-password",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                token,
                                password,
                                confirmPassword
                            })
                        }
                    );

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(
                            data.message || "Unable to reset your password."
                        );
                    }

                    await Swal.fire({
                        title: "Password Reset Successful",
                        text: data.message,
                        icon: "success",
                        confirmButtonColor: "#8b4513"
                    });

                    window.location.href =
                        data.redirect || "/SoftEcoms/public/login.php";

                } catch (error) {
                    console.error("Password-reset error:", error);

                    await Swal.fire({
                        title: "Reset Failed",
                        text: error.message || "Unable to reset your password. Please try again.",
                        icon: "error",
                        confirmButtonColor: "#8b4513"
                    });
                } finally {
                    button.disabled = false;
                    button.textContent = originalText;
                }
            });
        });
    </script>

</body>
</html>
