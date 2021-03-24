
import GuestArea from "./components/GuestArea";
import SupportAgentArea from "./components/SupportAgentArea";
import Navbar from "./components/Navbar";
import Register from "./components/auth/Register";
import Login from "./components/auth/Login";

export const routes = [
    {
        path:'/',
        component:GuestArea,
        meta: {
            guest: true
        }
    },
    {
        path:'/navbar',
        component:Navbar,
        meta: {
            guest: true
        }
    },
    {
        path:'/guest',
        component:GuestArea,
        meta: {
            guest: true
        }
    },
    {
        path:'/support-agent',
        component:SupportAgentArea,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guest: true
        }
    },
];

