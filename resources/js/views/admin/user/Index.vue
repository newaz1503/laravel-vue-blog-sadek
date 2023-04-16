<template>
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title" style="font-size: 1.425rem">User List</h2>
            <nav aria-label="breadcrumb">
                <button class="btn btn-primary btn-md" @click="createUser">
                    <i class="icon-plus"></i>
                    Add User
                </button>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody v-if="Object.keys(users).length > 0">
                                <tr v-for="(user, index) in users" :key="user.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ user.full_name | capitalize }}</td>
                                    <td>{{ user.email }}</td>
                                    <td v-if="user.role">{{ user.role.name }}</td>

                                    <td>
                                        <button @click="edit(user)" class="btn btn-info btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button
                                            @click="destroy(user)"
                                            class="btn btn-danger btn-sm"
                                        >
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- add user Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addUser()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                        <div class="form-group">
                            <label>User Role</label>
                            <select v-model="form.role_id" name="role_id" class="form-control" :class="{ 'is-invalid': form.errors.has('user_type') }">
                                <option value="" selected disabled>Select Role</option>
                                <option :value="role.id" v-for="role in roles" :key="role.id">{{role.name}}</option>
                            </select>
                            <has-error :form="form" field="user_type" ></has-error>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input v-model="form.full_name" type="text" name="full_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('full_name') }" placeholder="User Full name">
                            <has-error :form="form" field="full_name" ></has-error>
                        </div>
                         <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="User Email">
                            <has-error :form="form" field="email" ></has-error>
                        </div>
                         <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="User Password">
                            <has-error :form="form" field="password" ></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>
         <!-- edit user Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <form @submit.prevent="updateUser()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                         <div class="form-group">
                            <label>User Role</label>
                            <select v-model="form.role_id" name="role_id" class="form-control" :class="{ 'is-invalid': form.errors.has('user_type') }">
                                <option value="" selected disabled>Select Role</option>
                                <option :value="role.id" v-for="role in roles" :key="role.id">{{role.name}}</option>
                            </select>
                            <has-error :form="form" field="user_type" ></has-error>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input v-model="form.full_name" type="text" name="full_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('full_name') }" placeholder="User Full name">
                            <has-error :form="form" field="full_name" ></has-error>
                        </div>
                         <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="User Email">
                            <has-error :form="form" field="email" ></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            form: new Form({
                id: '',
                full_name: '',
                email: '',
                password: '',
                user_type: '',
                role_id: null
            }),
            roles : []
        };
    },
    created() {
        this.getUser();
        this.getRole();
    },
    methods: {
        closeModal(){
            $('#addUserModal').modal('hide')
            $('#editUserModal').modal('hide')
        },
        async getUser() {
            await axios.get("/admin/user")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((e) => {
                    this.flashMessage.error({
                        title: "Error Message Title",
                        message: "Oh, you broke my heart! Shame on you!",
                    });
                });
        },
        async getRole() {
            await axios.get("/admin/role")
                .then((res) => {
                    this.roles = res.data;
                })
                .catch((e) => {
                    this.flashMessage.error({
                        title: "Error Message Title",
                        message: "Oh, you broke my heart! Shame on you!",
                    });
                });
        },
        createUser(){
            this.form.clear()
            this.form.reset()
            $('#addUserModal').modal('show')
        },

        addUser(){
            this.form.busy = true
            this.form.post('/admin/user/store')
            .then(res => {
                if(this.form.successful){
                     this.getUser();
                    this.$snotify.success('User Successfully Stored', 'Success');
                    $('#addUserModal').modal('hide')
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },

        edit(customer){
             this.form.clear()
            this.form.reset()
            this.form.fill(customer)
            $('#editUserModal').modal('show')
        },
        updateUser(){
             this.form.busy = true
            this.form.post('/admin/user/update/'+this.form.id)
            .then(res => {
                if(this.form.successful){
                    $('#editUserModal').modal('hide')
                    this.getUser();
                    this.$snotify.success('User Updated Stored', 'Success');
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },
        destroy(user){
             this.$snotify.clear();
                this.$snotify.confirm(
                    "You will not be able to recover this data!",
                    "Are you sure?",
                    {
                        closeOnClick: false,
                        pauseOnHover: true,
                        buttons: [
                            {
                                text: "Yes",
                                action: toast => {
                                    this.$snotify.remove(toast.id);
                                    axios.delete("/admin/user/destroy/" +user.id)
                                        .then(response => {
                                            this.getUser()
                                            this.$snotify.success(
                                                "User Successfully Deleted",
                                                "Success"
                                            );
                                        })
                                        .catch(e => {
                                            console.log(e);
                                        });
                                },
                                bold: true
                            },
                            {
                                text: "No",
                                action: toast => {
                                    this.$snotify.remove(toast.id);
                                },
                                bold: true
                            }
                        ]
                    }
                );
        }
    },
};
</script>

<style scoped></style>
