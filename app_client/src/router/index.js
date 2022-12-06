import {createRouter, createWebHistory} from 'vue-router';
import {useUserStore} from "../stores/user.js";

import HomeView from "../views/HomeView.vue";

// public
import Publicboard from "../views/Board.vue";
// import Publicboard from "../components/publicboard/Publicboard.vue";
import Menus from "../views/Menu.vue";
// import Menus from "../components/menu/Menus.vue";
import Cart from "../views/Cart.vue";
import Checkout from "../views/Checkout.vue";
import OrderDetail from "../views/OrderDetail.vue";

// protected
import Dashboard from "../views/Dashboard.vue";
import Kitchens from "../views/Kitchen.vue";
import Employee from "../views/Employee.vue";
import Orders from "../views/Orders.vue";

import Login from "../components/auth/Login.vue";
import Registration from "../components/auth/Registration.vue";
import ChangePassword from "../components/auth/ChangePassword.vue";
import Publicboards from "../components/publicboard/Publicboards.vue";
import Users from "../components/users/Users.vue";
import User from "../components/users/User.vue";
import Kitchen from "../components/kitchen/Kitchen.vue";
import RouteRedirector from "../components/global/RouteRedirector.vue";

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
			props: route => ({redirectTo: route.params.redirectTo})
		},
		// Account for App
		{
			path: '/login',
			name: 'Login',
			component: Login
		},
		{
			path: '/registration',
			name: 'Registration',
			component: Registration
		  },
		{
			path: '/password',
			name: 'ChangePassword',
			component: ChangePassword
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
			props: route => ({id: parseInt(route.params.id)})
		},

		// For Restaurant employees/kitchen
		{
			path: '/dashboard',
			name: 'Dashboard',
			component: Dashboard
		},
		{
			path: '/orders',
			name: 'Orders',
			component: Orders
		},
		{
			path: '/kitchens/current',
			name: 'CurrentKitchens',
			component: Kitchens,
			props: {onlyCurrentOrders: true, ordersTitle: 'Current Kitchens'}
		},
		{
			path: '/kitchens',
			name: 'Kitchens',
			component: Kitchens,
		},
		{
			path: '/publicboards',
			name: 'Publicboards',
			component: Publicboards,
		},

		// Display restaurant Items
		{
			path: '/menus',
			name: 'Menus',
			component: Menus,
		},
		// Check bag with items
		{
			path: '/bag',
			name: 'Bag',
			component: Cart,
		},
		// Pay Order
		{
			path: '/checkout',
			name: 'Checkout',
			component: Checkout,
			props: route => ({id: parseInt(route.params.id)})
		},
		// After buy (detail)
		{
			path: '/order/:id',
			name: 'OrderDetail',
			component: OrderDetail,
			props: route => ({id: parseInt(route.params.id)})
		},

		{
			path: '/reports',
			name: 'Reports',
			component: () => import('../views/Board.vue')
		},

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
	/*if (!userStore.user) {
		next({name: 'Login'})
		return
	}*/
	if (to.name == 'Reports') {
		if (userStore.user.type != 'A') {
			next({name: 'home'})
			return
		}
	}
	if (to.name == 'User') {
		if ((userStore.user.type == 'A') || (userStore.user.id == to.params.id)) {
			next()
			return
		}
		next({name: 'home'})
		return
	}
	next()
})

export default router
