<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-12">
            <h4>Support Agent</h4>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row" v-if="!isClickView">
          <div class="col-md-8">
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search" placeholder="Customer Name" aria-label="Search"
                     v-model="search.name">
              <button class="btn btn-outline-success my-2 mr-sm-2" type="button" @click="searchTicketByName()"
                      :disabled="!search.name">Search
              </button>
              <button class="btn btn-outline-danger my-0 my-sm-0" type="button" @click="resetSearch()">
                Cancel
              </button>
            </form>
          </div>
        </div>
        <br>
        <table class="table table-sm" v-if="!isClickView">
          <thead class="thead-dark">
          <tr>
            <th scope="col">Ticket referance No</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No</th>
            <th scope="col"></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="data in tickets" v-if="data.ticket_status == 'read'">
            <th>{{ data.ticket_reference_no }}</th>
            <td>{{ data.customer_name }}</td>
            <td>{{ data.email }}</td>
            <td>{{ data.phone_number }}</td>
            <td>
              <button class="btn btn-outline-success my-2 my-sm-0" type="button" @click="setReply(data.id)">Reply
              </button>
            </td>
          </tr>
          <tr v-for="data in tickets" v-if="data.ticket_status == 'unread'" class="unread">
            <th>{{ data.ticket_reference_no }}</th>
            <td>{{ data.customer_name }}</td>
            <td>{{ data.email }}</td>
            <td>{{ data.phone_number }}</td>
            <td>
              <button class="btn btn-outline-success my-2 my-sm-0" type="button" @click="setReply(data.id)">Reply
              </button>
            </td>
          </tr>
          </tbody>
        </table>
        <div v-if="!isClickView">
          <pagination :data="laravelData.data" align="center" @pagination-change-page="getTickets"></pagination>
        </div>
        <div class="row justify-content-center" v-if="isClickView">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h4>Ticket : {{ ticket.ticket_reference_no }}</h4>
              </div>
              <div class="card-body">

                <form>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Name</label>
                      <input type="text" class="form-control" id="inputEmail4" placeholder="Name" disabled
                             v-model="ticket.customer_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Phone Number</label>
                      <input type="text" class="form-control" id="inputPassword4" placeholder="Phone Number" disabled
                             v-model="ticket.phone_number">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" id="inputAddress" placeholder="Email" disabled
                           v-model="ticket.email">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Problem</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled
                              v-model="ticket.problem_description"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlTextarea2">Reply</label>
                    <textarea class="form-control" id="exampleFormControlTextarea2" rows="3"
                              v-model="ticket.reply"></textarea>
                    <span v-for="error in errors.reply">{{ error }}<br></span>
                  </div>
                  <button type="button" class="btn btn-primary" @click="createReply()">Sent</button>
                  <button class="btn btn-outline-danger my-2 my-sm-0" type="button" @click="resetTicket()">Cancel
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
  name: "SupportAgentArea",
  data() {
    return {
      isClickView: false,
      tickets: [],
      search: {
        name: null
      },
      updateStatus: {
        id: ''
      },
      ticket: {
        id: '',
        customer_name: '',
        phone_number: '',
        email: '',
        problem_description: '',
        reply: ''
      },
      errors: [],
      laravelData: {},
    }
  },
  mounted() {
    this.getTickets();
  },

  methods: {
    getTickets(page) {
      axios.get('api/getTickets?page=' + page)
          .then(response => {
            this.laravelData = response.data;
            this.tickets = response.data.data.data;
          });
    },
    setReply(id) {
      let self = this;
      self.isClickView = true;
      self.updateTicketStatus(id);
      self.tickets.forEach(function (value, index) {
        if (value.id == id) {
          self.ticket = value;
        }
      })
    },
    createReply() {
      let self = this;
      axios.post('api/createReply', this.ticket).then(function (response) {
       if (response){
         self. resetTicket();
         self.errors = [];
       }
      }).catch(error => {
        if (error.response.status == 422) {
          self.errors = error.response.data.errors;
        }
      })
    },
    searchTicketByName() {
      this.isClickSearch = true;
      let self = this;
      axios.post('api/searchTicketByName', self.search).then(function (response) {
        self.tickets = response.data.data.data;

      })
    },
    updateTicketStatus(id) {
      let self = this;
      self.updateStatus.id = id;
      axios.post('api/updateTicketStatus', self.updateStatus).then(function (response) {
        self.tickets = response.data.data.data;

      })
      self.getTickets();
    },
    resetTicket() {
      this.isClickView = false;
      this.ticket = {
        id: '',
        customer_name: '',
        phone_number: '',
        email: '',
        problem_description: '',
        reply: ''
      }
    },
    resetSearch(){
      this.search = {
        name:null
      };
      this.getTickets()

    }

  }
}
</script>

<style scoped>
span {
  font-size: 12px;
  color: red;
}
.unread{
  background-color: #DDECD0;
}

</style>
