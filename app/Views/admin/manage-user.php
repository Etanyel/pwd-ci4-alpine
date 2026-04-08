<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('manage-user-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<div class="" x-data="manageUserApp()">
    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
        <div class="d-flex align-items-center justify-content-between">

            <div class="d-flex gap-4 align-items-center">
                <h5>User Lists</h5>
                <div class="" style="width: 350px;">
                    <input type="text" class="form-control mb-0" placeholder="Search here...">
                    <!-- <p style="font-size: smaller;">Search here</p> -->
                </div>

                <div class="" style="width: 350px;">
                    <select id="" class="form-select">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="" style="width: 350px;">
                    <select id="" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>



            <div class="d-flex gap-2">
                <button class="btn btn-primary bg-gradient btn-sm"> <i class="bi bi-plus me-2"></i> Add User</button>
            </div>
        </div>

    </div>


    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in users" :key="user.id">
                        <tr @click="showUser(user.id)">
                            <td x-text="user.id"></td>
                            <td x-text="user.firstname + ' ' + (user.middle ? user.middle : '') + ' ' + user.lastname"></td>
                            <td x-text="user.username"></td>
                            <td>
                                <span
                                    class="badge d-inline-flex align-items-center gap-1"
                                    :class="user.isActive == 1 ? 'text-bg-success' : 'text-bg-dark'">

                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                                    <span x-text="user.isActive == 1 ? 'Active' : 'Inactive'"></span>

                                </span>
                            </td>
                            <td x-text="user.role"></td>
                            <td x-text="formatDate(user.created_at)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function manageUserApp() {
        return {
            search: '',
            errors: {},
            users: [],

            init() {
                this.fetchUsers();
            },

            async fetchUsers() {
                const res = await fetch('<?= base_url('/admin/fetch-users'); ?>');

                const data = await res.json();
                if (data.status == 'error') {
                    console.log(data);

                } else {

                    this.users = data.data;

                }
            },

            formatDate(date) {
                return new Date(date.replace(' ', 'T')).toLocaleString('en-SG', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            },

            showUser(id) {
                window.location.href = `/admin/fetch-users/${id}`;
            },

        }
    }
</script>
<?= $this->endSection(); ?>