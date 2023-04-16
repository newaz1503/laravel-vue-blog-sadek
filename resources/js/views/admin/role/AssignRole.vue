<template>
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title" style="font-size: 1.425rem">Assign Role</h2>
            <select v-model="form.id" class="form-control" style="width:320px;color:#000" v-if="roles.length > 0" @change="changeRole">
                <option value="" selected disabled>Select Role</option>
                <option :value="role.id" v-for="role in roles" :key="role.id">{{role.name}}</option>
            </select>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card assign_role">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Resource Name</th>
                                    <th>Read</th>
                                    <th>Create</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(r, i) in resources" :key="i">
                                    <td>{{r.resourceName}}</td>
                                    <td><input type="checkbox" v-model="r.read"></td>
                                    <td><input type="checkbox" v-model="r.create"></td>
                                    <td><input type="checkbox" v-model="r.edit"></td>
                                    <td><input type="checkbox" v-model="r.delete"></td>
                                </tr>

                            </tbody>
                            <div class="mt-3">
                                     <button class="btn btn-primary btn-sm" :loading="isSending" :disabled="isSending" @click="assignRoles">Assign</button>
                                </div>

                        </table>
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
                id: null,
                name: '',

            }),
            isSending: false,
            roles : [],
            resources: [
                {
                    resourceName: 'Tag',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'admin/tag'
                },
                {
                    resourceName: 'Category',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'category'
                },
                {
                    resourceName: 'User',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'user'
                },
                {
                    resourceName: 'Role',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'role'
                },
                {
                    resourceName: 'AssignRole',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'AssignRole'
                },
                {
                    resourceName: 'Dashboard',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'admin/dashboard'
                },
            ],
            defaultResourcesPermission: [
                {
                    resourceName: 'Tag',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'admin/tag'
                },
                {
                    resourceName: 'Category',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'category'
                },
                {
                    resourceName: 'User',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'user'
                },
                {
                    resourceName: 'Role',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'role'
                },
                {
                    resourceName: 'AssignRole',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'AssignRole'
                },
                {
                    resourceName: 'Dashboard',
                    read:false,
                    create:false,
                    edit:false,
                    delete:false,
                    name : 'admin/dashboard'
                },
            ]

        };
    },
    created() {
        this.getRole();
    },
    methods: {
        async getRole() {
            await axios.get("/admin/role")
                .then((res) => {
                    this.roles = res.data;
                    if(res.data){
                        this.form.id = res.data[2].id;
                    }
                    if(res.data[2].permission){
                        this.resources = JSON.parse(res.data[2].permission)
                    }
                })
                .catch((e) => {
                    // this.$snotify.error(e.message, 'Success');
                });
        },
        async assignRoles(){
            let assignData = JSON.stringify(this.resources);
            axios.post('/admin/assign-roles',{'permission': assignData, 'id': this.form.id})
            .then(res => {
                this.$snotify.success('Role Assign Successfully', 'Success');
                let index = this.roles.findIndex(role => role.id == this.form.id);
                this.roles[index].permission = assignData;
            })
            .catch(e => {
                 console.log(e)
            })
        },
        changeRole(){
            let index = this.roles.findIndex(role => role.id == this.form.id);
            let permission = this.roles[index].permission;
            if(!permission){
                this.resources = this.defaultResourcesPermission
            }else{
                this.resources = JSON.parse(permission)
            }
        }
    },
};
</script>

<style scoped>
    .assign_role table th{
        font-weight: 600;
    }
    .assign_role table td:first-child{
        font-weight: 600;
    }
</style>

