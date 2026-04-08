<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>

    <!-- Bootstrap -->
    <link href="<?= base_url('css/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?= base_url('bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .forbidden-box {
            max-width: 500px;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center forbidden-box">

            <!-- Icon -->
            <div class="mb-4">
                <i class="bi bi-shield-exclamation text-warning" style="font-size: 5rem;"></i>
            </div>

            <!-- Code -->
            <h1 class="display-4 fw-bold text-dark">403</h1>

            <!-- Title -->
            <h3 class="fw-semibold text-warning mb-3">Forbidden</h3>

            <!-- Message -->
            <p class="text-muted mb-4">
                You don’t have permission to access this resource.
            </p>

            <!-- Buttons -->
            <div class="d-flex justify-content-center gap-3">

                <a href="/" class="btn btn-primary px-4">
                    <i class="bi bi-speedometer2 me-2"></i> Go to Dashboard
                </a>

                <a href="/" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </a>

            </div>

        </div>
    </div>

</body>

</html>