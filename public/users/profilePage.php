
<?php
$pageClass = "profile-page";

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
?>

<div class="container">

    <div class="profile-card">

        <img
            id="previewImg"
            src="https://via.placeholder.com/120"
            alt="Profile"
            style="width:120px;height:120px;object-fit:cover;border-radius:50%;"
        >

        <h3 id="profileName">Loading profile...</h3>
        <p id="profileEmail"></p>

        <div style="margin-top:15px;">
            <label for="profilePictureInput">Profile Picture</label>

            <input
                type="file"
                id="profilePictureInput"
                accept="image/jpeg,image/png,image/webp"
                disabled
            >

            <small>JPG, PNG, or WEBP. Maximum size: 5 MB.</small>
        </div>

    </div>

    <div class="profile-form">

        <h2>Profile Settings</h2>

        <form id="profileForm">

            <div class="form-grid">

                <div>
                    <label>First Name</label>
                    <input type="text" id="firstName" maxlength="100" disabled required>
                </div>

                <div>
                    <label>Last Name</label>
                    <input type="text" id="lastName" maxlength="100" disabled required>
                </div>

                <div>
                    <label>Mobile</label>
                    <input type="text" id="contactNumber" maxlength="30" disabled required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" id="emailAddress" disabled readonly>
                </div>

                <div>
                    <label>Street</label>
                    <input type="text" id="street" maxlength="255" disabled required>
                </div>

                <div>
                    <label>Barangay</label>
                    <input type="text" id="barangay" maxlength="100" disabled required>
                </div>

                <div>
                    <label>City</label>
                    <input type="text" id="city" maxlength="100" disabled required>
                </div>

            </div>

            <div style="margin-top:15px;">

                <button
                    type="button"
                    id="toggleBtn"
                    class="save-btn"
                    style="color:black;"
                    onclick="toggleEdit()"
                >
                    Edit Profile
                </button>

                <button
                    type="button"
                    id="cancelBtn"
                    class="btn btn-secondary"
                    style="display:none;"
                    onclick="cancelEdit()"
                >
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SAVE MODAL -->

<div class="modal fade"
     id="saveModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Confirm Changes</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">
                Do you want to save the changes to your profile?
            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="confirmSaveBtn"
                    onclick="submitProfile()">
                    Yes, Save
                </button>

            </div>

        </div>

    </div>

</div>

<?php include('../admin/includes/footer.php'); ?>

<script>
const API_URL = "http://localhost:3000";
const DEFAULT_PROFILE_IMAGE = "https://via.placeholder.com/120";
const MAX_IMAGE_SIZE = 5 * 1024 * 1024;

let isEditing = false;
let originalProfile = {};
let originalProfileImage = DEFAULT_PROFILE_IMAGE;
let selectedProfileImage = null;
let saveModal;

document.addEventListener("DOMContentLoaded", async function () {

    saveModal = new bootstrap.Modal(
        document.getElementById("saveModal")
    );

    document
        .getElementById("profilePictureInput")
        .addEventListener("change", previewSelectedImage);

    await loadProfile();

});

// ==========================================
// LOAD PROFILE
// ==========================================

async function loadProfile() {

    try {

        const response = await fetch(API_URL + "/me", {
            method: "GET",
            credentials: "include",
            headers: {
                "Accept": "application/json"
            },
            cache: "no-store"
        });

        if (response.status === 401) {
            window.location.href = "/SoftEcoms/public/login.php";
            return;
        }

        if (!response.ok) {
            throw new Error("Unable to load customer profile.");
        }

        const data = await response.json();

        if (!data.user) {
            throw new Error("Customer information was not returned.");
        }

        const user = data.user;

        document.getElementById("profileName").textContent =
            `${user.firstName || ""} ${user.lastName || ""}`.trim();

        document.getElementById("profileEmail").textContent =
            user.emailAddress || "";

        document.getElementById("firstName").value =
            user.firstName || "";

        document.getElementById("lastName").value =
            user.lastName || "";

        document.getElementById("contactNumber").value =
            user.contactNumber || "";

        document.getElementById("emailAddress").value =
            user.emailAddress || "";

        document.getElementById("street").value =
            user.street || "";

        document.getElementById("barangay").value =
            user.barangay || "";

        document.getElementById("city").value =
            user.city || "";

        // The database column is named "profile".
        const profileImage = user.profileImageUrl || (
            user.profile
                ? "/SoftEcoms/public/assets/profile_img/" +
                  encodeURIComponent(user.profile)
                : DEFAULT_PROFILE_IMAGE
        );

        originalProfileImage = profileImage;
        document.getElementById("previewImg").src = profileImage;

        selectedProfileImage = null;
        document.getElementById("profilePictureInput").value = "";

        saveOriginalProfile();

    } catch (error) {

        console.error("Profile loading error:", error);
        alert(error.message);

    }

}

