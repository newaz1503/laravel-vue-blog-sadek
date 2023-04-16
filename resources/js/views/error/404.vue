<template>
    <div class="not_found_box">
        <h3>404</h3>
        <p>Not Found</p>
        <br />
        <router-link :to="{name:'admin.dashboard'}">Go Back</router-link>
    </div>
</template>

<script>
    export default{

    }
</script>

<style scoped>
    /* .not_found_box{
        text-align: center;
        padding-top: 120px;
    } */
</style>
