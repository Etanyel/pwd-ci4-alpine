<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Export Records | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Export Records<?= $this->endSection(); ?>

<?= $this->section('export-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ExportRecordPage()">
    <div class="card shadow-sm mt-3 p-4 border-0 vh-100 d-flex justify-content-center">

        <div class="text-center mb-4">
            <h5 class="fw-bold mb-1">Export Records</h5>
            <small class="text-muted">
                Download PWD records in Excel format
            </small>
        </div>

        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">

            <!-- Export All -->
            <a href="/admin/export-records/download"
                target="_blank"
                class="btn btn-success d-flex flex-column justify-content-center align-items-center text-center px-5 py-4 shadow-sm">

                <div class="fs-5 fw-semibold">
                    <i class="bi bi-download me-2"></i>
                    Export All Records
                </div>

                <small class="mt-2 text-light opacity-75">
                    Download complete Excel report
                </small>
            </a>

            <!-- Export By Month -->
            <button data-bs-toggle="modal" data-bs-target="#exportMonth"
                class="btn btn-outline-success d-flex flex-column justify-content-center align-items-center text-center px-5 py-4 shadow-sm">

                <div class="fs-5 fw-semibold">
                    <i class="bi bi-calendar-event me-2"></i>
                    Export by Month
                </div>

                <small class="mt-2">
                    Filter pwd records by month created
                </small>
            </button>

        </div>

    </div>

</div>

<div class="modal fade" id="exportMonth" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Month</h4>
                <span class="btn-close" data-bs-dismiss="modal" style="cursor: pointer;"></span>
            </div>
            <div class="modal-body" x-data="monthPicker()">
                <!-- <input type="month" id="monthPicker"> -->

                <div class="d-flex justify-content-center">
                    <div x-ref="picker"></div>

                </div>
                <p x-show="selectedDate" class="mt-3 d-flex justify-content-center">
                    <span x-show="selectedValue">Month & Year Selected: <small class="fw-bold" x-text="selectedDate"></small></span>
                </p>
                <button class="btn btn-success float-end" x-show="selectedValue" @click="window.location.href='/admin/export-records/month/' + selectedValue">Proceed</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ExportRecordPage', () => {
            return {

            }
        });
    });

    function monthPicker() {
        return {
            selectedDate: '',
            selectedValue: '',

            init() {
                flatpickr(this.$refs.picker, {
                    inline: true,
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: "F Y",
                            altFormat: "F Y"
                        })
                    ],
                    onChange: (selectedDates, dateStr) => {
                        this.selectedDate = dateStr;
                        // Format as YYYY-MM for backend
                        if (selectedDates[0]) {
                            const d = selectedDates[0];
                            this.selectedValue = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
                        }
                    }
                });
            }
        }
    }
</script>
<?= $this->endSection(); ?>