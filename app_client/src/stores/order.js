import {ref, computed, inject} from 'vue';
import { defineStore } from 'pinia'
import utils from "@/utils/utils";
import {useRoute} from "vue-router";
import {useUserStore} from "@/stores/user";

export const useOrdersStore = defineStore('orders', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

	const route = useRoute();
	const userStore = useUserStore();

	// Current bag/cart for user
	const order = ref({
		id: 0,
		notes: undefined,
		items: [],
		checkout: {}
	});
	// Detail of Order for timeline
	const orderDetail = ref({
		id: 0,
		user_id: undefined,
		status: undefined,
		notes: undefined,
		items: [],
		checkout: {}
	});

	/**
	 * share information in the app
	 * Order in the Bag
	 **/
	const orderItems = computed(() => {
		return order.value.items;
	});

	const totalItems = computed(() => {
		let totalItems = 0;
		order.value.items.forEach( item => totalItems += item.quantity);
		return totalItems;
	});

	const totalOrderCost = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.quantity);
		return totalCost.toFixed(2);
	});

	const orderPoints = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.quantity);
		const points = totalCost / 10;
		return Math.floor(points);
	});

	const orderPointsDiscount = computed(() => {
		return order.value.checkout.discountPoints / 2;
	});

	/*
	* Order detail, already paid
	**/
	const totalOrderDetailItems = computed(() => {
		let totalItems = 0;
		orderDetail.value.items.forEach( item => totalItems += item.quantity);
		return totalItems;
	});

	const totalOrderDetailCost = computed(() => {
		let totalCost = 0;
		orderDetail.value.items.forEach( item => totalCost += item.price * item.quantity);
		return totalCost.toFixed(2);
	});
	//- The registered customer will get
	//- 1 point for each 10 € spent on one order
	//- (e.g., orders with total = 20,5€ or total = 29,5€ will get 2 points; total = 9,5€ will get 0 points)
	//- points are gained on one order only
	//- values spent on several orders are not accumulated
	//(if a customer makes 20 orders of 9€ each, he will have 0 points)

	/**
	 * order notes for kitchen
	 **/
	function orderNotes(note) {
		order.value.notes = note;
		updateBagLocalStorage();
	}

	/**
	 * add item or quantity to the order
	 **/
	function addItemToOrder(addItem) {
		if(addItem.type === 'hot dish') {
			order.value.items.push(addItem);
		} else {
			let idx = order.value.items.findIndex((item) => item.id === addItem.id)
			if (idx >= 0) {
				order.value.items[idx].quantity += 1;
			} else {
				order.value.items.push(addItem);
			}
		}
		updateBagLocalStorage();
	}
	/**
	 * remove item or quantity from the order
	 **/
	function updateQuantityItemOnOrder(itemUpdate, quantity) {
		let idx = order.value.items.findIndex((item) => item.id === itemUpdate.id);
		if (idx >= 0) {
			if(order.value.items[idx].quantity > 1 || quantity === 1) {
				order.value.items[idx].quantity += quantity;
				updateBagLocalStorage();
			}
		}
	}
	/**
	 * remove item from the order
	 **/
	function deleteItemOnOrder(deleteItem) {
		let idx = order.value.items.findIndex((item) => item.id === deleteItem.id)
		if (idx >= 0) {
			order.value.items.splice(idx, 1);
			utils.debounce(() => updateBagLocalStorage());
		}
	}
	/**
	 * Cancel an order
	 **/

	function cancelOrder() {
		clearBag();
	}

	function clearOrderDetail() {
		orderDetail.value = {};
		sessionStorage.removeItem('orderDetail');
	}

	function clearBag() {
		order.value = {
			id: 0,
			user_id: undefined,
			status: undefined,
			notes: undefined,
			items: [],
			checkout: {}
		};
		sessionStorage.removeItem('order');
	}
	// This will be used when a user logs out
	function clearOrderInfo(){
		clearBag();
		clearOrderDetail();
	}

	/**
	 * complete order (after payment)
	 **/
	async function completeOrder(checkout) {
		delete checkout.loading;
		order.value.checkout = checkout;
		let url = '/orders/payment';
		if(userStore.isGuest){
			url = '/orders/guest/payment';
		}
		const response = await axios.post(url, order.value);
		if(response.data.data?.id){
			orderDetail.value = response.data.data;
			socket.emit('orderNew', order.value);
			clearBag();
			return true;
		}
		return false;
	}
	async function udpateOrderDetail() {
		let orderId = 0;
		if(orderDetail.value.id !== 0) {
			orderId = orderDetail.value.id;
		} else {
			orderId = route.params.id;
		}
		if(orderId !== undefined) {
			const response = await axios.get('orders/' + orderId);
			if (response.data.data?.id) {
				orderDetail.value = response.data.data;
			}
		} else {
			orderDetail.value = [];
		}
	}

	/**
	 * Local storage order (Bag) to keep data opn page refresh
	 **/
	function updateBagLocalStorage() {
		sessionStorage.setItem('order', JSON.stringify(order.value));
	}

	function restoreBagLocalStorage() {
		let storedOrder = sessionStorage.getItem('order');
		if(storedOrder) {
			order.value = JSON.parse(storedOrder);
		}
	}

	/**
	 * Local storage orderDetail (Checkout) to keep data opn page refresh
	 **/
	function updateOrderDetailLocalStorage() {
		sessionStorage.setItem('orderDetail', JSON.stringify(orderDetail.value));
	}

	function restoreOrderDetailLocalStorage() {
		let storedOrder = sessionStorage.getItem('orderDetail');
		if(storedOrder) {
			orderDetail.value = JSON.parse(storedOrder);
		}
	}

	/**
	 * Local storage restore. orderDetail (Checkout) and order (Bag)
	 **/
	function restoreLocalStorage(){
		restoreBagLocalStorage();
		restoreOrderDetailLocalStorage();
	}

	/**
	 * update order status
	 **/
	socket.on('orderStatusUpdate', (order) => {
		udpateOrderDetail();
		toast.info(`The order (#${order.id}) is now on the status ${order.status}!`)
	});

	return {
		order, orderDetail, orderItems, totalItems, totalOrderCost, orderPoints, orderPointsDiscount,
		totalOrderDetailItems, totalOrderDetailCost,
		addItemToOrder, updateQuantityItemOnOrder, deleteItemOnOrder, cancelOrder,
		completeOrder, restoreLocalStorage, clearOrderInfo, udpateOrderDetail
	}
})
