<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <title>PWD | Login</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('css/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap JS -->
    <link href="<?= base_url('css\bootstrap\dist\js\bootstrap.bundle.min.js') ?>" rel="stylesheet">

    <!-- Icons -->
    <link href="<?= base_url('bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- Alpine -->
    <script defer src="<?= base_url('js/alpinejs/dist/cdn.min.js') ?>"></script>
</head>

<body>
    <div x-data="loginApp()" class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card shadow border-0 p-4" style="width: 450px; border-radius: 1rem;">
            <div class="text-center mb-4">
                <!-- <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-person-badge text-primary"></i>
                </div> -->
                <h3 class="fw-bold text-dark mb-1">Person Disability Affairs Office</h3>
                <p class="text-muted small">Management System Login</p>
            </div>

            <form @submit.prevent="login">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"
                            x-bind:class="errors.username ? 'border-1 border-danger' : ''">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input type="text"
                            x-bind:class="errors.username ? 'border-1 border-danger' : ''"
                            class="form-control bg-light border-start-0 ps-0"
                            x-model="form.username"
                            placeholder="Enter your username" required>
                    </div>
                    <div x-show="errors.username" class="text-danger mt-1 fw-medium" style="font-size: 12px;">
                        <i class="bi bi-exclamation-circle me-1"></i> <span x-text="errors.username"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" x-bind:class="errors.password ? 'border-1 border-danger' : ''">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'"
                            class="form-control bg-light border-start-0 border-end-0 ps-0"
                            x-bind:class="errors.password ? 'border-1 border-danger' : ''"
                            x-model="form.password"
                            placeholder="••••••••" required>
                        <button type="button"
                            class="input-group-text bg-light border-start-0"
                            x-bind:class="errors.password ? 'border-1 border-danger' : ''"
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
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script src="<?= base_url('sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <script>
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
                        this.loading = true;

                        const formData = new FormData();
                        formData.append('username', this.form.username.trim());
                        formData.append('password', this.form.password);

                        const res = await csrfFetch('/login', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await res.json();

                        if (data.status !== 'success') {
                            this.errors = data.errors || {};
                            this.loading = false;
                        } else {

                            if (data.role === 'admin') {
                                window.location.href = '/admin/pdao';
                                this.loading = false;

                            } else if (data.role === 'user') {
                                window.location.href = '/pdao';
                                this.loading = false;
                            }
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire('Warning', 'Something went wrong. Please try again.', 'warning');
                    }
                },

                resetForm() {
                    this.form.username = '';
                    this.form.password = '';
                    this.errors = {};
                },
            }));
        });



        window.csrfFetch = function(url, options = {}) {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const name = document.querySelector('meta[name="csrf-name"]').content;

            if (options.body instanceof FormData) {
                options.body.append(name, token);
            } else if (options.body && typeof options.body === 'object') {
                options.headers = {
                    ...(options.headers || {}),
                    'Content-Type': 'application/json'
                };

                options.body = JSON.stringify({
                    ...options.body,
                    [name]: token
                });
            } else {
                options.headers = {
                    ...(options.headers || {}),
                    'Content-Type': 'application/json'
                };

                options.body = JSON.stringify({
                    [name]: token
                });
            }

            return fetch(url, options);
        };
    </script>
</body>

</html>