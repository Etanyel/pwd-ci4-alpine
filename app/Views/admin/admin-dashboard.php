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

    <?php if (!empty($persons) && count($persons) > 0): ?>
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
                        <tr onclick="window.location.href='<?= base_url('/admin/manage-record/' . $p['id']) ?>'"
                            style="cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#f8f9fa'"
                            onmouseout="this.style.backgroundColor=''">
                            <td><?= esc($p['pwd_no']) ?></td>
                            <td><?= strtoupper(esc($p['lastname'])) ?></td>
                            <td><?= strtoupper(esc($p['firstname'])) ?></td>
                            <td><?= !empty($p['middlename']) ? strtoupper(esc($p['middlename'])) : 'N/A' ?></td>
                            <td><?= !empty($p['suffix']) ? strtoupper(esc($p['suffix'])) : 'N/A' ?></td>
                            <td><?= date('F d, Y', strtotime(esc($p['birthdate']))) ?></td>
                            <td><?= esc($p['age']) ?></td>
                            <td class="text-uppercase"><?= esc($p['sex']) ?></td>
                            <td class="text-uppercase"><?= esc($p['barangay']) ?></td>
                            <td class="text-uppercase"><?= !empty($p['street_name']) ? esc($p['street_name']) : 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing <?= count($persons) ?> of <?= $pagination['total_records'] ?> records
                    <br>
                    Page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>
                </div>

                <div class="d-flex gap-1">
                    <!-- Previous Button -->
                    <a href="<?= current_url() ?>?page=<?= $pagination['current_page'] - 1 ?>"
                        class="btn btn-sm btn-outline-dark <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>"
                        <?= $pagination['current_page'] <= 1 ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                        Previous
                    </a>

                    <!-- Page Numbers -->
                    <?php
                    $startPage = max(1, $pagination['current_page'] - 2);
                    $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);

                    if ($startPage > 1): ?>
                        <a href="<?= current_url() ?>?page=1" class="btn btn-sm btn-outline-dark">1</a>
                        <?php if ($startPage > 2): ?>
                            <span class="btn btn-sm disabled">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <a href="<?= current_url() ?>?page=<?= $i ?>"
                            class="btn btn-sm <?= $pagination['current_page'] == $i ? 'btn-dark' : 'btn-outline-dark' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($endPage < $pagination['total_pages']): ?>
                        <?php if ($endPage < $pagination['total_pages'] - 1): ?>
                            <span class="btn btn-sm disabled">...</span>
                        <?php endif; ?>
                        <a href="<?= current_url() ?>?page=<?= $pagination['total_pages'] ?>"
                            class="btn btn-sm btn-outline-dark">
                            <?= $pagination['total_pages'] ?>
                        </a>
                    <?php endif; ?>

                    <!-- Next Button -->
                    <a href="<?= current_url() ?>?page=<?= $pagination['current_page'] + 1 ?>"
                        class="btn btn-sm btn-outline-dark <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?>"
                        <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                        Next
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Export Button -->
        <!-- <div class="mt-3 text-end">
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-printer"></i> Print
            </button>
        </div> -->

    <?php else: ?>
        <div class="text-center py-5 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
            <div>
                <i class="bi bi-folder-x text-muted d-block mb-3" style="font-size: 10vh;"></i>
                <h5 class="fw-semibold text-secondary">
                    No Records Available
                </h5>
                <p class="text-muted mb-0">
                    There are currently no records added for the month of
                    <span class="fw-bold text-primary"><?= strtoupper(date('F Y')) ?></span>.
                </p>
                <a href="<?= base_url('/admin/manage-records') ?>" class="btn btn-primary btn-sm mt-3">
                    <i class="bi bi-plus-circle"></i> View All Records
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>

<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    // Preserve pagination when printing
    document.addEventListener('DOMContentLoaded', function() {
        // Add any dashboard-specific JavaScript here
        console.log('Dashboard loaded');
    });
</script>
<?= $this->endSection(); ?>