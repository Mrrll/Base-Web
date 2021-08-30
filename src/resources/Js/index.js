window.Vue = require('vue')
import vuetify from '../Plugins/vuetify' // path to vuetify export

// import App from "./components/App.vue";

Vue.component('App', require('./components/App.vue').default);
Vue.component('nav-component', require('./components/NavComponent.vue').default);

new Vue({
  // render: (h) => h(App),
  el:"#app",
  vuetify,
})