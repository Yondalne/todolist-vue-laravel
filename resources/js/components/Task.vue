<template lang="">
    <div class="task">
        <button class="done" v-if="task.status == 'completed' "><i class="fa fa-check"></i></button>
        <button class="done" v-else @click="completeTask"></button>
        <div class="text">
            <p>{{ task.title }}</p>
            <p><small>{{ task.description }} | Deadline : {{task.deadline}}</small></p>
        </div>
        <p><small> <i class="fa-regular fa-flag"> </i> Priority : {{ task.priority }}</small></p>
        <div class="actions">
            <button class="edit" @click="editTask"> <i class="fa fa-pen"></i> </button>
            <button class="delete" @click="deleteTask"> <i class="fa fa-trash"></i> </button>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {

    props: {
        task: {
            type: Object,
            required: true
        },
    },

    methods: {
        deleteTask() {
            const vm = this;
            axios.delete("/api/task/"+vm.task.id, {
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                }
            }).then(function(response){
                if (response.data.status) {
                    vm.$emit("tasksUpdated", response.data.tasks)
                }
            }).catch(function(error){
                console.error(error);
            });
        },
        completeTask(){
            const vm = this;
            console.log(localStorage.getItem("token"));

            axios.get("/api/completeTask/"+vm.task.id, {
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                }
            }).then(function(response){
                if (response.data.status) {
                    vm.$emit("tasksUpdated", response.data.tasks)
                }
            }).catch(function(error){
                console.error(error);
            });
        },
        editTask(){
            this.$emit("showEdit", this.task);
        },
    },

    mounted() {
    },
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
