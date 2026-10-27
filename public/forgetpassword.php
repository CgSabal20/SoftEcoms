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
                    
                    
                    <h3 class="mb-4 fw-bold">Forget your Password</h3>
                    <p>Please enter the email address you'd like your password reset information sent to</p>

                    <input
                        type="email"
                        class="form-control mb-3 py-2"
                        placeholder="Enter Email"
                        name="email"
                        id="email"
                        autocomplete="username"
                        required
                    >

                  

                    <!-- Using Bootstrap classes for a green, fully rounded pill button -->
                    <button
                        type="submit"
                        class="btn btn-success w-100 mb-3 rounded-pill py-2 fw-bold"
                        id="loginButton"
                        style="background-color: #00d254; border: none;"
                    >
                        Request Reset
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