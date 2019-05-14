
require('./bootstrap');


window.Vue = require('vue');

window.VueRouter=require('vue-router').default;

window.Axios=require('axios').default;

import BootstrapVue from 'bootstrap-vue'
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(BootstrapVue);
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );

import { Form } from 'bootstrap-vue/es/components';

Vue.use(Form);
Vue.use(VueRouter)

var protocol = location.protocol;
var slashes = protocol.concat("//");
var host = slashes.concat(window.location.hostname)+":8000";
window.hostname=host;
window.isLoading=false;


const routes = [
   { path: '/', component: require('./components/dashboard.vue')},
  { path: '/dashboard', component: require('./components/dashboard.vue')},
  { path: '/slider', component: require('./components/slider.vue')},
  { path: '/sliders', component: require('./components/sliders.vue')},
  { path: '/categories', component: require('./components/categories.vue') },
  { path: '/addcategory', component: require('./components/addcategory.vue') },
  { path: '/addnewpage', component: require('./components/addnewpage.vue') },
  { path: '/updatepage', component: require('./components/updatepage.vue') },
  { path: '/loader', component: require('./components/loader.vue') },
  { path: '/updatecategory/:id', component: require('./components/updatecategory.vue') },
  { path: '/updatepage/:id', component: require('./components/updatepage.vue') },
  { path: '/allpages', component: require('./components/allpages.vue') },
  { path: '/post', component: require('./components/post.vue') },
  { path: '/posts', component: require('./components/posts.vue') },
  { path: '/addgallery', component: require('./components/addgallery.vue') },
  { path: '/gallery', component: require('./components/gallery.vue') },
  { path: '/header', component: require('./components/header.vue') },
  { path: '/popup', component: require('./components/popup.vue') },
  { path: '/footer', component: require('./components/footer.vue') },
  { path: '/topfooter', component: require('./components/topfooter.vue') },
  { path: '/elements', component: require('./components/elements.vue') },
  { path: '/div', component: require('./components/divinsidediv.vue') },
  { path: '/users', component: require('./components/users.vue') },
  { path: '/user', component: require('./components/user.vue') },
  // { path: '/logout', component: require('./components/logout.vue') },
  { path: '/front', component: require('./components/front.vue') },
  { path: '/user/:id', component: require('./components/user.vue') },
  { path: '/post/:id', component: require('./components/post.vue') },
  { path: '/addgallery/:id', component: require('./components/addgallery.vue') },
  { path: '/slider/:id', component: require('./components/slider.vue') },
  { path: '/topfooter/:id', component: require('./components/topfooter.vue') },
  { path: '/dashboard/:id', component: require('./components/dashboard.vue')},


]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

//const router= new VueRouter({mode:'history',routes:routes});
const app = new Vue({
    el: '#app',
    router

});
