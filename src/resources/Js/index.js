window.Vue = require('vue')
import vuetify from '../Plugins/vuetify' // path to vuetify export
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// import App from "./components/App.vue";

Vue.component('example-component', require('./components/exampleComponent.vue').default);
Vue.component('nav-component', require('./components/App/NavComponent.vue').default);
Vue.component('profile-component', require('./components/User/ProfileComponent.vue').default);


Vue.filter('capitalize', function (value) {
  if (!value) return ''
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})
new Vue({
  // render: (h) => h(App),
  el:"#app",
  vuetify
})