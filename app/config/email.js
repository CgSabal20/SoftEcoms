const nodemailer = require("nodemailer");

if (!process.env.SMTP_USER || !process.env.SMTP_APP_PASSWORD) {
  throw new Error("Missing SMTP_USER or SMTP_APP_PASSWORD in .env");
}

const transporter = nodemailer.createTransport({
  service: "gmail",
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_APP_PASSWORD.replace(/\s+/g, ""),
  },
});

async function verifyEmailTransport() {
  try {
    await transporter.verify();
    console.log("Gmail SMTP connection successful!");
    return true;
  } catch (error) {
    console.error("Gmail SMTP connection failed:", error.message);
    throw error;
  }
}

// ==========================================
// EMAIL VERIFICATION
// ==========================================
async function sendVerificationEmail(email, verificationUrl) {
  if (!email || !verificationUrl) {
    throw new Error("Recipient email and verification URL are required.");
  }

  const safeEmail = String(email).trim();

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(safeEmail)) {
    throw new Error("Invalid recipient email address.");
  }

  const appUrl = process.env.APP_URL || "http://localhost:3000";
  const allowedOrigin = new URL(appUrl).origin;
  const parsedVerificationUrl = new URL(verificationUrl);

  if (
    parsedVerificationUrl.origin !== allowedOrigin ||
    parsedVerificationUrl.pathname !== "/verify-email"
  ) {
    throw new Error("Invalid verification URL.");
  }

  const mailOptions = {
    from: {
      name: "Sweet!",
      address: process.env.SMTP_USER,
    },
    to: safeEmail,
    subject: "Verify your Sweet! account",
    text: [
      "Welcome to Sweet!",
      "",
      "Thank you for registering.",
      "Please verify your email address using this link:",
      verificationUrl,
      "",
      "This link expires in 30 minutes.",
      "If you did not register, you can ignore this email.",
    ].join("\n"),
    html: `
      <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:24px;color:#333">
        <h1 style="color:#8b4513">Welcome to Sweet!</h1>
        <p>Thank you for registering. Please verify your email address to activate your account.</p>
        <p style="margin:28px 0">
          <a href="${verificationUrl}"
             style="background:#8b4513;color:#fff;padding:12px 22px;text-decoration:none;border-radius:6px;display:inline-block">
            Verify my email
          </a>
        </p>
        <p>This link expires in 30 minutes. If you did not register, you can ignore this email.</p>
      </div>
    `,
  };

  const info = await transporter.sendMail(mailOptions);

  console.log("Verification email sent:", info.messageId);

  return info;
}

// ==========================================
// PASSWORD RESET EMAIL
// ==========================================
async function sendPasswordResetEmail(email, rawToken) {
  if (!email || !rawToken) {
    throw new Error("Recipient email and reset token are required.");
  }

  const safeEmail = String(email).trim();

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(safeEmail)) {
    throw new Error("Invalid recipient email address.");
  }

  const resetPageUrl =
    process.env.RESET_PASSWORD_URL ||
    "http://localhost/SoftEcoms/public/verifyforgetpassword.php";

  const parsedUrl = new URL(resetPageUrl);

  if (!["http:", "https:"].includes(parsedUrl.protocol)) {
    throw new Error("Invalid password reset URL.");
  }

  // Add the raw token to the PHP reset page URL.
  parsedUrl.searchParams.set("token", rawToken);

  const resetUrl = parsedUrl.toString();

  const mailOptions = {
    from: {
      name: "Sweet!",
      address: process.env.SMTP_USER,
    },
    to: safeEmail,
    subject: "Reset your Sweet! password",
    text: [
      "Hello,",
      "",
      "We received a request to reset your Sweet! account password.",
      "Open the link below to choose a new password:",
      resetUrl,
      "",
      "This link expires in 30 minutes and can only be used once.",
      "If you did not request a password reset, you can ignore this email.",
    ].join("\n"),
    html: `
      <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:24px;color:#333">
        <h1 style="color:#8b4513">Reset your password</h1>
        <p>We received a request to reset your Sweet! account password.</p>
        <p style="margin:28px 0">
          <a href="${resetUrl}"
             style="background:#8b4513;color:#fff;padding:12px 22px;text-decoration:none;border-radius:6px;display:inline-block">
            Reset My Password
          </a>
        </p>
        <p>This link expires in 30 minutes and can only be used once.</p>
        <p>If you did not request a password reset, you can ignore this email.</p>
      </div>
    `,
  };

  const info = await transporter.sendMail(mailOptions);

  console.log("Password reset email sent:", info.messageId);

  return info;
}

module.exports = {
  transporter,
  verifyEmailTransport,
  sendVerificationEmail,
  sendPasswordResetEmail,
};
