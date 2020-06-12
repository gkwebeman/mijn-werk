<template>
  <div class="hello">
    <form>
        <div class="form-group">
          <p>
              Title
          </p>
           
          <input type="text" id="inputTitleMovie" v-model="title" placeholder="Title">  
        </div>
        <p>
          <button type="submit" class="btn btn-primary" @click="search">Search</button>
        </p>
    </form>
  </div>
</template>

<script>
export default {
  name: 'MovieFormComponent',
  props: {
    msg: String
  },
  data() {
      return {
          key: 'value',
          title:'',
      }
  },
  methods: {
      search(ev){
          ev.preventDefault();
          
          let data = {
              title: this.title,
          };

          this.$emit("getData", data);
      },

  },
  mounted(){
    
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
