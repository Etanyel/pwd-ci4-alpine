<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>
Dashboard
<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>
Welcome, <?= esc(session()->get('user_firstname')) ?> <?= esc(session()->get('user_lastname')) ?>
<?= $this->endSection(); ?>

<?= $this->section('dashboard-active'); ?>
bg-secondary
<?= $this->endSection(); ?>


<!-- Content Page -->
<?= $this->section('content'); ?>

<?php if (!empty($persons)): ?>
    <div class="card shadow-sm border-0 p-4">


        <div class="mb-0">
            <h5 class="fw-semibold mb-0">
                Newly Added Records for <?= strtoupper(date('F Y')) ?>
            </h5>
            <p class="text-muted mb-0">
                Below is the list of registered persons added during the current month.
            </p>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>PWD No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Suffix</th>
                        <th>Birthdate</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Barangay</th>
                        <th>Purok</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($persons as $p): ?>
                        <tr @click="window.location.href='<?= base_url('/admin/manage-record/' . $p['id']) ?>'" style="cursor: pointer;">
                            <td><?= esc($p['pwd_no']) ?></td>
                            <td><?= strtoupper(esc($p['lastname'])) ?></td>
                            <td><?= strtoupper(esc($p['firstname'])) ?></td>
                            <td><?= !empty($p['middlename']) ? strtoupper(esc($p['middlename'])) : 'N/A' ?></td>
                            <td><?= !empty($p['suffix']) ? strtoupper(esc($p['suffix'])) : 'N/A' ?></td>
                            <td><?= esc($p['birthdate']) ?></td>
                            <td><?= esc($p['age']) ?></td>
                            <td><?= strtoupper(esc($p['sex'])) ?></td>
                            <td><?= esc($p['barangay']) ?></td>
                            <td><?= esc($p['street_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>

    <div class="text-center py-5 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="">
            <i class="bi bi-folder-x text-muted d-block mb-3" style="font-size: 12vh;"></i>

            <h5 class="fw-semibold">
                No Records Available
            </h5>

            <p class="text-muted mb-0">
                There are currently no records added for the month of
                <span class="fw-bold"><?= strtoupper(date('F Y')) ?></span>.
            </p>
        </div>
    </div>

<?php endif; ?>

<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>

<?= $this->endSection(); ?>