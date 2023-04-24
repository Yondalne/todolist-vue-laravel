<template lang="">
    <div class="modal-container add" @click.native="closeModal">
        <div class="modal">
            <h3>Add a Task</h3>
            <form @submit.prevent="insertTask" action="" method="POST">
                <p class="error" v-if="error">{{ error }}</p>
                <div class="input">
                    <label for="title">Title <span :style="{color: 'red'}">*</span></label>
                    <input type="text" id="title" name="title" placeholder="Enter a title" v-model="task.title">
                </div>
                <div class="input">
                    <label for="desc">Description</label>
                    <textarea id="desc" name="desc" placeholder="Describe the task" v-model="task.description"></textarea>
                </div>
                <div class="input">
                    <label for="deadline">Deadline</label>
                    <input type="date" id="deadline" name="deadline" v-model="task.deadline">
                </div>
                <div class="input">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority" v-model="task.priority" class="selectpicker">
                        <option value="1"> Level 1 - Most Important </option>
                        <option value="2"> Level 2 - Important </option>
                        <option value="3"> Level 3 - Less Important </option>
                    </select>
                </div>

                <div class="actions">
                    <button type="submit"><i class="fa fa-check"></i> Save</button>
                    <button type="reset"><i class="fa fa-rotate-left"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            task: {
                title: "",
                description: "",
                deadline: "",
                priority: 2
            },
            error: null
        }
    },
    methods : {
        insertTask(){
            const vm = this;
            axios.post("/api/task", vm.task, {
                headers: {
                    "Authorization" : "Bearer "+ localStorage.getItem("token")
                }
            }).then(function(response){
                if (response.data.status) {
                    vm.$emit("tasksUpdated", response.data.tasks);
                    vm.resetTask();
                } else {
                    this.error = response.data.message;
                }
            }).catch(function(error){
                console.error(error);
            });
        },
        resetTask() {
            this.task = {
                title: "",
                description: "",
                deadline: "",
                priority: 2
            }
        },
        closeModal() {
            const modal = this.$el.querySelector(".modal").parentElement;
            const modalContent = this.$el.querySelector(".modal");
            modalContent.style.transform = "translateX(100%)";
            setTimeout(()=>{
                modal.style.opacity = 0;
                modal.style.visibility = "hidden";
            }, 300);
        }
    },
    mounted() {
        const modalContent = this.$el.querySelector(".modal");
        modalContent.addEventListener("click", (e) => {
            e.stopPropagation();
        });
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
