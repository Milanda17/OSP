<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-10">
                <div class="card card-default">
                    <div class="card-header"><h3>Register</h3></div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="register" method="post">
                            <div class="form-row ">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Username</label>
                                    <input type="text" id="name" class="form-control" placeholder="Username"
                                           v-model="registerData.name">
                                    <span v-for="error in errors.name">{{ error }}<br></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="user@example.com"
                                           v-model="registerData.email">
                                    <span v-for="error in errors.email">{{ error }}<br></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control"
                                           v-model="registerData.password">
                                    <span v-for="error in errors.password">{{ error }}<br></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation">Password confirmation</label>
                                    <input type="password" id="password_confirmation" class="form-control"
                                           v-model="registerData.password_confirmation">
                                    <span v-for="error in errors.password_confirmation">{{ error }}<br></span>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Register",
    data() {
        return {
            registerData: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: [],
        }
    },
    methods: {
        register() {
            axios.post('api/register', this.registerData).then(response => {
                alert('Successfully Registered')
            }, error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })
        }
    }
}
</script>

<style scoped>
.row {
    padding-bottom: 5px;
}

span {
    font-size: 12px;
    color: red;
}
</style>
