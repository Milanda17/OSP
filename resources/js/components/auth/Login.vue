<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default ">
                    <div class="card-header"><h3>Login</h3></div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="signin" method="post">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" id="name" class="form-control" v-model="loginData.name">
                                <span v-for="error in errors.name">{{ error }}<br></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="loginData.password">
                                <span v-for="error in errors.password">{{ error }}<br></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Signin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '../../auth.js';
import axios from "axios";

export default {
    name: "Login",
    data() {
        return {
            loginData: {
                name: '',
                password: '',
            },
            errors: [],
        }
    },
    methods: {
        signin() {
            axios.post('api/login', this.loginData
            ).then(response => {
                localStorage.setItem('id_token', response.data.access_token)
                localStorage.setItem('name', response.data.user.name)
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token')

                auth.user.authenticated = true
                window.location.href = '/support-agent';
            }, error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                if (error.response.status == 401) {
                    alert("Please enter Username & Password correctly")
                }
            })
        }
    },
}
</script>

<style scoped>
span {
    font-size: 12px;
    color: red;
}
</style>
