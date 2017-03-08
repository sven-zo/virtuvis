import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/home/Home'
import FishDetail from '@/components/fish/FishDetail'
import Settings from '@/components/settings/Settings'
import AddRod from '@/components/addrod/AddRod'

Vue.use(Router)

export default new Router({
  routes: [
      { path: '/', component: Home },
      { path: '/fish', component: FishDetail },
      { path: '/settings', component: Settings },
      { path: '/addrod', component: AddRod }
  ]
})
