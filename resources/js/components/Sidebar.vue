<template lang="">
    <aside class="sidebar hide">
        <div class="content">
            <button class="close" @click="closeSidebar"><i class="fa fa-close"></i></button>
            <h1>{{user.pseudo}}</h1>
            <section class="custom">
                <h3>Customize</h3>
                <form @submit.prevent="custom" enctype="multipart/form-data">
                    <div class="input-file">
                        <p>Background Image</p>
                        <label for="bg">
                            <div>
                                <span>
                                    <i class="fa fa-cloud-arrow-up"></i>
                                </span>
                                <small>Upload Image</small>
                            </div>
                            <img :src="previewFile" alt="">
                        </label>
                        <input type="file" id="bg" @change="fileSelected">
                    </div>
                    <div class="actions">
                        <button type="submit"> <i class="fa fa-check"></i> Save </button>
                        <button type="reset" @click.prevent="reset"> <i class="fa fa-rotate-left"></i> Reset </button>
                    </div>
                </form>
            </section>

            <button class="logout" @click="logout"><i class="fa fa-power-off" color="red"></i> Log out</button>

            <section class="footer">
                <p>Developped by <a href="#">Yondalne</a></p>
                <div class="contact">
                    <a href=""> <i class="fa-brands fa-github"></i> </a>
                    <a href=""> <i class="fa-brands fa-linkedin"></i> </a>
                    <a href=""> <i class="fa-brands fa-google"></i> </a>
                    <a href=""> <i class="fa fa-globe"></i></a>
                    <a href=""> <i class="fa-brands fa-instagram"></i></a>
                </div>
            </section>
        </div>
    </aside>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        closeSidebar: {
            type: Function,
            required: true
        }
    },
    mounted() {
        this.user.newbackground = this.user.background;
    },
    methods: {
        logout() {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            this.$router.push("/login");
            this.$store.dispatch('logout')
        },
        fileSelected(event) {
            this.user.newbackground = event.target.files[0];
            const container = document.querySelector(".container");
            if (container) {
               container.style.backgroundImage = "url("+this.previewFile+")";
            }
        },
        reset() {
            this.user.newbackground = this.user.background;
            const container = document.querySelector(".container");
            if (container) {
               container.style.backgroundImage = "url("+this.previewFile+")";
            }
        },

        custom() {
            const vm = this;

            const formData = new FormData();
            formData.append('background', vm.user.newbackground);

            axios.post("/api/user", formData, {
                headers: {
                    'content-type':'multipart/form-data',
                    'Authorization': 'Bearer '+ localStorage.getItem("token")
                }
            }).then((response) =>{
                if (response.data.status) {

                    this.$emit("updateBackground", response.data.user.background);
                    localStorage.setItem("user", JSON.stringify(response.data.user));

                    vm.user.background = response.data.user.background;
                    vm.user.newbackground = null;
                    vm.user.newbackground = response.data.user.background;
                }
            }).catch((error) =>{
                console.error(error);
            });
        }
    },
    computed: {
        previewFile(){
            if (this.user.newbackground) {
                const preview = URL.createObjectURL(this.user.newbackground);
                return preview;
            } else {
                if (!this.user.background) {
                    return '/images/default-bg-home.jpg'
                } else {
                    return 'storage/'+ this.user.background
                }
            }
        }
    }
}
</script>
<style lang="">
    /*
        by Yondalne, follow me on :
        {
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
