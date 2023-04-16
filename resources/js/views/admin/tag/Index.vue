<template>
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title" style="font-size: 1.425rem">Tag List</h2>
            <nav aria-label="breadcrumb">
                <button class="btn btn-primary btn-md" @click="createTag">
                    <i class="icon-plus"></i>
                    Add Tag
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
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody v-if="Object.keys(tags).length > 0">
                                <tr v-for="(tag, index) in tags" :key="tag.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ tag.name | capitalize }}</td>
                                    <td>{{ tag.slug }}</td>
                                    <td>{{ tag.created_at | formatDate }}</td>
                                    <td>
                                        <button @click="edit(tag)" class="btn btn-info btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button
                                            @click="destroy(tag)"
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
        <!-- add tag Modal -->
        <div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addTag()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Tag name">
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
         <!-- edit tag Modal -->
        <div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateTag()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Tag name">
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
            tags: [],
            form: new Form({
                id: '',
                name: ''
            })
        };
    },
    created() {
        this.getTag();

    },
    methods: {
        closeModal(){
            $('#addTagModal').modal('hide')
            $('#editTagModal').modal('hide')
        },
        async getTag() {
            await axios
                .get("/admin/tag")
                .then((res) => {
                    this.tags = res.data;
                })
                .catch((e) => {
                    this.$snotify.error('Something Went Wrong', 'Error');
                });
        },
        createTag(){
            this.form.clear()
            this.form.reset()
            $('#addTagModal').modal('show')
        },
        addTag(){
            this.form.busy = true
            this.form.post('/admin/tag/store')
            .then(res => {
                if(this.form.successful){
                     this.getTag();
                    this.$snotify.success('Tag Successfully Stored', 'Success');
                    $('#addTagModal').modal('hide')
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
            $('#editTagModal').modal('show')
        },
        updateTag(){
             this.form.busy = true
            this.form.post('/admin/tag/update/'+this.form.id)
            .then(res => {
                if(this.form.successful){
                    $('#editTagModal').modal('hide')
                    this.getTag();
                    this.$snotify.success('Tag Updated Stored', 'Success');
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },
        destroy(tag){
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
                                    axios.delete("/admin/tag/destroy/" +tag.id)
                                        .then(response => {
                                            this.getTag()
                                            this.$snotify.success(
                                                "Tag Successfully Deleted",
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
