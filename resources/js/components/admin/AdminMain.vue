<template>
    <div >
        <div class="container-scroller" >
        <!-- partial:partials/_navbar.html -->
        <header-component></header-component>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <sidebar-component :permission="permission"></sidebar-component>
            <!-- partial -->
            <div class="main-panel">
                <app></app>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer-component></footer-component>
            <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
    </div>

</template>

<script>
    export default {
         props:['permission'],
         data(){
            return{

            }
        },
        created(){
            this.$store.commit('setPermission', this.permission)
        }


    }
</script>
