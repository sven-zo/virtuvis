//Import Vue router
Vue.use(VueRouter);

//Set paths
const routes = [
    { path: '/', component: home },
    { path: '/fish', component: fishDetail }
];

//Set up router
//Not using shorthand because we're using the old ECMAscript.
const router = new VueRouter({
   routes: routes
});

//Initialise app
const app = new Vue({
    router: router
}).$mount('#app');