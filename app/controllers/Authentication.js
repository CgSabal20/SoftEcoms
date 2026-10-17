const bcrypt = require("bcrypt");
const crypto = require("crypto");

const User = require("../models/User");
const { sendVerificationEmail } = require("../config/email");

class Authentication {
  constructor(db) {
    this.db = db;
    this.userModel = new User(db);
  }

  // =========================================
  // REGISTER
  // =========================================
  register = async (req, res) => {
    try {
      const {
        firstName,
        lastName,
        middleName,
        email,
        contact,
        username,
        password,
        confirmPassword,
        street,
        barangay,
        city,
      } = req.body;

      const cleanFirstName = String(firstName || "").trim();
      const cleanLastName = String(lastName || "").trim();
      const cleanMiddleName = String(middleName || "").trim();
      const cleanEmail = String(email || "").trim();
      const cleanContact = String(contact || "").trim();
      const cleanUsername = String(username || "").trim();
      const cleanStreet = String(street || "").trim();
      const cleanBarangay = String(barangay || "").trim();
      const cleanCity = String(city || "").trim();

      // Validate required fields
      if (
        !cleanFirstName ||
        !cleanLastName ||
        !cleanEmail ||
        !cleanUsername ||
        !password ||
        !confirmPassword
      ) {
        return res.status(400).json({
          message: "Please fill in all required fields.",
        });
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(cleanEmail)) {
        return res.status(400).json({
          message: "Please enter a valid email address.",
        });
      }

      if (password !== confirmPassword) {
        return res.status(400).json({
          message: "Passwords do not match.",
        });
      }

      if (typeof password !== "string" || password.length < 8) {
        return res.status(400).json({
          message: "Password must contain at least 8 characters.",
        });
      }

      // Check for duplicate email or username
      const existingUser = await this.userModel.findByEmailOrUsername(
        cleanEmail,
        cleanUsername,
      );

      if (existingUser) {
        return res.status(409).json({
          message: "Email address or username already exists.",
        });
      }

      // Hash the password
      const hashedPassword = await bcrypt.hash(password, 12);
      const uuid = crypto.randomUUID();

      // Create account as unverified
      const userId = await this.userModel.create({
        uuid,
        firstName: cleanFirstName,
        lastName: cleanLastName,
        middleName: cleanMiddleName,
        email: cleanEmail,
        contact: cleanContact,
        username: cleanUsername,
        hashedPassword,
        street: cleanStreet,
        barangay: cleanBarangay,
        city: cleanCity,
        role: "customer",
      });

      // Generate a secure verification token
      const rawToken = crypto.randomBytes(32).toString("hex");

      // Store only the SHA-256 hash in the database
      const tokenHash = crypto
        .createHash("sha256")
        .update(rawToken)
        .digest("hex");

      // Token expires in 30 minutes
      const expiresAt = new Date(Date.now() + 30 * 60 * 1000);

      // Save token before sending the email
      const tokenSaved = await this.userModel.saveVerificationToken(
        userId,
        tokenHash,
        expiresAt,
      );

      if (!tokenSaved) {
        console.error("Failed to save verification token for user:", userId);

        return res.status(500).json({
          message:
            "Your account was created, but verification setup failed. Please contact support.",
        });
      }

      // Build the verification link
      const appUrl = (process.env.APP_URL || "http://localhost:3000").replace(
        /\/+$/,
        "",
      );

      const verificationUrl = `${appUrl}/verify-email?token=${rawToken}`;

      // Send the verification email
      try {
        await sendVerificationEmail(cleanEmail, verificationUrl);

        console.log("Verification email sent to:", cleanEmail);
      } catch (emailError) {
        console.error("Verification email failed:", emailError.message);

        return res.status(502).json({
          message:
            "Your account was created, but the verification email could not be sent. Please contact support to resend it.",
        });
      }

      // IMPORTANT: redirect is a string, not HTML.
      return res.status(201).json({
        message:
          "Registration successful! Check your email and click the verification link to activate your account.",
        redirect: "/SoftEcoms/public/login.php",
      });
    } catch (error) {
      console.error("Registration error:", error);

      if (error.code === "ER_DUP_ENTRY") {
        return res.status(409).json({
          message: "Email address or username already exists.",
        });
      }

      return res.status(500).json({
        message: "Registration failed due to a server error.",
      });
    }
  };

