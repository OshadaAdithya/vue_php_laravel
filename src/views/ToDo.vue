<template>
    
    <div class="centered-container">
        <div class="set1">
        
        <img alt="todo" class="todo" src="../assets/todo.png" width="100" height="100" />
        <h1>Task List</h1>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <input type="text" placeholder="Type something" class="form-control" v-model="task_item">
            <button @click="submitTask" class="btn btn-primary">Submit</button>
            <button @click="deleteAll" class="btn btn-danger">Clear</button>
        </div>
        <div class="check" v-if="showWarning">
            <p>Please enter something!!!</p>
        
        </div>
        
        <div class="list">
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                <th scope="col" style="width:60px">id</th>
                <th scope="col">Task</th>
                <th scope="col" style="width: 180px;">Status</th>
                <th scope="col" style="width: 80px;" class="text-center">#</th>
                <th scope="col" style="width: 80px;" class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="todo in tasks" :key="todo.id">
                <td>{{ todo.id }}</td>
            <td>
                <template v-if="!todo.editing">{{ todo.task }}</template>
                <input type="text" v-else v-model="todo.task" @keyup.enter="saveTask(todo)">
                
            </td>
            <td>
                <select v-model="todo.status" @change="updateStatus(todo)">
                    <option value="I">In-Progress</option>
                    <option value="D">Done</option>
                    <option value="T">To-Do</option>
                </select>
                
            </td>
            <td>
                <div class="text-center" @click="editTask(todo)">
                <span class="fa fa-edit"></span>
                </div>
            </td>
            <td>
                <div class="text-center" @click="deleteTask(todo)">
                <span class="fa fa-trash-alt"></span>
                </div>
            </td>   
            </tr>
    
            </tbody>
        </table>
        
        </div>
    </div>

</template>

<script>
import { ref,onMounted } from 'vue';
export default {
    setup(){
        const tasks= ref([]);
        const task_item= ref('');
        const showWarning= ref(false);

        const fetchRecords= async ()=>{
            try{
                
                const response= await fetch("http://127.0.0.1:8000/api/getItems");

                if (response.ok) {
                   
                    const data = await response.json();
                    tasks.value = data.items;
                    console.log(data);
                } else {
                    console.log('Error fetching records:', response.statusText);

                }
            }catch(error){
                console.error("Error:", error);

            }
        };
        onMounted(fetchRecords);

        const submitTask=async ()=>{
           
           /*if (task_item.value.trim() === '') {
            // If the task_item is empty or contains only spaces
            showWarning.value = true; // Show the warning message
            }
            else{
                
                tasks.value.push({
                    id: tasks.value.length + 1,
                    name:task_item.value,
                    status:'',
                    editing:false
                })
                task_item.value=''
                showWarning.value=false
            }*/

            try {
                if (task_item.value.trim() === ''){
                    showWarning.value=true;
                   
                }
                else{

                    const newTask={
                        name: task_item.value,
                        status: 'T'

                    }
                    console.log(newTask)

                    console.log('before fetch api')
                    const response = await fetch("http://127.0.0.1:8000/api/addItem",{
                    method: 'POST',
                    body: JSON.stringify(newTask),
                    headers: {
                    'Content-Type': 'application/json'     //this is necessary , otherwise it won't work
                    }

                    })
                    console.log('after fetch api')
                    
                    if (response.ok){
                        console.log('response ok success')
                        fetchRecords();
                        
                    }
                    else {
                        
                        console.error('Error saving task:', response.statusText);
                        console.log(response)
                    }
                    task_item.value=''
                    showWarning.value=false;
 
            }

               
            } catch (error) {
                console.error('Error saving task:', error);
            }

        };
        const editTask = (todo) => {
        /*const taskId = tasks.value.indexOf(todo);
        if (taskId !== -1) {
            tasks.value[taskId].editing = true;
        }*/

            todo.editing=true;
        }

        const saveTask = async (todo) => {
        /*const taskId = tasks.value.indexOf(todo);
        if (taskId !== -1 && todo.name.trim() !== '') {
            tasks.value[taskId].editing = false;
        }*/

        try {
            if( todo.task.trim() !== '') {
                todo.editing=false

                const id = todo.id
                const response= await fetch("http://127.0.0.1:8000/api/updateItem/"+id,{
                    method: 'PUT',
                    body: JSON.stringify(
                        {
                            name: todo.task,
                            status: todo.status

                        }

                    ),
                    headers: {
                        'Content-Type': 'application/json'     //this is necessary , otherwise it won't work
                    } 
                }
                )

            }
            
        } catch (error) {
            console.error('Error saving task:', error);
        }
        }

        const deleteTask =async (todo) => {
        /*const index = tasks.value.indexOf(todo);
        if (index !== -1) {
            tasks.value.splice(index, 1);
        }*/
        try {
            const id = todo.id
            const response= await fetch("http://127.0.0.1:8000/api/deleteItem/"+id,{
                method: 'DELETE',
                

            })

            if(response.ok){
                fetchRecords();
            }
            else {
                        
                console.error('Error deleting task:', response.statusText);
            }

            
        } catch (error) {
            console.log("error in deleting task")
            
        }


        }

        const updateStatus =async (todo) => {

            try {

                const id = todo.id
                const response= await fetch("http://127.0.0.1:8000/api/updateItem/"+id,{
                    method: 'PUT',
                    body: JSON.stringify(
                        {
                            name: todo.task,
                            status: todo.status

                        }

                    ),
                    headers: {
                        'Content-Type': 'application/json'     //this is necessary , otherwise it won't work
                    } 
                }
                )

                
            } catch (error) {
                console.error('Error saving task:', error);
                
            }
        }

        const deleteAll=() =>{
            tasks.value=[]

        }

        return{tasks, task_item, showWarning, submitTask, editTask, saveTask, deleteTask, deleteAll,updateStatus}
    }
    /*methods:{
        submitTask(){
           // this.tasks.
           if (this.task_item.trim() === '') {
            // If the task_item is empty or contains only spaces
            this.showWarning = true; // Show the warning message
            }
            else{
                
                this.tasks.push({
                    id: this.tasks.length + 1,
                    name:this.task_item,
                    status:'',
                    editing:false
                })
                this.task_item=''
                this.showWarning=false
            }

        },
        editTask(todo){
            const taskId= this.tasks.indexOf(todo)
            this.tasks[taskId].editing=true  //set editing condition true
            
        },
        saveTask(todo){
            console.log('test')
            const taskId = this.tasks.indexOf(todo);
            if (taskId!=-1 && todo.name.trim() !== '') {
                this.tasks[taskId].editing = false;
            }
            console.log(this.tasks)

           
        },
        deleteTask(todo){
           
             console.log(todo);
             this.tasks.splice(this.tasks.indexOf(todo), 1);
        },

        deleteAll(){
            this.tasks=[];
        }
        }*/
}


</script>

<style scoped>
.set1{
    text-align: center;
    margin: 0 auto;
    font-style: italic; 
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    padding-bottom: 15px;
}
.centered-container{
    width: 80%; 
    max-width: 800px;
    margin: 0 auto;
}

.check{
  color: red;
  margin-top: 10px;
}
    

</style>