<template lang="">
    <div class="container">
        <form @submit.prevent="register" class="form-container">
            <h1>Register</h1>
            <p class="error" v-if="errors">{{ errors }}</p>
            <div class="input-group">
                <div class="input">
                    <label for="pseudo">Pseudo</label>
                    <input type="pseudo" name="pseudo" v-model="user.pseudo" id="pseudo" placeholder="enter your pseudo">
                </div>
                <div class="input">
                    <label for="pwd">Password</label>
                    <input type="password" name="password" v-model="user.password" id="pwd" placeholder="enter your password">
                </div>
                <div class="input">
                    <label for="pwd-v">Verify password</label>
                    <input type="password" name="password_confirmation" v-model="user.password_confirmation" id="pwd-v" placeholder="re enter your password">
                </div>
            </div>
            <input type="submit" value="Sign up">
            <div class="link">
                <p>Already has an account ? <router-link :to="'/login'">Sign in here</router-link></p>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            user : {
                pseudo : "",
                password : "",
                password_confirmation : ""
            },
            errors: null,
        }
    },

    methods: {
        register() {
            axios.post("/api/register", this.user)
              .then(response => {
                    if (response.data.status) {
                        console.log(response.data);
                        localStorage.setItem("user", JSON.stringify(response.data.user));
                        localStorage.setItem("token", response.data.token);
                        this.$router.push("/");
                    } else {
                        this.errors = response.data.message;
                    }
                })
              .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped lang="css">
    @import '../assets/css/login.css';
    /*
        by Yondalne, follow me on :
        {
            Mail: benalicherif.yd@gmail.com
            Github: https://github.com/Yondalne ,
            LinkedIn : https://www.linkedin.com/in/ben-ali-cherif-3746b0222/ ,
            Instagram : https://www.instagram.com/yondalne/
        }
        image source: [
            https://fr.freepik.com/search?format=search&last_filter=type&last_value=vector&query=backgrounds&type=vector ,
            https://wall.alphacoders.com/by_category.php?id=3&name=Anime+Wallpapers&filter=4K+Ultra+HD
        ]
    */
</style>