  // =========================================
  // LOGIN
  // Only verified, active accounts may log in.
  // =========================================
  login = async (req, res) => {
    try {
      const email = String(req.body.email || "").trim();
      const password = req.body.password;

      if (!email || !password) {
        return res.status(400).json({
          message: "Please enter your email and password.",
        });
      }

      const user = await this.userModel.findByEmail(email);

      if (!user) {
        return res.status(401).json({
          message: "Invalid email or password.",
        });
      }

      let passwordMatches = false;

      // Support bcrypt hashes, including PHP $2y$ hashes.
      if (
        typeof user.password === "string" &&
        /^\$2[aby]\$/.test(user.password)
      ) {
        const compatibleHash = user.password.replace(/^\$2y\$/, "$2b$");

        passwordMatches = await bcrypt.compare(password, compatibleHash);
      } else if (typeof user.password === "string") {
        // Temporary compatibility for legacy plaintext passwords.
        // Remove after all existing passwords have been migrated.
        passwordMatches = password === user.password;

        if (passwordMatches) {
          const upgradedHash = await bcrypt.hash(password, 12);

          await this.userModel.updatePasswordIfMatches(
            user.id,
            user.password,
            upgradedHash,
          );
        }
      }

      if (!passwordMatches) {
        return res.status(401).json({
          message: "Invalid email or password.",
        });
      }

      // Block unverified and inactive accounts.
      if (user.accountStatus !== "active") {
        if (user.accountStatus === "unverified") {
          return res.status(403).json({
            message: "Please verify your email before logging in.",
          });
        }

        return res.status(403).json({
          message: "Your account is not active. Please contact support.",
        });
      }

      const allowedRoles = ["admin", "user", "customer"];

      if (!allowedRoles.includes(user.role)) {
        return res.status(403).json({
          message: "Your account role is not authorized.",
        });
      }

      const fullName = [user.firstName, user.middleName, user.lastName]
        .filter(Boolean)
        .join(" ");

      // Regenerate session to reduce session fixation risk.
      req.session.regenerate((sessionError) => {
        if (sessionError) {
          console.error("Session regeneration error:", sessionError);

          return res.status(500).json({
            message: "Could not create your login session.",
          });
        }

        req.session.user_id = user.id;
        req.session.uuid = user.uuid;
        req.session.userRole = user.role;

        req.session.authUser = {
          user_id: user.id,
          uuid: user.uuid,
          fullName,
          username: user.username,
          email: user.emailAddress,
        };

        req.session.save((saveError) => {
          if (saveError) {
            console.error("Session save error:", saveError);

            return res.status(500).json({
              message: "Could not save your login session.",
            });
          }

          const redirect =
            user.role === "admin"
              ? "/SoftEcoms/public/admin/index.php"
              : "/SoftEcoms/public/index.php";

          return res.status(200).json({
            message: "Login successful!",
            redirect,
            user: req.session.authUser,
            role: user.role,
          });
        });
      });
    } catch (error) {
      console.error("Login error:", error);

      return res.status(500).json({
        message: "Login failed due to a server error.",
      });
    }
  };

  // =========================================
  // VERIFY EMAIL
  // GET /verify-email?token=...
  // =========================================
  verifyEmail = async (req, res) => {
    try {
      const rawToken = String(req.query.token || "");

      if (!/^[a-f0-9]{64}$/i.test(rawToken)) {
        return res.status(400).send(`
          <!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <title>Invalid Link - Sweet!</title>
          </head>
          <body style="font-family:Arial,sans-serif;text-align:center;padding:40px">
            <h1>Invalid verification link</h1>
            <p>Please check the link in your email.</p>
          </body>
          </html>
        `);
      }

      const tokenHash = crypto
        .createHash("sha256")
        .update(rawToken)
        .digest("hex");

      const user = await this.userModel.findByVerificationToken(tokenHash);

      if (!user) {
        return res.status(400).send(`
          <!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <title>Link Expired - Sweet!</title>
          </head>
          <body style="font-family:Arial,sans-serif;text-align:center;padding:40px">
            <h1>Verification link invalid or expired</h1>
            <p>Please contact support for assistance.</p>
          </body>
          </html>
        `);
      }

      const verified = await this.userModel.verifyEmail(user.id);

      if (!verified) {
        return res.status(400).send(`
          <!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <title>Verification Failed - Sweet!</title>
          </head>
          <body style="font-family:Arial,sans-serif;text-align:center;padding:40px">
            <h1>Verification could not be completed</h1>
            <p>The link may have expired. Please contact support.</p>
          </body>
          </html>
        `);
      }

      // This page is served by Node.js.
      // The login link below opens the PHP page through Apache.
      return res.status(200).send(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>Email Verified - Sweet!</title>
        </head>
        <body style="font-family:Arial,sans-serif;text-align:center;padding:40px;color:#333">
          <h1 style="color:#8b4513">Email verified successfully!</h1>
          <p>Your Sweet! account is now active.</p>
          <p>You can now log in to your account.</p>
          <a href="http://localhost/SoftEcoms/public/login.php"
             style="display:inline-block;background:#8b4513;color:white;padding:12px 22px;text-decoration:none;border-radius:6px">
            Go to Login
          </a>
        </body>
        </html>
      `);
    } catch (error) {
      console.error("Email verification error:", error);

      return res
        .status(500)
        .send(
          "An error occurred while verifying your email. Please try again later.",
        );
    }
  };

  // =========================================
  // CURRENT LOGGED-IN USER
  // GET /me
  // =========================================
  me = async (req, res) => {
    try {
      if (!req.session || !req.session.authUser) {
        return res.status(401).json({
          message: "You are not logged in.",
        });
      }

      return res.status(200).json({
        user: req.session.authUser,
        role: req.session.userRole,
      });
    } catch (error) {
      console.error("Session lookup error:", error);

      return res.status(500).json({
        message: "Could not retrieve your session.",
      });
    }
  };

  // =========================================
  // LOGOUT
  // POST /logout
  // =========================================
  logout = (req, res) => {
    if (!req.session) {
      res.clearCookie("connect.sid");

      return res.status(200).json({
        message: "Logged out successfully.",
      });
    }

    req.session.destroy((error) => {
      if (error) {
        console.error("Logout error:", error);

        return res.status(500).json({
          message: "Could not log out.",
        });
      }

      res.clearCookie("connect.sid", {
        httpOnly: true,
        sameSite: "lax",
        secure: false,
      });

      return res.status(200).json({
        message: "Logged out successfully.",
      });
    });
  };
}

module.exports = Authentication;
