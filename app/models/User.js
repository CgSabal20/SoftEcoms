class User {
  constructor(db) {
    this.db = db;
  }

  async findByEmail(email) {
    const [users] = await this.db.execute(
      `SELECT id, uuid, firstName, lastName, middleName, username,
              emailAddress, password, role, accountStatus,
              contactNumber, street, barangay, city
       FROM users
       WHERE emailAddress = ?
       LIMIT 1`,
      [email.trim()],
    );

    return users[0] || null;
  }

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
        uuid, firstName, lastName, middleName, emailAddress,
        contactNumber, username, password, street, barangay, city,
        role, accountStatus
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [
        uuid,
        firstName.trim(),
        lastName.trim(),
        middleName?.trim() || null,
        email.trim(),
        contact?.trim() || null,
        username.trim(),
        hashedPassword,
        street?.trim() || null,
        barangay?.trim() || null,
        city?.trim() || null,
        role || "customer",
        "unverified",
      ],
    );

    return result.insertId;
  }

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
