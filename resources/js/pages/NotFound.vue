<template lang="">
    <div class="container">
        <h1 class="first-four">4</h1>

        <div class="cog-wheel1">
            <div class="cog1">
                <div class="top"></div>
                <div class="down"></div>
                <div class="left-top"></div>
                <div class="left-down"></div>
                <div class="right-top"></div>
                <div class="right-down"></div>
                <div class="left"></div>
                <div class="right"></div>
          </div>
        </div>

        <h1 class="second-four">4</h1>

        <p class="wrong-para">Uh Oh! Page not Found!</p>
        <router-link class="link" :to="'/'">Revenir sur le site</router-link>
        <!-- <a class="link" href="/">Revenir sur le site</a> -->
    </div>
</template>

<script>

    export default {
        mounted() {
        }
    }
</script>

<style scoped lang="css">
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css");
    @import "../assets/css/404.css";

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

        This page was originally designed by KDBismael (Github: https://github.com/KDBismael)
    */
</style>
