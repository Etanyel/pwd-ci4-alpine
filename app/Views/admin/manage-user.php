<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Users<?= $this->endSection(); ?>

<?= $this->section('manage-user-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<div class="" x-data="manageUserApp()" x-cloak>
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
                <thead class="table-dark">
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

    <div class="container-fluid mt-4" x-show="showForm">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <!-- HEADER -->
                        <div class="mb-4 text-center">
                            <h3 class="fw-bold mb-1">Add New User</h3>
                            <p class="text-muted mb-0">
                                Enter the details below to create a new user account.
                            </p>
                        </div>

                        <!-- FORM -->
                        <form action="#" method="POST" enctype="multipart/form-data">

                            <!-- NAME -->
                            <div class="row g-3 mb-2">

                                <!-- FIRST NAME -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        FIRST NAME
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        x-model="firstname"
                                        :class="showErrors && firstname.length < 3 ? 'border-danger' : ''"
                                        maxlength="20"
                                        placeholder="ex. JOSE MARI"
                                        required>

                                    <small class="text-danger"
                                        x-show="showErrors && firstname.length < 3">
                                        First name must contain at least 3 characters.
                                    </small>
                                </div>

                                <!-- LAST NAME -->
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        LAST NAME
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        x-model="lastname"
                                        :class="showErrors && lastname.length < 2 ? 'border-danger' : ''"
                                        maxlength="20"
                                        placeholder="ex. CHAN"
                                        required>

                                    <small class="text-danger"
                                        x-show="showErrors && lastname.length < 2">
                                        Last name must contain at least 2 characters.
                                    </small>
                                </div>
                            </div>

                            <!-- MIDDLE NAME & SUFFIX -->
                            <div class="row g-3 mb-2">

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        MIDDLE NAME (Optional)
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        x-model="middlename"
                                        maxlength="20"
                                        placeholder="ex. SANTOS">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        SUFFIX
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        x-model="suffix"
                                        maxlength="5"
                                        placeholder="ex. JR, SR, III">
                                </div>
                            </div>

                            <!-- AGE & SEX -->
                            <div class="row g-3 mb-2">

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        AGE
                                    </label>

                                    <input type="number"
                                        class="form-control"
                                        x-model="age"
                                        :class="showErrors && age < 1 ? 'border-danger' : ''"
                                        min="1"
                                        max="99"
                                        placeholder="ex. 21"
                                        required>

                                    <small class="text-danger"
                                        x-show="showErrors && age < 1">
                                        Please enter a valid age.
                                    </small>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        SEX
                                    </label>

                                    <select class="form-select"
                                        x-model="sex"
                                        :class="showErrors && sex == '' ? 'border-danger' : ''"
                                        required>

                                        <option value="">Select sex</option>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                    </select>

                                    <small class="text-danger"
                                        x-show="showErrors && sex == ''">
                                        Please select a sex.
                                    </small>
                                </div>
                            </div>

                            <!-- ROLE & AVATAR -->
                            <div class="row g-3 mb-2">
                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        ROLE
                                    </label>

                                    <select class="form-select"
                                        x-model="role"
                                        :class="showErrors && role == '' ? 'border-danger' : ''"
                                        required>

                                        <option value="">Select role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>

                                    <small class="text-danger"
                                        x-show="showErrors && role == ''">
                                        Please select a role.
                                    </small>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label mb-1 text-muted fw-semibold small">
                                        UPLOAD AVATAR
                                    </label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>

                            <!-- USERNAME -->
                            <div class="mb-3">
                                <label class="form-label mb-1 text-muted fw-semibold small">
                                    USERNAME
                                </label>

                                <input type="text"
                                    class="form-control"
                                    x-model="username"
                                    :class="showErrors && username.length < 4 ? 'border-danger' : ''"
                                    maxlength="20"
                                    placeholder="ex. josemarichan123"
                                    required>

                                <small class="text-danger"
                                    x-show="showErrors && username.length < 4">
                                    Username must contain at least 4 characters.
                                </small>
                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-4">
                                <label class="form-label mb-1 text-muted fw-semibold small">
                                    PASSWORD
                                </label>

                                <input type="password"
                                    class="form-control"
                                    x-model="password"
                                    :class="showErrors && password.length < 6 ? 'border-danger' : ''"
                                    maxlength="20"
                                    placeholder="ex. password123#"
                                    required>

                                <small class="text-danger"
                                    x-show="showErrors && password.length < 6">
                                    Password must contain at least 8 characters.
                                </small>
                            </div>

                            <!-- BUTTONS -->
                            <div class="row">
                                <div class="col" @dblclick.prevent="showErrors = true">
                                    <button class="btn btn-outline-dark btn-sm form-control" @click="showForm = false" :disabled="!validate">Submit</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-dark btn-sm form-control" @click="showForm = false">Cancel</button>
                                </div>
                            </div>

                        </form>

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
                showErrors: false,
                showForm: false,
                search: '',
                errors: {},
                users: [],
                firstname: '',
                lastname: '',
                middlename: '',
                suffix: '',
                age: '',
                sex: '',
                role: '',
                username: '',
                password: '',

                init() {
                    this.fetchUsers();
                },

                get validate() {
                    return (
                        this.firstname.length >= 3 &&
                        this.lastname.length >= 2 &&
                        this.sex !== '' &&
                        this.age >= 1 &&
                        this.role !== '' &&
                        this.password.length >= 8 &&
                        this.username.length >= 4
                    );
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