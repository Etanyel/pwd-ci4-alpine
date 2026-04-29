<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <title><?= $this->renderSection('tab-title') ?? 'Dashboard' ?></title>

    <!-- Bootstrap -->
    <link href="<?= base_url('css/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap JS -->
    <!-- <link href="" rel="stylesheet"> -->

    <!-- Icons -->
    <link href="<?= base_url('bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">

    <!-- Alpine -->
    <script defer src="<?= base_url('js/alpinejs/dist/cdn.min.js') ?>"></script>

    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .nav-link span {
            transition: opacity 0.2s;
        }

        .nav-item:hover {
            background-color: #808080;
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            display: none;
        }

        .content {
            transition: margin-left 0.3s;
        }

        .content.expanded {
            margin-left: 70px;
        }

        .content.normal {
            margin-left: 250px;
        }
    </style>
</head>

<body x-data="{ open: true }" class="bg-light">

    <!-- Sidebar -->
    <div :class="open ? 'sidebar bg-dark text-white position-fixed d-flex flex-column' 
                  : 'sidebar collapsed bg-dark text-white position-fixed d-flex flex-column'">

        <!-- TOP PART -->
        <div>
            <!-- Brand -->
            <div class="p-3 d-flex justify-content-between align-items-center shadow mb-2">
                <span x-show="open">
                    <i class="bi bi-person-wheelchair"></i>
                    PWD Management System</span>
                <button class="btn btn-sm btn-ghost text-white" @click="open = !open">
                    <i class="bi bi-layout-sidebar"></i>
                </button>
            </div>

            <!-- Navigation -->
            <ul class="nav flex-column px-2 gap-2">

                <li class="nav-item rounded <?= $this->renderSection('dashboard-active') ?>">
                    <a href="<?= base_url('/admin/pdao'); ?>" class="nav-link text-white">
                        <i class="bi bi-speedometer2"></i>
                        <span x-show="open"> Dashboard</span>
                    </a>
                </li>

                <li class="nav-item rounded <?= $this->renderSection('manage-records-active') ?>">
                    <a href="<?= base_url('/admin/manage-records'); ?>" class="nav-link text-white">
                        <i class="bi bi-list-task"></i>
                        <span x-show="open">Manage Records</span>
                    </a>
                </li>

                <li class="nav-item rounded <?= $this->renderSection('add-record-active') ?>">
                    <a href="<?= base_url('/admin/add-record'); ?>" class="nav-link text-white">
                        <i class="bi bi-list-check"></i>
                        <span x-show="open">Add Record</span>
                    </a>
                </li>

                <li class="nav-item rounded <?= $this->renderSection('manage-user-active') ?>">
                    <a href="<?= base_url('/admin/manage-users'); ?>" class="nav-link text-white">
                        <i class="bi bi-people"></i>
                        <span x-show="open">Manage Users</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- BOTTOM PART (LOGOUT) -->
        <div class="mt-auto px-2 pb-3 text-center">
            <a href="/logout" @click="localStorage.removeItem('role')" class="nav-link text-white btn btn-danger p-2 shadow bg-gradient">
                <i class="bi bi-box-arrow-right"></i>
                <span x-show="open"> Logout</span>
            </a>
        </div>

    </div>

    <!-- Content -->
    <div :class="open ? 'content normal p-2' : 'content expanded p-2'">

        <!-- Top Navbar -->
        <nav class="navbar navbar-white bg-white rounded shadow-sm mb-2 p-4">
            <span class="navbar-brand mb-0 h5"><?= $this->renderSection('nav-title') ?></span>
        </nav>

        <!-- Page Content -->
        <?= $this->renderSection('content') ?>

    </div>


    <script src="<?= base_url('sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('css/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
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

    <!-- Scripts -->
    <?= $this->renderSection('scripts') ?>

</body>

</html>