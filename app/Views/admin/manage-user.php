<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('manage-user-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<div class="" x-data="manageUserApp()">
    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4" x-show="!showForm">
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
                <button class="btn btn-primary bg-gradient btn-sm" @click="showForm = true"> <i class="bi bi-plus me-2"></i> Add User</button>
            </div>
        </div>

    </div>


    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4" x-show="!showForm">
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
                        <tr @click="showUser(user.id)" style="cursor: pointer">
                            <td x-text="user.id"></td>
                            <td x-text="user.firstname + ' ' + (user.middle ? user.middle : '') + ' ' + user.lastname"></td>
                            <td x-text="user.username"></td>
                            <td>
                                <span
                                    class="badge d-inline-flex align-items-center gap-1"
                                    :class="user.isActive == 1 ? 'text-bg-success' : 'text-bg-dark'">

                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                                    <span x-text="user.isActive == 1 ? 'active' : 'inactive'"></span>

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

    <div class="container-fluid card shadow-sm p-3 bg-white border-0 mt-4" x-show="showForm">
        <div class="">
            <div class="d-flex justify-content-center">
                <div class="mt-5 mb-5">
                    <div class="">
                        <h3 class="fw-bold mb-0">Add new user</h3>
                        <p class="text-muted">Enter the details below to create a new user account.</p>
                    </div>

                    <form action="" class="mb-2">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">FIRST NAME</label>
                                <input type="text" class="form-control form-control-sm" maxlength="20" placeholder="ex. JOSE MARI" required>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">LAST NAME</label>
                                <input type="text" class="form-control form-control-sm" maxlength="20" placeholder="ex. CHAN" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">MIDDLE NAME (optional)</label>
                                <input type="text" class="form-control form-control-sm" maxlength="20" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">SUFFIX</label>
                                <input type="text" maxlength="3" class="form-control form-control-sm" placeholder="ex. JR, SR, III">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">AGE</label>
                                <input type="number" class="form-control form-control-sm" placeholder="" max="99" required>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">SEX</label>
                                <select name="" id="" class="form-select form-select-sm" required>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">ROLE</label>
                                <select name="" id="" class="form-select form-select-sm" required>
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">UPLOAD AVATAR</label>
                                <input type="file" name="" id="" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">USERNAME</label>
                            <input type="text" class="form-control form-control-sm" placeholder="ex. josemarichan123" maxlength="20" required>

                            <label for="" class="form-label mb-0 text-muted fw-semibold" style="font-size: small;">PASSWORD</label>
                            <input type="password" class="form-control form-control-sm" placeholder="ex. password123#" maxlength="20" required>
                        </div>

                    </form>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-outline-dark btn-sm form-control" @click="showForm = false">Submit</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-dark btn-sm form-control" @click="showForm = false">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?= $this->endSection(); ?>


    <!-- Scripts -->
    <?= $this->section('scripts'); ?>
    <script>
        function manageUserApp() {
            return {
                showForm: false,
                search: '',
                errors: {},
                users: [],

                form: {
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    suffix: '',
                    age: '',
                    sex: '',
                    role: '',
                    avatar: '',
                    username: '',
                    password: '',
                },

                init() {
                    this.fetchUsers();
                },

                get validate() {

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