import {createRouter, createWebHistory} from 'vue-router';
import {useUserStore} from "@/stores/user";

import HomeView from "../views/HomeView.vue";

// public
import Publicboard from "../views/Board.vue";
// import Publicboard from "../components/publicboard/Publicboard.vue";
import Menus from "../views/Menu.vue";
import Cart from "../views/Cart.vue";
import Checkout from "../views/Checkout.vue";
import OrderDetail from "../views/OrderDetail.vue";

// protected
import PublicBoard from "../views/PublicBoard.vue";
import Employee from "../views/Employee.vue";
import RestaurantBoard from "../views/RestaurantBoard.vue";

import Login from "../components/auth/Login.vue";
import Registration from "../components/auth/Registration.vue";
import ChangePassword from "../components/auth/ChangePassword.vue";
import Users from "../components/users/Users.vue";
import User from "../components/users/User.vue";
import RouteRedirector from "../components/global/RouteRedirector.vue";

// Settings 
import Settings from "../views/Settings.vue";
import Account from "../components/settings/Account.vue";
import Purchases from "../components/settings/Purchases.vue";
import DashboardManager from "../components/settings/DashboardManager.vue";
import UsersAccount from "../components/settings/UsersAccount.vue";
import Products from "../components/settings/Products.vue";
import Orders from "../components/settings/Orders.vue";

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	scrollBehavior(to, from, savedPosition) {
		if (to.hash) {
			return {
				el: to.hash,
				behavior: 'smooth'
			}
		}
		if (savedPosition) {
			return savedPosition
		}
		// always scroll to top
		return { top: 0 }
	},
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
			path: '/publicBoard',
			name: 'PublicBoard',
			component: PublicBoard
		},
		{
			path: '/restaurantboard',
			name: 'RestaurantBoard',
			component: RestaurantBoard
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
		// Settings
		{
			path: '/settings',
			name: 'Settings',
			component: Settings,
			children: [
						{ 
							path: 'account', 
							name: 'Account', 
							component: Account 
						},
						{
							path: 'purchases',
							name: 'Purchases',
							component: Purchases,
						},
						{
							path: 'dashboard-manager',
							name: 'DashboardManager',
							component: DashboardManager,
						},
						{
							path: 'users-account',
							name: 'UsersAccount',
							component: UsersAccount,
						},
						{
							path: 'products',
							name: 'Products',
							component: Products,
						},
						{
							path: 'orders',
							name: 'Orders',
							component: Orders,
						},
						{
							path: 'password',
							name: 'ChangePassword',
							component: ChangePassword
						}
					  ],
		},
	]
})

let handlingFirstRoute = true;

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
