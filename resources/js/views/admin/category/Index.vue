<template>
    <div class="content-wrapper">
        <div class="page-header">
            <h2 class="page-title" style="font-size: 1.425rem">Category List</h2>
            <nav aria-label="breadcrumb">
                <button class="btn btn-primary btn-md" @click="createCategory">
                    <i class="icon-plus"></i>
                    Add Category
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
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody v-if="Object.keys(categories).length > 0">
                                <tr v-for="(category, index) in categories" :key="category.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ category.name | capitalize }}</td>
                                    <td v-if="category.image">
                                        <img :src="`/uploads/category/${category.image}`" width="40" height="40" />
                                    </td>
                                    <td>{{ category.created_at | formatDate }}</td>
                                    <td>
                                        <button @click="edit(category)" class="btn btn-info btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button
                                            @click="destroy(category)"
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
        <!-- add category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="addCategory()" @keydown="form.onKeydown($event)" enctype= multipart/form-data laravel>
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Category name">
                            <has-error :form="form" field="name" ></has-error>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" @change="changeImage($event)" name="image"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                            <has-error :form="form" field="image" ></has-error>

                        </div>
                          <div class="my-3" v-if="form.image">
                          <img :src="form.image" width="80" height="80" />
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
         <!-- edit category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="updateCategory()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <alert-error :form="form"></alert-error>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Category name">
                                <has-error :form="form" field="name" ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" @change="changeImage($event)" name="image"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                <has-error :form="form" field="image" ></has-error>
                            </div>
                            <div class="my-3" v-if="form.image">
                          <img :src="showImage()"  width="200" height="150" />
                        </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                    </div>
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
            categories: [],
            form: new Form({
                id: '',
                name: '',
                image: ''
            })
        };
    },
    created() {
        this.getCategory();
    },
    methods: {
        closeModal(){
            $('#addCategoryModal').modal('hide')
            $('#editCategoryModal').modal('hide')
        },
        async getCategory() {
            await axios
                .get("/admin/category")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((e) => {
                    console.log(e)
                });
        },
        createCategory(){
            this.form.clear()
            this.form.reset()
            $('#addCategoryModal').modal('show')
        },
        showImage(){
            if(this.form.image.length > 100){
                return this.form.image
            }else{
                return `/uploads/category/${this.form.image}`
            }
        },
        addCategory(){
            this.form.busy = true
            this.form.post('/admin/category/store')
            .then(res => {
                if(this.form.successful){
                     this.getCategory();
                    this.$snotify.success('Category Successfully Stored', 'Success');
                    $('#addCategoryModal').modal('hide')
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },
        changeImage(event){
              let file = event.target.files[0];
              let reader = new FileReader();
              reader.onload = (evt) => {
                  this.form.image = evt.target.result;
                  console.log(evt.target.result);
              };
              reader.readAsDataURL(file);
            },
        edit(customer){
             this.form.clear()
            this.form.reset()
            this.form.fill(customer)
            $('#editCategoryModal').modal('show')
        },
        updateCategory(){
             this.form.busy = true
            this.form.post('/admin/category/update/'+this.form.id)
            .then(res => {
                if(this.form.successful){
                    $('#editCategoryModal').modal('hide')
                    this.getCategory();
                    this.$snotify.success('Category Updated Stored', 'Success');
                }else{
                    this.$snotify.error('Something went wrong','Error')
                }
            })
            .catch( e => {
                 this.$snotify.error('Something went wrong','Error')
            })
        },
        destroy(category){
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
                                    axios.delete("/admin/category/destroy/" +category.id)
                                        .then(response => {
                                            this.getCategory()
                                            this.$snotify.success(
                                                "Category Successfully Deleted",
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
