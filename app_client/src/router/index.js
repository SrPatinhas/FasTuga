import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from "../stores/user.js"

import HomeView from '../views/HomeView.vue'

import Dashboard from "../components/Dashboard.vue"
import Login from "../components/auth/Login.vue"
import ChangePassword from "../components/auth/ChangePassword.vue"
import Kitchens from "../components/kitchen/Kitchens.vue"
import Menus from "../components/menu/Menus.vue"
import Orders from "../components/order/Orders.vue"
import Publicboards from "../components/publicboard/Publicboards.vue"
import Users from "../components/users/Users.vue"
import User from "../components/users/User.vue"
import Kitchen from "../components/kitchen/Kitchen.vue"
import Menu from "../components/menu/Menu.vue"
import Order from "../components/order/Order.vue"
import Publicboard from "../components/publicboard/Publicboard.vue"
import RouteRedirector from "../components/global/RouteRedirector.vue"

/*OK-menu  OK-orders  OK-public-board  OK-kitchen  OK-users */

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/redirect/:redirectTo',
      name: 'Redirect',
      component: RouteRedirector,
      props: route => ({ redirectTo: route.params.redirectTo})   
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/password',
      name: 'ChangePassword',
      component: ChangePassword
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard
    },
    {
      path: '/menus',
      name: 'Menus',
      component: Menus,
    },
    {
      path: '/kitchens/current',
      name: 'CurrentKitchens',
      component: Kitchens,
      props: { onlyCurrentOrders: true, ordersTitle: 'Current Kitchens' }
    },
    {
      path: '/kitchens',
      name: 'Kitchens',
      component: Kitchens,
    },
    {
      path: '/kitchens/new',
      name: 'NewKitchen',
      component: Kitchen,
      props: { id: -1 }
    },
    {
      path: '/kitchens/:id',
      name: 'Kitchen',
      component: Kitchen,
      props: route => ({ id: parseInt(route.params.id) })     
    },
    {
      path: '/publicboards/current',
      name: 'CurrentPublicboards',
      component: Publicboards,
      props: { onlyCurrentKitchens: true, publicboardsTitle: 'Current Publicboards' }
    },
    {
      path: '/publicboards',
      name: 'Publicboards',
      component: Publicboards,
    },
    {
      path: '/publicboards/new',
      name: 'NewPublicboard',
      component: Publicboard,
      props: { id: -1 }
    },
    {
      path: '/publicboards/:id',
      name: 'Publicboard',
      component: Publicboard,
      props: route => ({ id: parseInt(route.params.id) })     
    },
    {
      path: '/Menus/current',
      name: 'CurrentMenus',
      component: Menus,
      props: { onlyCurrentMenus: true, MenusTitle: 'Current Menus' }
    },
    {
      path: '/menus',
      name: 'Menus',
      component: Menus,
    },
    {
      path: '/menus/new',
      name: 'NewMenu',
      component: Menu,
      props: { id: -1 }
    },
    {
      path: '/menus/:id',
      name: 'Menu',
      component: Menu,
      props: route => ({ id: parseInt(route.params.id) })     
    },
    {
      path: '/users',
      name: 'Users',
      component: Users,
    },
    {
      path: '/users/:id',
      name: 'User',
      component: User,
      //props: true
      // Replaced with the following line to ensure that id is a number
      props: route => ({ id: parseInt(route.params.id) })
    }, 
    /*{
      path: '/projects/:id/tasks',
      name: 'ProjectTasks',
      component: ProjectTasks,
      props: route => ({ id: parseInt(route.params.id) })
    },
    {
      path: '/projects/:id/tasks/new',
      name: 'NewTaskOfProject',
      component: Task,
      props: route => ({ id:-1, fixedProject:  parseInt(route.params.id) })
    },*/
    {
      path: '/orders/current',
      name: 'CurrentOrders',
      component: Orders,
      props: { onlyCurrentOrders: true, ordersTitle: 'Current Orders' }
    },
    {
      path: '/orders/new',
      name: 'NewOrder',
      component: Order,
      props: { id: -1 }
    },
    {
      path: '/orders/:id',
      name: 'Order',
      component: Order,
      props: route => ({ id: parseInt(route.params.id) })    
    },
    {
      path: '/reports',
      name: 'Reports',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }
  ]
})

let handlingFirstRoute = true

router.beforeEach((to, from, next) => {  
  if (handlingFirstRoute) {
    handlingFirstRoute = false
    next({name: 'Redirect', params: {redirectTo: to.fullPath}})
    return
  } else if (to.name == 'Redirect') {
    next()
    return
  }
  const userStore = useUserStore()  
  if ((to.name == 'Login') || (to.name == 'home')) {
    next()
    return
  }
  if (!userStore.user) {
    next({ name: 'Login' })
    return
  }
  if (to.name == 'Reports') {
    if (userStore.user.type != 'A') {
      next({ name: 'home' })
      return
    }
  }
  if (to.name == 'User') {
    if ((userStore.user.type == 'A') || (userStore.user.id == to.params.id)) {
      next()
      return
    }
    next({ name: 'home' })
    return
  }
  next()
})

export default router
