<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Records | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Records<?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">
    <div class="card shadow-sm mt-2 p-3 border-0 d-flex flex-row gap-3">
        <div class="form-group mb-0">
            <input type="text" x-model.debounce.500ms="search" class="form-control" placeholder="Search here...">
            <p class="fw-light">Search here like (pwd number, lastname, and firstname)</p>
        </div>

        <div class="form-group">
            <select name="" id="" class="form-select">
                <option value="">All Records</option>
            </select>
        </div>
    </div>

    <div class="card shadow-sm mt-3 p-3 border-0">
        <!-- Loading Indicator -->
        <div x-show="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading records...</p>
        </div>

        <!-- Table -->
        <div x-show="!loading">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>PWD NUMBER</th>
                        <th>LAST NAME</th>
                        <th>FIRST NAME</th>
                        <th>MIDDLE NAME</th>
                        <th>SUFFIX</th>
                        <th>DATE OF BIRTH</th>
                        <th>AGE</th>
                        <th>SEX</th>
                        <th>BARANGAY</th>
                        <th>PUROK</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="record in records" :key="record.id">
                        <tr @click="window.location.href=`/admin/manage-record/${record.id}`" style="cursor: pointer;">
                            <td x-text="record.pwd_no"></td>
                            <td x-text="record.lastname"></td>
                            <td x-text="record.firstname"></td>
                            <td x-text="record.middlename ? record.middlename : 'N/A'"></td>
                            <td x-text="record.suffix ? record.suffix : 'N/A'"></td>
                            <td x-text="formatDate(record.birthdate)"></td>
                            <td x-text="record.age"></td>
                            <td class="text-uppercase" x-text="record.sex"></td>
                            <td class="text-uppercase" x-text="record.barangay"></td>
                            <td class="text-uppercase" x-text="record.street_name ? record.street_name : 'N/A'"></td>
                        </tr>
                    </template>

                    <!-- No records found -->
                    <tr x-show="records.length === 0">
                        <td colspan="10" class="text-center py-4 text-muted">
                            No records found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3" x-show="!loading && records.length > 0">
        <!-- PAGE INFO -->
        <div class="text-muted small">
            Showing page <span x-text="currentPage"></span>
            of
            <span x-text="totalPages"></span>
            |
            Total records: <span x-text="totalRecords"></span>
        </div>

        <!-- PAGINATION CONTROLS -->
        <div class="d-flex gap-1">
            <!-- PREVIOUS -->
            <button class="btn btn-sm btn-outline-dark"
                @click="previousPage()"
                :disabled="currentPage === 1">
                Previous
            </button>

            <!-- PAGE NUMBERS -->
            <template x-for="page in getPageWindow()" :key="page">
                <button class="btn btn-sm"
                    :class="currentPage === page ? 'btn-dark' : 'btn-outline-dark'"
                    @click="goToPage(page)"
                    x-text="page">
                </button>
            </template>

            <!-- NEXT -->
            <button class="btn btn-sm btn-outline-dark"
                @click="nextPage()"
                :disabled="currentPage === totalPages">
                Next
            </button>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function ManageRecordPage() {
        return {
            // Data properties
            errors: {},
            records: [],
            search: '',
            loading: false,

            // Pagination properties
            currentPage: 1,
            totalPages: 1,
            totalRecords: 0,
            perPage: 10,

            init() {
                this.fetchRecords();

                // Watch for search changes
                this.$watch('search', () => {
                    this.currentPage = 1;
                    this.fetchRecords();
                });
            },

            async fetchRecords() {
                try {
                    this.loading = true;

                    const response = await fetch(
                        `/admin/fetch-records?search=${encodeURIComponent(this.search)}&page=${this.currentPage}`
                    );

                    const data = await response.json();

                    if (data.status === 'error') {
                        console.error(data.errors);
                        this.showError(data.errors);
                        return;
                    }

                    this.records = data.data;
                    this.currentPage = data.pagination.current_page;
                    this.totalPages = data.pagination.total_pages;
                    this.totalRecords = data.pagination.total_records;

                } catch (error) {
                    console.error('Error fetching records:', error);
                    this.showError('Failed to load records. Please try again.');
                } finally {
                    this.loading = false;
                }
            },

            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                    this.fetchRecords();
                    // Scroll to top of table
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },

            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.fetchRecords();
                    // Scroll to top of table
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },

            goToPage(page) {
                if (page !== this.currentPage) {
                    this.currentPage = page;
                    this.fetchRecords();
                    // Scroll to top of table
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },

            // Generate page window (shows 5 pages at a time)
            getPageWindow() {
                const windowSize = 5;
                let start = Math.max(1, this.currentPage - Math.floor(windowSize / 2));
                let end = Math.min(this.totalPages, start + windowSize - 1);

                // Adjust start if we're near the end
                if (end - start + 1 < windowSize) {
                    start = Math.max(1, end - windowSize + 1);
                }

                return Array.from({
                    length: end - start + 1
                }, (_, i) => start + i);
            },

            formatDate(date) {
                if (!date) return 'N/A';
                try {
                    return new Date(date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    return 'Invalid Date';
                }
            },

            showError(message) {
                // You can implement your own error notification here
                console.error(message);
                // Example: alert(message);
            }
        }
    }
</script>
<?= $this->endSection(); ?>