window.Vue = require('vue')
import vuetify from '../Plugins/vuetify' // path to vuetify export

// import App from "./components/App.vue";

Vue.component('example-component', require('./components/exampleComponent.vue').default);

new Vue({
  // render: (h) => h(App),
  el:"#app",
  vuetify,
})