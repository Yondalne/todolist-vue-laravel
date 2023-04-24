<template lang="">
    <div class="container" :style="{backgroundImage : `url( ${ user.background ? 'storage/'+user.background : '/images/default-bg-home.jpg' } )`}">

        <!-- <sidebar :user="user" @updateBackground="backgroundChange($event)"></sidebar> -->
        <sidebar :user="user" :closeSidebar="toggleSidebar"></sidebar>

        <main class="main">
            <button class="toggle-sidebar" @click="toggleSidebar"> <i class="fa fa-gear"></i></button>
            <h1>My Todo-App <button class="addTask" @click="showAddTask"> <i class="fa fa-plus"></i></button></h1>
            <div class="grid">
                <div class="task-container">
                    <h3>Tasks</h3>
                    <div class="divider"></div>
                    <task v-for="(task, index) in uncompleted" :key="index" :task="task" @tasksUpdated="updateTasks($event)" @showEdit="setTaskEdit"></task>
                </div>

                <div class="task-container completed">
                    <h3>Completed</h3>
                    <div class="divider"></div>
                    <task v-for="(task, index) in completed" :key="index" :task="task" @tasksUpdated="updateTasks($event)" @showEdit="setTaskEdit"></task>
                </div>

                <div class="task-container late">
                    <h3>Late</h3>
                    <div class="divider"></div>

                    <task v-for="(task, index) in late" :key="index" :task="task" @tasksUpdated="updateTasks($event)" @showEdit="setTaskEdit"></task>
                </div>
            </div>
        </main>

        <add-task-modal @tasksUpdated="updateTasks($event)"></add-task-modal>

        <div class="modal-container edit" @click="closeModal">
            <div class="modal">
                <h3>Edit a Task</h3>
                <p class="error">{{ error }}</p>
                <p class="success">{{ success }}</p>
                <form @submit.prevent="editTask" action="" method="POST">
                    <div class="input" :style="{marginTop: `${error ? '25px' : '10px'}`}">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter a title" v-model="taskToEdit.title">
                    </div>
                    <div class="input">
                        <label for="desc">Description</label>
                        <textarea id="desc" name="desc" placeholder="Describe the task" v-model="taskToEdit.description"></textarea>
                    </div>
                    <div class="input">
                        <label for="deadline">Deadline</label>
                        <input type="date" id="deadline" name="deadline" v-model="taskToEdit.deadline">
                    </div>
                    <div class="input">
                        <label for="priority">Priority</label>
                        <select name="priority" id="priority" v-model="taskToEdit.priority" class="selectpicker">
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
    </div>
</template>

<script>

import axios from "axios";
import "../assets/js/fontawesome-all.min.js";
// import "../assets/js/home.js";

import Sidebar from "../components/Sidebar.vue";
import Task from "../components/Task.vue";
import AddTaskModal from "../components/AddTaskModal.vue";
export default {

    components: {
        Sidebar,
        Task,
        AddTaskModal
    },

    data() {
        return {
            user : {},
            completed : [],
            uncompleted: [],
            late: [],
            taskToEdit : {
                title: "",
                description: "",
                deadline: "",
                priority: 2
            },
            error : null,
            success : null
        }
    },

    methods: {
        // Event listeners
        backgroundChange(value) {
            console.log(value);
        },
        updateTasks(tasks) {
            console.log(tasks);
            this.completed = tasks.completed;
            this.uncompleted = tasks.uncompleted;
            this.late = tasks.late;
        },
        setTaskEdit(task) {
            this.taskToEdit = task;
            this.showEditTask();
        },

        // Methods modal
        toggleSidebar() {
            const settingbtn = this.$el.querySelector(".toggle-sidebar");
            const sidebar = this.$el.querySelector(".sidebar");
            if (sidebar.classList.contains("hide")) {
                sidebar.style.display = "block";

                settingbtn.style.visibility = "hidden";
                settingbtn.style.opacity = "0";

                setTimeout(()=>{
                    sidebar.style.opacity = 1;
                    sidebar.style.visibility = "visible";
                }, 100)

                sidebar.classList.remove("hide");
            } else {
                sidebar.style.opacity = 0;
                sidebar.style.visibility = "hidden";

                settingbtn.style.visibility = "visible";
                settingbtn.style.opacity = "1";

                setTimeout(()=>{
                    sidebar.style.display = "none";
                }, 300)
                sidebar.classList.add("hide");
            }
        },
        showAddTask() {
            const modal = this.$el.querySelector(".modal-container.add");
            const modalContent = this.$el.querySelector(".modal-container.add .modal");

            modal.style.opacity = 1;
            modal.style.visibility = "visible";
            setTimeout(()=>{
                modalContent.style.transform = "translateX(0)";
            }, 300);
        },
        showEditTask() {
            const modal = this.$el.querySelector(".modal-container.edit");
            const modalContent = this.$el.querySelector(".modal-container.edit .modal");

            modal.style.opacity = 1;
            modal.style.visibility = "visible";
            setTimeout(()=>{
                modalContent.style.transform = "translateX(0)";
            }, 300);
        },
        closeModal() {
            const modal = this.$el.querySelector(".modal-container.edit");
            const modalContent = this.$el.querySelector(".modal-container.edit .modal");
            modalContent.style.transform = "translateX(100%)";
            setTimeout(()=>{
                modal.style.opacity = 0;
                modal.style.visibility = "hidden";
            }, 300);
            this.success = null;
        },

        editTask() {
            const vm = this;
            console.log(vm.taskToEdit);
            axios.put("/api/task/"+ vm.taskToEdit.id, vm.taskToEdit, {
                headers : {
                    "Authorization" : "Bearer " + localStorage.getItem("token"),
                }
            }).then(function(response) {
                if (response.data.status) {
                    vm.completed = response.data.tasks.completed;
                    vm.uncompleted = response.data.tasks.uncompleted;
                    vm.late = response.data.tasks.late;

                    vm.success = response.data.message;
                } else {
                    this.error = response.data.message;
                }
            }).catch(function(error) {
                console.error(error);
            });
        }
    },

    mounted() {
        const vm = this;
        axios.get("/api/task" , {
            headers: {
                "Authorization" : "Bearer " + localStorage.getItem("token"),
            }
        })
            .then(function(response) {
                vm.completed = response.data.tasks.completed;
                vm.uncompleted = response.data.tasks.uncompleted;
                vm.late = response.data.tasks.late;
            })
            .catch(function(error) {
                console.error(error);
            });

        this.user = JSON.parse(localStorage.getItem("user"));

        if (!this.user.background) {
            this.user.background = "";
        }

        const settingbtn = this.$el.querySelector(".toggle-sidebar");
        settingbtn.style.visibility = "visible";
        settingbtn.style.opacity = "1";


        const modalContent = this.$el.querySelector(".modal-container.edit .modal");
        modalContent.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    },
}

</script>
<style lang="css">
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
    @import '../assets/css/home.css';
    @import '../assets/css/fontawesome-all.min.css';


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


