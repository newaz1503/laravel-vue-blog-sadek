 <template>
         <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                    <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                </div>

                <h3 class="font-weight-light text-center">Sign in to continue</h3>
                <form class="pt-3" @submit.prevent="login">
                  <div class="form-group">
                    <input type="email" v-model="form.email" class="form-control form-control-lg" :class="{ 'is-invalid': form.errors.has('email') }" id="exampleInputEmail1" placeholder="Email">
                     <has-error :form="form" field="email" ></has-error>
                  </div>
                  <div class="form-group">
                    <input type="password" v-model="form.password" class="form-control form-control-lg" :class="{ 'is-invalid': form.errors.has('password') }" id="exampleInputPassword1" placeholder="Password">
                    <has-error :form="form" field="password" ></has-error>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="#" class="auth-link text-black">Forgot password?</a>
                  </div>
                  <div class="mb-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="icon-social-facebook mr-2"></i>Connect using facebook </button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
            </div>
            <!-- page-body-wrapper ends -->
          </div>


   </template>

<script>
    export default {
        data(){
            return{
            form: new Form({
                 email: '',
                 password: ''
            })
            }
        },
        methods:{
            login(){
                this.form.post('/backend-login')
                .then(res => {
                    if(res.status === 200){
                        this.$router.push('/admin/dashboard');
                        this.$router.go('/admin/dashboard')
                        this.$snotify.success(res.data.msg)
                    }
                })
                .catch(e => {
                     this.$snotify.error('Email Or Password Does not match','Error')
                })
            }
        }
    }
</script>

<style scoped>

</style>
