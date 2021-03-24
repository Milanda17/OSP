<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Online Support Platform</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <router-link to="/guest"><a class="nav-link" href="#">Guest</a></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/support-agent"><a class="nav-link" href="#">Support Agent</a></router-link>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-right">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <li class="nav-item active">
                        <router-link to="/register"><a class="nav-link" href="#">Register</a></router-link>
                    </li>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <li class="nav-item " v-if="$route.meta.requiresAuth">
                        <a class="nav-link" @click="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
import auth from '../auth.js'

export default {
    name: "Test",

    methods: {
        logout() {
            auth.signout();
        },
    }
}
</script>

<style scoped>
.navbar-right {
    padding-left: 35%;
}
</style>
