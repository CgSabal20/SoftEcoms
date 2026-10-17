class User {
  constructor(db) {
    this.db = db;
  }

  // Find a user by email for login.
  async findByEmail(email) {
    const [users] = await this.db.execute(
      `SELECT
        id,
        uuid,
        firstName,
        lastName,
        middleName,
        username,
        emailAddress,
        password,
        role,
        accountStatus
       FROM users
       WHERE emailAddress = ?
       LIMIT 1`,
      [email.trim()],
    );

    return users[0] || null;
  }

  // Check whether an email or username already exists.
  async findByEmailOrUsername(email, username) {
    const [users] = await this.db.execute(
      `SELECT id
       FROM users
       WHERE emailAddress = ? OR username = ?
       LIMIT 1`,
      [email.trim(), username.trim()],
    );

    return users[0] || null;
  }

  // Create a new account as unverified.
  async create(userData) {
    const {
      uuid,
      firstName,
      lastName,
      middleName,
      email,
      contact,
      username,
      hashedPassword,
      street,
      barangay,
      city,
      role,
    } = userData;

    const [result] = await this.db.execute(
      `INSERT INTO users (
        uuid,
        firstName,
        lastName,
        middleName,
        emailAddress,
        contactNumber,
        username,
        password,
        street,
        barangay,
        city,
        role,
        accountStatus
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [
        uuid,
        firstName,
        lastName,
        middleName || null,
        email,
        contact || null,
        username,
        hashedPassword,
        street || null,
        barangay || null,
        city || null,
        role || "user",
        "unverified",
      ],
    );

    return result.insertId;
  }

  // Save the SHA-256 verification token hash and expiration.
  async saveVerificationToken(userId, tokenHash, expiresAt) {
    const [result] = await this.db.execute(
      `UPDATE users
       SET emailVerificationToken = ?,
           emailVerificationExpires = ?
       WHERE id = ?
         AND accountStatus = 'unverified'`,
      [tokenHash, expiresAt, userId],
    );

    return result.affectedRows === 1;
  }

  // Find an account with a valid, unexpired verification token.
  async findByVerificationToken(tokenHash) {
    const [users] = await this.db.execute(
      `SELECT id, emailAddress, accountStatus
       FROM users
       WHERE emailVerificationToken = ?
         AND emailVerificationExpires > NOW()
         AND accountStatus = 'unverified'
       LIMIT 1`,
      [tokenHash],
    );

    return users[0] || null;
  }

  // Activate the account and invalidate its verification token.
  async verifyEmail(userId) {
    const [result] = await this.db.execute(
      `UPDATE users
       SET accountStatus = 'active',
           emailVerificationToken = NULL,
           emailVerificationExpires = NULL
       WHERE id = ?
         AND accountStatus = 'unverified'
         AND emailVerificationExpires > NOW()`,
      [userId],
    );

    return result.affectedRows === 1;
  }

  // Upgrade an existing plaintext password to a bcrypt hash.
  // This is only used when login detects a legacy plaintext password.
  async updatePasswordIfMatches(id, oldPassword, newHash) {
    const [result] = await this.db.execute(
      `UPDATE users
       SET password = ?
       WHERE id = ?
         AND password = ?`,
      [newHash, id, oldPassword],
    );

    return result.affectedRows === 1;
  }
}

module.exports = User;
