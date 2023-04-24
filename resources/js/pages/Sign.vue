<template lang="">
    <div class="container">
        <form @submit.prevent="login" class="form-container">
            <h1>Sign in</h1>
            <p class="error" v-if="error">{{ error }}</p>
            <div class="input-group">
                <div class="input">
                    <label for="pseudo">Pseudo</label>
                    <input type="pseudo" name="pseudo" id="pseudo" placeholder="enter your pseudo" v-model="user.pseudo">
                </div>
                <div class="input">
                    <label for="pwd">Password</label>
                    <input type="password" name="password" id="pwd" placeholder="enter your password" v-model="user.password">
                </div>
            </div>
            <input type="submit" value="Login">
            <div class="link">
                <p>Not register yet ? <router-link :to="'/register'">Register here</router-link></p>
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
                pseudo: "",
                password: ""
            },
            error: null,
        }
    },
    methods : {
        login() {
            axios.post("/api/login", this.user)
                .then(response => {
                        if (response.data.status) {
                            localStorage.setItem("token", response.data.token);
                            localStorage.setItem("user", JSON.stringify(response.data.user));
                            this.$router.push({name: "Home"});
                        } else {
                            this.error = response.data.message;
                        }
                    })
                .catch(error => {
                        console.log(error);
                    })

        }
    },
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
