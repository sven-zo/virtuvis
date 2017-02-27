import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import FishDetail from '@/components/FishDetail'
import Settings from '@/components/Settings'
import AddRod from '@/components/AddRod'

Vue.use(Router)

export default new Router({
  routes: [
      { path: '/', component: Home },
      { path: '/fish', component: FishDetail },
      { path: '/settings', component: Settings },
      { path: '/addrod', component: AddRod }
  ]
})
