require("dotenv").config();

const express = require("express");
const mysql = require("mysql2/promise");
const session = require("express-session");
const cors = require("cors");

const Authentication = require("./app/controllers/Authentication");

const app = express();
const PORT = process.env.PORT || 3000;

// ==============================
// CORS CONFIGURATION
// ==============================
app.use(
  cors({
    origin: process.env.FRONTEND_ORIGIN || "http://localhost",
    credentials: true,
  }),
);

// ==============================
// MIDDLEWARE
// ==============================
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// ==============================
// SESSION CONFIGURATION
// ==============================
if (!process.env.SESSION_SECRET) {
  throw new Error("SESSION_SECRET is missing from .env");
}

app.use(
  session({
    name: "connect.sid",
    secret: process.env.SESSION_SECRET,
    resave: false,
    saveUninitialized: false,
    cookie: {
      httpOnly: true,
      sameSite: "lax",
      secure: false, // Local HTTP development only
      maxAge: 60 * 60 * 1000,
    },
  }),
);

// ==============================
// START SERVER
// ==============================
async function startServer() {
  const db = mysql.createPool({
    host: process.env.DB_HOST || "localhost",
    user: process.env.DB_USER || "root",
    password: process.env.DB_PASSWORD || "",
    database: process.env.DB_NAME,
    waitForConnections: true,
    connectionLimit: 10,
  });

  // Verify database connection
  await db.query("SELECT 1");
  console.log("MySQL connected successfully!");

  // Initialize authentication controller
  const auth = new Authentication(db);

  // ==============================
  // HOME / HEALTH CHECK
  // ==============================
  app.get("/", (req, res) => {
    res.send("Sweet! authentication server is running.");
  });

  // ==============================
  // REGISTER
  // ==============================
  app.post("/register", auth.register);

  // ==============================
  // LOGIN
  // ==============================
  app.post("/login", auth.login);

  // ==============================
  // EMAIL VERIFICATION
  // ==============================
  app.get("/verify-email", auth.verifyEmail);

  // ==============================
  // CURRENT LOGGED-IN USER
  // ==============================
  app.get("/me", auth.me);

  // ==============================
  // LOGOUT
  // ==============================
  app.post("/logout", auth.logout);

  // ==============================
  // START LISTENING
  // ==============================
  app.listen(PORT, () => {
    console.log(`Server running at http://localhost:${PORT}`);
  });
}

startServer().catch((error) => {
  console.error("Server startup failed:", error);
  process.exit(1);
});
