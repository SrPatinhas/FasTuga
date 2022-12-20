import {createRouter, createWebHistory} from 'vue-router';
import {useUserStore} from "@/stores/user";

// public
import HomeView from "../views/HomeView.vue";
import Menus from "../views/Menu.vue";
import Cart from "../views/Cart.vue";
import Checkout from "../views/Checkout.vue";
import OrderDetail from "../views/OrderDetail.vue";
import PublicBoard from "../views/PublicBoard.vue";
// Auth
import Login from "../views/auth/Login.vue";
import Registration from "../views/auth/Registration.vue";
import ChangePassword from "../views/auth/ChangePassword.vue";
// protected
import RestaurantBoard from "../views/RestaurantBoard.vue";
import Users from "../components/users/Users.vue";
import User from "../components/users/User.vue";
import RouteRedirector from "../components/global/RouteRedirector.vue";
// Settings 
import Settings from "../views/Settings.vue";
import Account from "../components/settings/Account.vue";
import Purchases from "../components/settings/Purchases.vue";
// Manager
import DashboardManager from "../components/settings/DashboardManager.vue";
import UsersAccount from "../components/settings/UsersAccount.vue";
import Products from "../components/settings/Products.vue";
import Orders from "../components/settings/Orders.vue";

//const userStore = useUserStore();

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
		return {top: 0}
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
					path: 'password',
					name: 'ChangePassword',
					component: ChangePassword
				},
				{
					path: 'purchases',
					name: 'Purchases',
					component: Purchases,
					meta: {
						requiresAuth: true,
						role: 'c'
					}
				},
				{
					path: 'dashboard-manager',
					name: 'DashboardManager',
					component: DashboardManager,
					meta: {
						requiresAuth: true,
						role: 'm'
					}
				},
				{
					path: 'users-account',
					name: 'UsersAccount',
					component: UsersAccount,
					meta: {
						requiresAuth: true,
						role: 'm'
					}
				},
				{
					path: 'products',
					name: 'Products',
					component: Products,
					meta: {
						requiresAuth: true,
						role: 'm'
					}
				},
				{
					path: 'orders',
					name: 'Orders',
					component: Orders,
					meta: {
						requiresAuth: true,
						role: 'm'
					}
				}
			],
			meta: {
				requiresAuth: true
			}
		},
	]
})

let handlingFirstRoute = true;

router.beforeEach((to, from, next) => {
	const userStore = useUserStore();
	if(!userStore.isAuthenticated){
		userStore.restoreToken();
	}
	if ( to.meta.requiresAuth && !userStore.isAuthenticated ) {
		// this route requires auth, check if logged in
		// if not, redirect to login page.
		next({ name: 'Login' });
		return
	} else {
		// if they don't have enought permissions
		if ( ( to.meta.meta == 'c' && !userStore.isCustomer ) || ( to.meta.meta == 'm' && !userStore.isManager) ) {
			next({ name: 'Menus' });
			return
		}
	}

	if (handlingFirstRoute) {
		handlingFirstRoute = false
		next({name: 'Redirect', params: {redirectTo: to.fullPath}})
		return
	} else if (to.name == 'Redirect') {
		next()
		return
	}
	if ((to.name == 'Login') || (to.name == 'home')) {
		next()
		return
	}
	/*if (!userStore.user) {
		next({name: 'Login'})
		return
	}*/
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
