import axios from "axios";

export default {
    user: {
        authenticated: false,
    },
    signout() {
        axios.post('api/logout').then(response => {})
        localStorage.removeItem('id_token')
        this.user.authenticated = false
        window.location.href = '/login'

    }
}
