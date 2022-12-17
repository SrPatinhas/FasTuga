import {createRouter, createWebHistory} from 'vue-router';
import {useUserStore} from "@/stores/user";

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
import PublicBoard from "../views/PublicBoard.vue";
import Employee from "../views/Employee.vue";
import Dashboard from "../views/Dashboard.vue";

import Login from "../components/auth/Login.vue";
import Registration from "../components/auth/Registration.vue";
import ChangePassword from "../components/auth/ChangePassword.vue";
import Users from "../components/users/Users.vue";
import User from "../components/users/User.vue";
import RouteRedirector from "../components/global/RouteRedirector.vue";

// Settings 
import Settings from "../views/Settings.vue";
import SettingsAccount from "../views/SettingsAccount.vue";
import SettingsPurchases from "../views/SettingsPurchases.vue";
import SettingsDashboardManager from "../views/SettingsDashboardManager.vue";
import SettingsUsersAccount from "../views/SettingsUsersAccount.vue";
import SettingsMenu from "../views/SettingsMenu.vue";
import SettingsCancellingOrder from "../views/SettingsCancellingOrder.vue";

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
			path: '/publicBoard',
			name: 'PublicBoard',
			component: PublicBoard
		},
		{
			path: '/dashboard',
			name: 'Dashboard',
			component: Dashboard
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
		}, 
		{
			path: '/settingsaccount',
			name: 'SettingsAccount',
			component: SettingsAccount,
		},
		{
			path: '/settingspurchases',
			name: 'SettingsPurchases',
			component: SettingsPurchases,
		},
		{
			path: '/settingsdashboardmanager',
			name: 'SettingsDashboardManager',
			component: SettingsDashboardManager,
		},
		{
			path: '/settingsusersaccount',
			name: 'SettingsUsersAccount',
			component: SettingsUsersAccount,
		},
		{
			path: '/settingsmenu',
			name: 'SettingsMenu',
			component: SettingsMenu,
		},
		{
			path: '/settingscancellingorder',
			name: 'SettingsCancellingOrder',
			component: SettingsCancellingOrder,
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
