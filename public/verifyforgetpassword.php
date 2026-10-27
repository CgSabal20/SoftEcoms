<?php
session_start();

$pageClass = "login-page";

include('admin/includes/header.php');
include('admin/includes/topbar.php');
?>

<section class="login d-flex align-items-center" style="height: 90vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 m-auto">
                
               
                <form id="forgetpasswordForm" autocomplete="on" class="bg-white p-5 rounded-4 shadow text-center">
                    
                    
                    <h3 class="mb-4 fw-bold">Reset Password</h3>
                

                    <label for="password" class="d-block text-start mb-1">
                        New Password<span class="text-danger">*</span>
                    </label>
                        <input
                            type="password"
                            class="form-control mb-3"
                            id="password"
                            name="password"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >

                        <label for="password" class="d-block text-start mb-1">
                            Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <input
                            type="password"
                            class="form-control mb-3"
                            id="confirmPassword"
                            name="confirmPassword"
                            minlength="8"
                            required
                            autocomplete="new-password"
                        >

                  

                    <!-- Using Bootstrap classes for a green, fully rounded pill button -->
                    <button
                        type="submit"
                        class="btn btn-success w-100 mb-3 rounded-pill py-2 fw-bold"
                        id="loginButton"
                        style="background-color: #00d254; border: none;"
                    >
                        Reset Password
                    </button>

                    <p class="mb-0">
                        
                        <a href="register" class="text-decoration-none">Back to Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>