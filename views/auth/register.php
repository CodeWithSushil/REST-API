<?php
include APP_ROOT.'/views/include/header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

        <div class="card login-card border-0 shadow">

            <div class="card-body p-4">

                <!-- Header -->
                <div class="text-center mb-4">

                    <i class="bi bi-person-plus-fill login-icon"></i>

                    <h2 class="fw-bold mt-3">Create Account</h2>

                    <p class="text-secondary">
                        Register to get started
                    </p>

                </div>

                <form method="post" action="/register">

                    <!-- Full Name -->
                    <div class="mb-3">

                        <label for="name" class="form-label fw-semibold">
                            Full Name
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>

                            <input
                                class="form-control"
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Enter your name"
                                autocomplete="name"
                                required
                            >

                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">

                        <label for="email" class="form-label fw-semibold">
                            Email Address
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input
                                class="form-control"
                                type="email"
                                name="email"
                                id="email"
                                placeholder="name@example.com"
                                autocomplete="email"
                                required
                            >

                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">

                        <label for="password" class="form-label fw-semibold">
                            Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                class="form-control"
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Create password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                data-toggle-password="password"
                                aria-label="Show password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>

                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">

                        <label for="confirm_password" class="form-label fw-semibold">
                            Confirm Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-shield-lock"></i>
                            </span>

                            <input
                                class="form-control"
                                type="password"
                                name="confirm_password"
                                id="confirm_password"
                                placeholder="Confirm password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                data-toggle-password="confirm_password"
                                aria-label="Show password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>

                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="form-check mb-3">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="terms"
                            value="1"
                            id="terms"
                            required
                        >

                        <label class="form-check-label small" for="terms">
                            I agree to the
                            <a href="/terms" class="text-decoration-none">
                                Terms & Conditions
                            </a>
                        </label>

                    </div>

                    <!-- Result -->
                    <div id="result" class="mb-3" aria-live="polite"></div>

                    <!-- Buttons -->
                    <div class="d-grid">

                        <button
                            class="btn btn-dark btn-lg"
                            type="submit"
                            id="registerBtn"
                        >
                            <i class="bi bi-person-plus me-2"></i>
                            Create Account
                        </button>

                    </div>

                </form>

                <!-- Footer -->
                <div class="text-center mt-4">

                    <p class="text-secondary small mb-0">
                        Already have an account?
                        <a href="/login" class="fw-semibold text-decoration-none">
                            Login here
                        </a>
                    </p>

                </div>

            </div>
        </div>

    </div>
</div>

</div>
<?php
include APP_ROOT.'/views/include/footer.php';
?>
