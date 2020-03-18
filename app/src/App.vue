<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    <Media :media="this.media"></Media>
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'
import Media from "./components/Media";
import axios from 'axios';

export default {
  name: 'App',
  components: {
    Media,
    HelloWorld
  },
  data() {
    return {
      apiUrl: 'http://localhost:8080/v1',
      fields: ['src','username','type'],
      media: {},
    }
  },
  methods: {
    getMedia(id, fields) {
      let expand = fields.length ? `?expand=${fields.join()}` : '';

      axios
        .get(`${this.apiUrl}/media/${id}${expand}`)
        .then(response => {
          this.media = response.data;
        })
        .catch(error => console.log(error));
    }
  },
  created() {
    this.getMedia(1, this.fields);
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
