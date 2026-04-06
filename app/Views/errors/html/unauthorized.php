<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('css/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?= base_url('bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">

            <!-- Icon -->
            <div class="mb-4">
                <i class="bi bi-shield-lock text-danger" style="font-size: 5rem;"></i>
            </div>

            <!-- Title -->
            <h1 class="fw-bold text-danger">Access Denied</h1>

            <!-- Message -->
            <p class="text-muted fs-5 mb-4">
                You do not have permission to access this page.
            </p>

            <!-- Buttons -->
            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-primary px-4">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                <a href="/logout" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>

        </div>
    </div>

</body>

</html>