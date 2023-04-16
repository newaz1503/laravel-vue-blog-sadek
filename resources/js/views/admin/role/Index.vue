<template>
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title" style="font-size: 1.425rem">Role List</h2>
            <nav aria-label="breadcrumb">
                <button class="btn btn-primary btn-md" @click="createRole">
                    <i class="icon-plus"></i>
                    Add Role
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
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody v-if="Object.keys(roless).length > 0">
                                <tr v-for="(role, index) in roless" :key="role.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ role.name | capitalize }}</td>
                                    <td>{{ role.created_at | formatDate }}</td>
                                    <td>
                                        <button @click="edit(role)" class="btn btn-info btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button
                                            @click="destroy(role)"
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
        <!-- add role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addRole()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                            <div class="form-group">
                                <label>Role Name</label>
                                <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Role name">
                                <has-error :form="form" field="name" ></has-error>
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
         <!-- edit role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateRole()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                            <div class="form-group">
                                <label>Role Name</label>
                                <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Role name">
                                <has-error :form="form" field="name" ></has-error>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">update</button>
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
            form: new Form({
                id: '',
                name: ''
            }),
            roless: [],
        };
    },
    created() {
        this.getRole();
    },
    methods: {
        closeModal(){
            $('#addRoleModal').modal('hide')
            $('#editRoleModal').modal('hide')
        },
        async getRole() {
            await axios.get("/admin/role")
                .then((res) => {
                    this.roless = res.data;
                })
                .catch((e) => {
                    // this.$snotify.error(e.message, 'Success');
                });
        },
        createRole(){
            this.form.clear()
            this.form.reset()
            $('#addRoleModal').modal('show')
        },
        addRole(){
            this.form.busy = true
            this.form.post('/admin/role/store')
            .then(res => {
                if(this.form.successful){
                     this.getRole();
                    this.$snotify.success('Role Successfully Stored', 'Success');
                    $('#addRoleModal').modal('hide')
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
            $('#editRoleModal').modal('show')
        },
        updateRole(){
             this.form.busy = true
            this.form.post('/admin/role/update/'+this.form.id)
            .then(res => {
                if(this.form.successful){
                    $('#editRoleModal').modal('hide')
                    this.getRole();
                    this.$snotify.success('Role Updated Stored', 'Success');
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },
        destroy(role){
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
                                    axios.delete("/admin/role/destroy/" +role.id)
                                        .then(response => {
                                            this.getRole()
                                            this.$snotify.success(
                                                "Role Successfully Deleted",
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

