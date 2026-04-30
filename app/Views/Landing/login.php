<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <title>PWD | Login</title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('css/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Icons -->
    <link href="<?= base_url('bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- Alpine JS -->
    <script defer src="<?= base_url('js/alpinejs/dist/cdn.min.js') ?>"></script>
</head>

<body>
    <div x-data="loginApp()" class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card shadow border-0 p-4" style="width: 450px; border-radius: 1rem;">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1">Person Disability Affairs Office</h3>
                <p class="text-muted small">Management System Login</p>
            </div>

            <form @submit.prevent="login">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"
                            :class="errors.username ? 'border-danger' : ''">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text"
                            :class="errors.username ? 'is-invalid' : ''"
                            class="form-control bg-light border-start-0 ps-0"
                            x-model="form.username"
                            placeholder="Enter your username"
                            required>
                    </div>
                    <div x-show="errors.username" class="text-danger mt-1 fw-medium" style="font-size: 12px;">
                        <i class="bi bi-exclamation-circle me-1"></i> <span x-text="errors.username"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" :class="errors.password ? 'border-danger' : ''">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'"
                            :class="errors.password ? 'is-invalid' : ''"
                            class="form-control bg-light border-start-0 border-end-0 ps-0"
                            x-model="form.password"
                            placeholder="••••••••"
                            required>
                        <button type="button"
                            class="input-group-text bg-light border-start-0"
                            @click="showPassword = !showPassword">
                            <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                        </button>
                    </div>
                    <div x-show="errors.password" class="text-danger mt-1 fw-medium" style="font-size: 12px;">
                        <i class="bi bi-exclamation-circle me-1"></i> <span x-text="errors.password"></span>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary btn-lg shadow-sm py-2 fw-bold" type="submit" :disabled="loading">
                        <span x-show="!loading"><i class="bi bi-box-arrow-in-right me-2"></i> Login</span>
                        <span x-show="loading">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Logging in...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <script>
        // CSRF Token helper functions
        const csrfConfig = {
            getToken: () => document.querySelector('meta[name="csrf-token"]')?.content,
            getName: () => document.querySelector('meta[name="csrf-name"]')?.content,
            getHeader: () => document.querySelector('meta[name="csrf-header"]')?.content || 'X-CSRF-TOKEN'
        };

        // Improved csrfFetch function
        window.csrfFetch = async function(url, options = {}) {
            const token = csrfConfig.getToken();
            const tokenName = csrfConfig.getName();

            if (!token || !tokenName) {
                console.error('CSRF tokens not found');
                throw new Error('CSRF tokens not configured');
            }

            // Initialize headers
            options.headers = options.headers || {};

            // Set CSRF header (common practice for AJAX requests)
            options.headers['X-CSRF-TOKEN'] = token;
            options.headers['X-Requested-With'] = 'XMLHttpRequest';

            // Handle different request body types
            if (options.body instanceof FormData) {
                // For FormData, append the CSRF token as a field
                options.body.append(tokenName, token);
            } else if (options.body && typeof options.body === 'object') {
                // For JSON, add CSRF token to the body
                options.headers['Content-Type'] = 'application/json';
                const bodyObj = typeof options.body === 'object' ? {
                    ...options.body
                } : {};
                bodyObj[tokenName] = token;
                options.body = JSON.stringify(bodyObj);
            } else if (!options.body) {
                // If no body, create one with just the CSRF token
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify({
                    [tokenName]: token
                });
            }

            // Make the request
            const response = await fetch(url, options);

            // If response is unauthorized (419), refresh CSRF token
            if (response.status === 419) {
                await refreshCSRFToken();
                // Retry the request with new token
                return csrfFetch(url, options);
            }

            return response;
        };

        // Function to refresh CSRF token
        async function refreshCSRFToken() {
            try {
                const response = await fetch('/refresh-csrf', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.csrf_token && data.csrf_name) {
                        // Update meta tags
                        document.querySelector('meta[name="csrf-token"]').content = data.csrf_token;
                        document.querySelector('meta[name="csrf-name"]').content = data.csrf_name;
                        return true;
                    }
                }
                throw new Error('Failed to refresh CSRF token');
            } catch (error) {
                console.error('CSRF refresh failed:', error);
                return false;
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('loginApp', () => ({
                errors: {},
                showPassword: false,
                loading: false,

                form: {
                    username: '',
                    password: '',
                },

                async login() {
                    try {
                        // Reset errors
                        this.errors = {};
                        this.loading = true;

                        // Validate form
                        if (!this.validateForm()) {
                            this.loading = false;
                            return;
                        }

                        const formData = new FormData();
                        formData.append('username', this.form.username.trim());
                        formData.append('password', this.form.password);

                        const response = await csrfFetch('<?= base_url('login') ?>', {
                            method: 'POST',
                            body: formData,
                            credentials: 'same-origin'
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422) {
                                this.errors = data.errors || {};
                                Swal.fire('Validation Error', 'Please check your input.', 'warning');
                            } else if (response.status === 401) {
                                Swal.fire('Login Failed', data.message || 'Invalid username or password', 'error');
                            } else {
                                throw new Error(data.message || 'Login failed');
                            }
                            this.loading = false;
                            return;
                        }

                        if (data.status === 'success') {
                            // Store user info if needed
                            if (data.user) {
                                sessionStorage.setItem('user', JSON.stringify(data.user));
                            }

                            // Show success message
                            await Swal.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: 'Redirecting to dashboard...',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Redirect based on role
                            if (data.role === 'admin') {
                                window.location.href = '<?= base_url('admin/pdao') ?>';
                            } else if (data.role === 'user') {
                                window.location.href = '<?= base_url('pdao') ?>';
                            } else {
                                window.location.href = '<?= base_url('dashboard') ?>';
                            }
                        } else {
                            this.errors = data.errors || {};
                            Swal.fire('Login Failed', data.message || 'Invalid credentials', 'error');
                            this.loading = false;
                        }
                    } catch (err) {
                        console.error('Login error:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Connection Error',
                            text: 'Unable to connect to the server. Please check your internet connection and try again.',
                            confirmButtonText: 'OK'
                        });
                        this.loading = false;
                    }
                },

                validateForm() {
                    let isValid = true;

                    if (!this.form.username.trim()) {
                        this.errors.username = 'Username is required';
                        isValid = false;
                    }

                    if (!this.form.password) {
                        this.errors.password = 'Password is required';
                        isValid = false;
                    }

                    return isValid;
                },

                resetForm() {
                    this.form.username = '';
                    this.form.password = '';
                    this.errors = {};
                },
            }));
        });

        // Optional: Handle Enter key press globally
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const loginForm = document.querySelector('[x-data="loginApp()"]');
                if (loginForm && loginForm.__x) {
                    const app = loginForm.__x.$data;
                    if (!app.loading) {
                        app.login();
                    }
                }
            }
        });
    </script>
</body>

</html>