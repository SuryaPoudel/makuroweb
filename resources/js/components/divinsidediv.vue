<template>
    <div>
    <ul>
      <li v-for="(input, index) in inputs">
        <input type="text" :id="index" v-model="input.one"> - {{ input.one }}  
        <input type="text" v-model="input.two"> - {{ input.two }}
        <button @click="deleteRow(index)">Delete</button>
      </li>
    </ul>
    
    <button @click="addRow">Add row</button>
    
    </div>
</template>
<script>
export default {
     data () {
    return {
    inputs: []
  }},
  methods: {
    addRow() {
      this.inputs.push({
        one: 'ds',
        two: ''
      })
    },
    deleteRow(index) {
      this.inputs.splice(index,1)
    }
  }
}
</script>

