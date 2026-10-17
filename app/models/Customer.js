const User = require("./User");

class Customer extends User {
  constructor(db) {
    super(db);
  }

  async manageProfile(userId) {
    const [rows] = await this.db.execute(
      `SELECT id, uuid, firstName, lastName, middleName,
                    emailAddress, contactNumber, username,
                    street, barangay, city, role
             FROM users
             WHERE id = ?
               AND role IN ('user', 'customer')
             LIMIT 1`,
      [userId],
    );

    return rows[0] || null;
  }

  // Update a customer's profile.
  async editProfile(userId, profile) {
    const {
      firstName,
      lastName,
      middleName,
      email,
      contact,
      username,
      street,
      barangay,
      city,
    } = profile;

    if (
      !firstName?.trim() ||
      !lastName?.trim() ||
      !email?.trim() ||
      !username?.trim()
    ) {
      throw new Error(
        "First name, last name, email, and username are required.",
      );
    }

    const [duplicates] = await this.db.execute(
      `SELECT id
             FROM users
             WHERE (emailAddress = ? OR username = ?)
               AND id <> ?
             LIMIT 1`,
      [email.trim(), username.trim(), userId],
    );

    if (duplicates.length > 0) {
      throw new Error("Email or username is already in use.");
    }

    const [result] = await this.db.execute(
      `UPDATE users
             SET firstName = ?,
                 lastName = ?,
                 middleName = ?,
                 emailAddress = ?,
                 contactNumber = ?,
                 username = ?,
                 street = ?,
                 barangay = ?,
                 city = ?
             WHERE id = ?
               AND role IN ('user', 'customer')`,
      [
        firstName.trim(),
        lastName.trim(),
        middleName?.trim() || "",
        email.trim(),
        contact?.trim() || "",
        username.trim(),
        street?.trim() || "",
        barangay?.trim() || "",
        city?.trim() || "",
        userId,
      ],
    );

    return result.affectedRows > 0;
  }
}

module.exports = Customer;
