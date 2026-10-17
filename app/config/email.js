const nodemailer = require("nodemailer");

// Make sure the required Gmail settings exist in .env
if (!process.env.SMTP_USER || !process.env.SMTP_APP_PASSWORD) {
  throw new Error("Missing SMTP_USER or SMTP_APP_PASSWORD in .env");
}

// Configure Gmail SMTP
const transporter = nodemailer.createTransport({
  service: "gmail",
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_APP_PASSWORD.replace(/\s+/g, ""),
  },
});

// Verify the Gmail SMTP connection
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

// Send the account verification email
async function sendVerificationEmail(email, verificationUrl) {
  if (!email || !verificationUrl) {
    throw new Error("Recipient email and verification URL are required.");
  }

  const safeEmail = String(email).trim();

  // Validate the recipient email address
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(safeEmail)) {
    throw new Error("Invalid recipient email address.");
  }

  // Only allow verification links from the configured application URL
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

module.exports = {
  transporter,
  verifyEmailTransport,
  sendVerificationEmail,
};
