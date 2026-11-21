<?php
include(APP_ROOT.'/views/include/header.php');
?>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

        <div class="card login-card border-0 shadow">

            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <i class="bi bi-person-circle login-icon"></i>
                    <h2 class="fw-bold mt-3">Login</h2>
                    <p class="text-secondary">Welcome back! Please login.</p>
                </div>

                <form method="post" action="/login">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">
                            Email
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
                                placeholder="Email address"
                                autocomplete="email"
                                required
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">
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
                                placeholder="Password"
                                minlength="6"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword"
                                aria-label="Show password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                value="1"
                                id="remember"
                            >

                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <a href="/forgot-password" class="small text-decoration-none">
                            Forgot password?
                        </a>

                    </div>

                    <!-- Result -->
                    <div class="mb-3" id="result" aria-live="polite"></div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between gap-2">

                        <button
                            class="btn btn-dark flex-fill"
                            type="submit"
                            id="loginBtn"
                        >
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </button>

                        <a href="/register" class="btn btn-outline-dark flex-fill">
                            <i class="bi bi-person-plus me-1"></i>
                            Register
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</div>
<?php
include(APP_ROOT.'/views/include/footer.php');
?>
