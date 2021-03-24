<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Guest</h4>
                    </div>
                    <div class="col-md-6">
                        <nav class="navbar navbar-light bg-light">
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="Ticket reference number"
                                       aria-label="Search" v-model="search.ticket_reference_no">
                                <button class="btn btn-outline-success my-0 mr-sm-2" type="button"
                                        @click="searchTicketById()" :disabled="!search.ticket_reference_no">Search
                                </button>
                                <button class="btn btn-outline-danger my-0 my-sm-0" type="button" @click="resetAll()">
                                    Cancel
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 v-if="!isClickSearch">Open Ticket</h4>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 v-if="isClickSearch">Ticket ref No : {{ ticket.ticket_reference_no }}</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 v-if="isClickSearch">status : {{ ticket.ticket_status }}</h5>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Name</label>
                                            <input type="text" class="form-control" id="inputEmail4" placeholder="Name"
                                                   v-model="ticket.customer_name" :disabled="isClickSearch">
                                            <span v-for="error in errors.customer_name">{{ error }}<br></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Phone Number</label>
                                            <input type="text" class="form-control" id="inputPassword4"
                                                   placeholder="Phone Number" v-model="ticket.phone_number"
                                                   :disabled="isClickSearch">
                                            <span v-for="error in errors.phone_number">{{ error }}<br></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Email</label>
                                        <input type="email" class="form-control" id="inputAddress" placeholder="Email"
                                               v-model="ticket.email" :disabled="isClickSearch">
                                        <span v-for="error in errors.email">{{ error }}<br></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Problem</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"
                                                  v-model="ticket.problem_description"
                                                  :disabled="isClickSearch"></textarea>
                                        <span v-for="error in errors.problem_description">{{ error }}<br></span>
                                    </div>
                                    <div class="form-group" v-if="isClickSearch">
                                        <label>Reply</label>
                                        <table class="table">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" style="width: 80%">Answer</th>
                                                <th scope="col" style="width: 20%">Date & Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="data in ticket.reply">
                                                <td>{{ data.reply }}</td>
                                                <td>{{ data.created_at }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary" @click="createTicket()"
                                            v-if="!isClickSearch">Submit
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "GuestArea",
    data() {
        return {
            isClickSearch: false,
            search: {
                ticket_reference_no: '',
            },
            ticket: {
                ticket_reference_no: '',
                customer_name: '',
                phone_number: '',
                email: '',
                problem_description: '',
                ticket_status: '',
            },
            errors: []
        }
    },
    methods: {
        createTicket() {
            let self = this;
            axios.post('api/createTicket', self.ticket).then(function (response) {
                alert('Ticket successfully created');
                self.resetTicket();
                self.errors = [];
            }).catch(error => {
                if (error.response.status == 422) {
                    self.errors = error.response.data.errors;
                }
            })
        },
        searchTicketById() {
            this.isClickSearch = true;
            let self = this;
            axios.post('api/searchTicketById', self.search).then(function (response) {
                self.ticket = response.data.data;
                self.ticket.reply = response.data.data.replies;
            })
        },
        resetAll() {
            this.isClickSearch = false;
            this.resetTicket();
            this.search = {
                ticket_reference_no: '',
            }
        },
        resetTicket() {
            this.ticket = {
                customer_name: '',
                phone_number: '',
                email: '',
                problem_description: '',
            }
        }
    }
}
</script>

<style scoped>
span {
    font-size: 12px;
    color: red;
}
</style>
