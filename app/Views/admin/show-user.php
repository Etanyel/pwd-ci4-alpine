<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?><?= esc($user['firstname'] . " " . $user['lastname'] . " | Profile") ?><?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?><?= esc($user['firstname'] . " " . $user['lastname']) ?><?= $this->endSection(); ?>

<?= $this->section('manage-user-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<?php if ($user['isActive'] == 0): ?>
    <div class="container-fluid card shadow-sm p-4 text-white bg-dark bg-gradient mt-4">
        <h4>This User is Inactive.</h4>
    </div>
<?php endif; ?>
<div class="" x-data="userApp()">
    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
        <div class="row">
            <div class="col-4 p-4">
                <div class="">
                    <div class="">
                        <form>
                            <div class="mb-4 d-flex justify-content-center">
                                <img
                                    :src="user.img ? user.img : '<?= base_url('img/no_profile.jpg') ?>'"
                                    class="img-fluid rounded border"
                                    alt="Avatar">
                            </div>

                            <div class="mb-4">
                                <label class="btn btn-light form-control border d-flex align-items-center justify-content-center">
                                    <i class="bi bi-upload me-2"></i>
                                    <span x-text="img ? 'Update Photo' : 'Upload Photo'"></span>
                                    <input type="file" class="d-none" @change="previewPhoto">
                                </label>
                            </div>


                        </form>

                        <div class="">
                            <div class="">
                                <form @submit.prevent="changePass">
                                    <div class="mb-2">
                                        <label for="" class="form-label fw-semibold d-flex justify-content-between">
                                            <span>Old Password</span>
                                            <span style="font-size: 13px;" :class="(changePassword.oldpass?.length || 0) > passMax - 3 ? 'text-danger' : 'text-muted'" x-text="`Remaining ${passMax - changePassword.oldpass.length}`"></span>
                                        </label>
                                        <input type="password"
                                            class="form-control"
                                            :class="errors.old_pass ? 'border-danger' : ''"
                                            placeholder="********"
                                            :maxlength="passMax"
                                            x-model="changePassword.oldpass">
                                        <p class="text-danger fw-semibold" style="font-size: 13px;" x-show="errors.old_pass">
                                            <i class="bi bi-exclamation-circle"></i> <span x-text="errors.old_pass ? errors.old_pass : ''"></span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label fw-semibold d-flex justify-content-between">
                                            <span>New Password</span>
                                            <span style="font-size: 13px;" :class="(changePassword.newpass?.length || 0) > newPassMax - 3 ? 'text-danger' : 'text-muted'" x-text="`Remaining ${newPassMax - changePassword.newpass.length}`"></span>
                                        </label>
                                        <input type="password" class="form-control" :class="errors.new_pass ? 'border-danger' : ''" placeholder="********" :maxlength="newPassMax"
                                            x-model="changePassword.newpass">
                                        <p class="text-danger fw-semibold" style="font-size: 13px;" x-show="errors.new_pass">
                                            <i class="bi bi-exclamation-circle"></i> <span x-text="errors.new_pass ? errors.new_pass : ''"></span>
                                        </p>
                                    </div>

                                    <button class="btn btn-light border form-control" type="submit">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-8 border-start p-4">
                <h4 class="mb-5">Personal Information</h4>
                <form @submit.prevent="updateInfo">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Firstname</label>
                            <input type="text"
                                x-model="personInfo.firstname"
                                :class="errors.firstname ? 'border-danger' : ''"
                                class="form-control"
                                placeholder="Enter firstname">
                            <p class="text-danger fw-semibold small" x-text="errors.firstname" x-show="errors.firstname"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Lastname</label>
                            <input type="text"
                                x-model="personInfo.lastname"
                                :class="errors.lastname ? 'border-danger' : ''"
                                class="form-control"
                                placeholder="Enter lastname">
                            <p class="text-danger fw-semibold small" x-text="errors.lastname" x-show="errors.lastname"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Middle Name</label>
                            <input type="text"
                                x-model="personInfo.middlename"
                                :class="errors.middlename ? 'border-danger' : ''"
                                class="form-control"
                                placeholder="Enter middle name">
                            <p class="text-danger fw-semibold small" x-text="errors.middlename" x-show="errors.middlename"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Suffix</label>
                            <input type="text"
                                x-model="personInfo.suffix"
                                :class="errors.suffix ? 'border-danger' : ''"
                                class="form-control"
                                placeholder="Enter suffix" maxlength="4">
                            <p class="text-danger fw-semibold small" x-text="errors.suffix" x-show="errors.suffix"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Age</label>
                            <input type="number"
                                x-model="personInfo.age"
                                :class="errors.age ? 'border-danger' : ''"
                                class="form-control"
                                min="0" max="100" placeholder="Enter age">
                            <p class="text-danger fw-semibold small" x-text="errors.age" x-show="errors.age"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Sex</label>
                            <select class="form-select"
                                x-model="personInfo.sex"
                                :class="errors.sex ? 'border-danger' : ''">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <p class="text-danger fw-semibold small" x-text="errors.sex" x-show="errors.sex"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text"
                                x-model="personInfo.username"
                                :class="errors.username ? 'border-danger' : ''"
                                class="form-control" placeholder="Enter Username">
                            <p class="text-danger fw-semibold small" x-text="errors.username" x-show="errors.username"></p>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Role</label>
                            <select class="form-select"
                                x-model="personInfo.role"
                                :class="errors.role ? 'border-danger' : ''">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            <p class="text-danger fw-semibold small" x-text="errors.role" x-show="errors.role"></p>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select"
                                x-model="personInfo.isActive"
                                :class="errors.isActive ? 'border-danger' : ''">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <p class="text-danger fw-semibold small" x-text="errors.isActive" x-show="errors.isActive"></p>
                        </div>
                    </div>

                    <button class="btn btn-dark form-control" type="submit">Update Personal Info</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function userApp() {
        return {
            search: '',
            errors: {},
            user: {},
            passMax: 20,
            newPassMax: 20,
            id: <?= $user['id'] ?>,
            img: '',
            file: null,


            previewPhoto(event) {
                const selectedFile = event.target.files[0];
                if (!selectedFile) return;

                if (!selectedFile.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    return;
                }

                this.file = selectedFile;

                // Preview the image
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.img = e.target.result; // show preview
                };
                reader.readAsDataURL(selectedFile);

                // Immediately upload to server
                this.uploadPhoto();
            },

            async uploadPhoto() {
                if (!this.file) return;

                const formData = new FormData();
                formData.append('img', this.file); // append actual file
                formData.append('id', this.id); // pass user ID

                try {
                    const res = await fetch('<?= base_url("admin/upload-user-photo") ?>', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status === 'success') {
                        Swal.fire('Success', 'Profile photo updated!', 'success');
                        this.fetchUser();
                    } else {
                        Swal.fire('Error', data.message || 'Upload failed!', 'error');
                    }
                } catch (err) {
                    console.error(err);
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            },

            changePassword: {
                oldpass: '',
                newpass: '',
            },

            personInfo: {
                firstname: '',
                lastname: '',
                middlename: '',
                suffix: '',
                age: '',
                sex: '',
                username: '',
                role: '',
                isActive: '',
            },

            init() {
                this.fetchUser();
            },

            async fetchUser() {
                const res = await fetch('<?= base_url('/admin/fetch-user-profile/' . esc($user['id'])); ?>');

                const data = await res.json();
                if (data.status == 'error') {
                    console.log(data);

                } else {

                    this.user = data.data;
                    this.personInfo = {
                        firstname: this.user.firstname,
                        lastname: this.user.lastname,
                        middlename: this.user.middlename,
                        suffix: this.user.suffix,
                        age: this.user.age,
                        sex: this.user.sex,
                        username: this.user.username,
                        role: this.user.role,
                        isActive: this.user.isActive,

                    };
                }
            },

            async updateInfo() {
                const update = new FormData();
                update.append('firstname', this.personInfo.firstname);
                update.append('lastname', this.personInfo.lastname);
                update.append('middlename', this.personInfo.middlename);
                update.append('suffix', this.personInfo.suffix);
                update.append('age', this.personInfo.age);
                update.append('sex', this.personInfo.sex);
                update.append('username', this.personInfo.username);
                update.append('role', this.personInfo.role);
                update.append('isActive', this.personInfo.isActive);
                update.append('id', this.id);

                const res = await fetch('<?= base_url('admin/user-update-info/') ?>', {
                    method: 'POST',
                    body: update
                });

                const data = await res.json();

                if (data.status == 'error') {
                    this.errors = data.errors;
                } else {
                    this.fetchUser();
                    Swal.fire('Personal Info Updated', 'Personal info updated successfully.', 'success');
                }
            },

            async changePass() {
                const formData = new FormData();
                formData.append('old_pass', this.changePassword.oldpass);
                formData.append('new_pass', this.changePassword.newpass);
                formData.append('id', this.id);

                const res = await fetch('/admin/user-change-pass', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.status == 'error') {
                    this.errors = data.errors;
                } else {
                    Swal.fire('Success', data.message, 'success');
                    this.resetChangePassForm();
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

            resetChangePassForm() {
                this.changePassword.oldpass = '';
                this.changePassword.newpass = '';
            },

        }
    }
</script>
<?= $this->endSection(); ?>