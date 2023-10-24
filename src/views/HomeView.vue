<script>

import { ref } from 'vue';
export default{

  name: 'home',
  setup() {
    console.log('setup')

    const name = ref('Sri lanka')
    const location= ref('Asia')
    const age= ref(30)
    let test= 'hello'

    const names= ref(['mario', 'france', 'peter', 'tom','bell'])

    const handleClick = () => {
      console.log('clicked me')
      location.value= 'europe'
      //test='oi'
    }

    const plusAge=()=>{
      console.log('clicked age')
      age.value++

    }
    const decAge=()=>{
      age.value--
    }

    return {name, location,test, handleClick, plusAge, age, names, decAge}

    

  }
}
</script>

<template>
  <main>
  
  </main>
  <div class="home">
    <img alt="Vue logo" class="logo" src="../assets/logo.svg" width="200" height="200" />
      <h1>Welcome to Vue.js Web App</h1>
     <h2> This is the home page</h2>
     <p>This is {{ name }} and the location is {{ location }} and age is {{ age }}  </p>
     <button @click="handleClick">click me</button>
     
     <button @click="plusAge">clicke here to increase age</button>
     <button @click="decAge">Click here to decrease age</button>
     <div v-for="name in names" :key="name">
      <p>{{ name }}</p>
     </div>
  </div>
</template>
<style scoped>
/*.home{
  text-align: center;
  margin: 0 auto; 
}*/

</style>

