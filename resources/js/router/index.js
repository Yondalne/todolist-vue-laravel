import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import Sign from "../pages/Sign.vue";
import Register from "../pages/Register.vue";
import NotFound from "../pages/NotFound.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: "/login",
        name: "Login",
        component: Sign,
        meta: {
            requiresAuth: false
        }
    },

    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: {
            requiresAuth: false
        }
    },

    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFound,
        meta: {
            requiresAuth: false
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        return { name: "Login" };
    }

    if (to.meta.requiresAuth == false && localStorage.getItem("token") && to.name != "NotFound") {
        return { name: "Home"}
    }
})

export default router;
