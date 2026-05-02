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
        // Simple CSRF helpers
        function getCSRF() {
            return {
                token: document.querySelector('meta[name="csrf-token"]').content,
                name: document.querySelector('meta[name="csrf-name"]').content
            };
        }

        function updateCSRF(data) {
            if (data.csrf_token && data.csrf_name) {
                document.querySelector('meta[name="csrf-token"]').content = data.csrf_token;
                document.querySelector('meta[name="csrf-name"]').content = data.csrf_name;
            }
        }

        // Minimal fetch with CSRF
        async function csrfFetch(url, formData) {
            const {token, name} = getCSRF();

            formData.append(name, token);

            return fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
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
                    this.errors = {};
                    this.loading = true;

                    if (!this.validateForm()) {
                        this.loading = false;
                        return;
                    }

                    try {
                        const formData = new FormData();
                        formData.append('username', this.form.username.trim());
                        formData.append('password', this.form.password);

                        const response = await csrfFetch('<?= base_url('login') ?>', formData);
                        const data = await response.json();

                        // ✅ Always update CSRF token
                        updateCSRF(data);

                        if (data.status === 'error') {
                            this.errors = data.errors || {};
                            this.loading = false;
                            return;
                        }

                        if (data.status === 'success') {
                            if (data.role === 'admin') {
                                window.location.href = '<?= base_url('admin/pdao') ?>';
                            } else if (data.role === 'user') {
                                window.location.href = '<?= base_url('pdao') ?>';
                            } else {
                                Swal.fire('Not Authorized', 'Invalid User!', 'error');
                                this.loading = false;
                            }
                        }

                    } catch (err) {
                        console.error(err);
                        Swal.fire('Error', 'Something went wrong.', 'error');
                        this.loading = false;
                    }
                },

                validateForm() {
                    let valid = true;

                    if (!this.form.username.trim()) {
                        this.errors.username = 'Username is required';
                        valid = false;
                    }

                    if (!this.form.password) {
                        this.errors.password = 'Password is required';
                        valid = false;
                    }

                    return valid;
                }
            }));
        });
    </script>
</body>

</html>