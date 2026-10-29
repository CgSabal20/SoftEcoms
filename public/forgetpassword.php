
<?php
// public/forgetpassword.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Sweet!</title>

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
        <h1>Forgot Password?</h1>

        <p class="description">
            Enter the email address associated with your Sweet! account.
            If your account is active, we will send you a password-reset link.
        </p>

        <form id="forgetpasswordForm">
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email address"
                maxlength="254"
                autocomplete="email"
                required
            >

            <button type="submit" id="loginButton">
                Send Reset Link
            </button>
        </form>

        <a class="back-link" href="login.php">
            Back to Login
        </a>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("forgetpasswordForm");
            const emailInput = document.getElementById("email");
            const button = document.getElementById("loginButton");

            form.addEventListener("submit", async (event) => {
                event.preventDefault();

                const email = emailInput.value.trim();

                if (!email) {
                    await Swal.fire({
                        title: "Email required",
                        text: "Please enter your email address.",
                        icon: "warning"
                    });
                    return;
                }

                const originalText = button.textContent;
                button.disabled = true;
                button.textContent = "Sending...";

                try {
                    const response = await fetch(
                        "http://localhost:3000/forgot-password",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ email })
                        }
                    );

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(
                            data.message || "Unable to process your request."
                        );
                    }

                    await Swal.fire({
                        title: "Request received",
                        text: data.message,
                        icon: "info",
                        confirmButtonColor: "#8b4513"
                    });
                } catch (error) {
                    console.error("Forgot-password error:", error);

                    await Swal.fire({
                        title: "Request failed",
                        text: "Unable to contact the authentication server. Make sure Node.js is running on port 3000.",
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
