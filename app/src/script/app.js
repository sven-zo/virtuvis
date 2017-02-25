//Import Vue router
Vue.use(VueRouter);

//Set paths
const routes = [
    { path: '/', component: home },
    { path: '/fish', component: fishDetail },
    { path: '/settings', component: settings },
    { path: '/addrod', component: addRod }
];

//Set up router
//Not using shorthand because we're using the old ECMAscript.
const router = new VueRouter({
   routes: routes
});

//Initialise app
const app = new Vue({
    router: router,
    data: {
        lang: 'loading'
    },
    methods: {
        getSettings: function(){
            console.log('Getting language...');
            minAjax({
                url:'dummy-server/settings.json',
                type:'POST',
                success: function(data){
                    var result = JSON.parse(data);
                    console.log('Language:',result.lang);
                    console.log('Setting language...');
                    app.lang = result.lang;
                }
            });
        }
    }
}).$mount('#app');

app.getSettings();