// ==========================================
// SAVE ORIGINAL VALUES
// ==========================================

function saveOriginalProfile() {

    originalProfile = {
        firstName: document.getElementById("firstName").value,
        lastName: document.getElementById("lastName").value,
        contactNumber: document.getElementById("contactNumber").value,
        street: document.getElementById("street").value,
        barangay: document.getElementById("barangay").value,
        city: document.getElementById("city").value
    };

}

// ==========================================
// PREVIEW SELECTED PROFILE IMAGE
// ==========================================

function previewSelectedImage(event) {

    const file = event.target.files[0];

    if (!file) {
        selectedProfileImage = null;
        return;
    }

    const allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    if (!allowedTypes.includes(file.type)) {
        alert("Only JPG, PNG, and WEBP images are allowed.");
        event.target.value = "";
        selectedProfileImage = null;
        return;
    }

    if (file.size > MAX_IMAGE_SIZE) {
        alert("The profile picture must be 5 MB or smaller.");
        event.target.value = "";
        selectedProfileImage = null;
        return;
    }

    selectedProfileImage = file;

    const reader = new FileReader();

    reader.onload = function (e) {
        document.getElementById("previewImg").src = e.target.result;
    };

    reader.onerror = function () {
        alert("Could not preview the selected image.");
    };

    reader.readAsDataURL(file);

}

// ==========================================
// ENABLE EDIT MODE
// ==========================================

function toggleEdit() {

    if (!isEditing) {

        saveOriginalProfile();

        const editableFields = [
            "firstName",
            "lastName",
            "contactNumber",
            "street",
            "barangay",
            "city"
        ];

        editableFields.forEach(id => {
            document.getElementById(id).disabled = false;
        });

        document.getElementById("profilePictureInput").disabled = false;

        document.getElementById("toggleBtn").textContent =
            "Save Profile";

        document.getElementById("cancelBtn").style.display =
            "inline-block";

        isEditing = true;

    } else {

        if (!document.getElementById("profileForm").reportValidity()) {
            return;
        }

        saveModal.show();

    }

}

// ==========================================
// CANCEL EDIT
// ==========================================

function cancelEdit() {

    Object.keys(originalProfile).forEach(id => {
        document.getElementById(id).value = originalProfile[id];
    });

    selectedProfileImage = null;

    document.getElementById("profilePictureInput").value = "";
    document.getElementById("previewImg").src = originalProfileImage;

    setViewMode();

}

// ==========================================
// VIEW MODE
// ==========================================

function setViewMode() {

    const editableFields = [
        "firstName",
        "lastName",
        "contactNumber",
        "street",
        "barangay",
        "city"
    ];

    editableFields.forEach(id => {
        document.getElementById(id).disabled = true;
    });

    document.getElementById("profilePictureInput").disabled = true;

    document.getElementById("toggleBtn").textContent =
        "Edit Profile";

    document.getElementById("cancelBtn").style.display =
        "none";

    isEditing = false;

}

// ==========================================
// SAVE PROFILE
// ==========================================

async function submitProfile() {

    const button = document.getElementById("confirmSaveBtn");

    button.disabled = true;
    button.textContent = "Saving...";

    try {

        let profileImage = null;

        // Convert the selected image to base64 for the API.
        if (selectedProfileImage) {

            profileImage = await new Promise((resolve, reject) => {

                const reader = new FileReader();

                reader.onload = () => resolve(reader.result);
                reader.onerror = () => reject(
                    new Error("Could not read the selected image.")
                );

                reader.readAsDataURL(selectedProfileImage);

            });

        }

        const payload = {

            firstName:
                document.getElementById("firstName").value.trim(),

            lastName:
                document.getElementById("lastName").value.trim(),

            emailAddress:
                document.getElementById("emailAddress").value.trim(),

            contactNumber:
                document.getElementById("contactNumber").value.trim(),

            street:
                document.getElementById("street").value.trim(),

            barangay:
                document.getElementById("barangay").value.trim(),

            city:
                document.getElementById("city").value.trim()

        };

        // Only send profileImage when a new picture was selected.
        if (profileImage) {
            payload.profileImage = profileImage;
        }

        const response = await fetch(API_URL + "/update-profile", {
            method: "PUT",
            credentials: "include",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            throw new Error(data.message || "Could not save profile.");
        }

        saveModal.hide();

        await loadProfile();

        setViewMode();

        alert("Profile updated successfully!");

    } catch (error) {

        console.error("Profile update error:", error);
        alert(error.message);

    } finally {

        button.disabled = false;
        button.textContent = "Yes, Save";

    }

}
</script>
