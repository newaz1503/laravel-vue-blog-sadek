<template>

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="profile-image">
                    <!-- <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="profile image"> -->
                    <div class="dot-indicator bg-success"></div>
                    </div>
                    <div class="text-wrapper">
                    <p class="profile-name">Allen Moreno</p>
                    <p class="designation">Administrator</p>
                    </div>
                    <div class="icon-container">
                    <i class="icon-bubbles"></i>
                    <div class="dot-indicator bg-danger"></div>
                    </div>
                </a>
                </li>
                <li class="nav-item">
                <router-link class="nav-link" to="/admin/dashboard">
                    <span class="menu-title">Dashboard</span>
                    <i class="icon-screen-desktop menu-icon"></i>
                </router-link>
                </li>
                <li class="nav-item">
                <router-link class="nav-link" to="/admin/tag">
                    <span class="menu-title">Tag</span>
                    <i class="icon-tag menu-icon"></i>
                </router-link>
                </li>
                <li class="nav-item">
                <router-link class="nav-link" to="/admin/category">
                    <span class="menu-title">Category</span>
                    <i class="icon-list menu-icon"></i>
                </router-link>
                </li>
                <li class="nav-item">
                <router-link class="nav-link" to="/admin/user">
                    <span class="menu-title">Add User</span>
                    <i class="icon-user menu-icon"></i>
                </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/admin/role">
                        <span class="menu-title">Role Management</span>
                        <i class="icon-lock menu-icon"></i>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/admin/assign-role">
                        <span class="menu-title">Assign Role</span>
                        <i class="icon-pencil menu-icon"></i>
                    </router-link>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-title">Basic UI Elements</span>
                    <i class="icon-layers menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                    </ul>
                </div>
                </li>
                <li class="nav-item" @click="logout">
                    <a class="nav-link" to="/admin/logout">
                        <span class="menu-title">Logout</span>
                        <i class="icon-logout menu-icon"></i>
                    </a>
                </li>
            </ul>
            </nav>


</template>

<script>
export default {
     props:['permission'],
    methods:{
        logout(){
            axios.get('/admin/logout')
            .then(res => {
                 this.$router.push('/admin/login');
                this.$router.go('/admin/login')
                console.log(res);
            })
        }
    }
}
</script>

<style scoped>

</style>
