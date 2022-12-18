import {ref, computed, inject} from 'vue';
import { defineStore } from 'pinia'
import utils from "@/utils/utils";

export const useOrdersStore = defineStore('orders', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

	const orders = ref({});


	const order = ref({
		id: 0,
		user_id: undefined,
		status: undefined,
		notes: undefined,
		items: [],
		checkout: {}
	});

	const orderDetail = ref({
		id: 0,
		user_id: undefined,
		status: undefined,
		notes: undefined,
		items: [],
		checkout: {}
	});

	const status = ref([]);

	/**
	 * share information in the app
	 **/
	const orderItems = computed(() => {
		return order.value.items;
	});

	const totalItems = computed(() => {
		let totalItems = 0;
		order.value.items.forEach( item => totalItems += item.count);
		return totalItems;
	});

	const totalOrderCost = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.count);
		return totalCost.toFixed(2);
	});

	const orderStatus = computed(() => {
		return status.value.at(-1);
	});

	const orderPoints = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.count);
		const points = totalCost / 10;
		return Math.floor(points);
	});

	const orderPointsDiscount = computed(() => {
		return order.value.checkout.discountPoints / 2;
	});


	const totalOrderDetailItems = computed(() => {
		let totalItems = 0;
		order.value.items.forEach( item => totalItems += item.count);
		return totalItems;
	});

	const totalOrderDetailCost = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.count);
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
				order.value.items[idx].count += 1;
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
			if(order.value.items[idx].count > 1 || quantity === 1) {
				order.value.items[idx].count += quantity;
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
		status.value = [];
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
		status.value = [];
		sessionStorage.removeItem('order');
	}

	/**
	 * complete order (after payment)
	 **/
	async function completeOrder(checkout) {
		order.value.checkout = checkout;
		// Note that when an error occours, the exception should be
		// catch by the function that called the deleteProject
		//const response = await axios.post('/order', order);
		if(true){// response.data.data.isPaid){
			//orderDetail.value = response.data.data;
			socket.emit('orderNew', order.value);//response.data.data);
			//status.value = response.data.data.status;
			clearBag();
			return true;
		}
		return false;
	}

	async function fetchOrders(page = 1) {
        try {
            const response = await axios.get('/orders?page=' + page);
            orders.value = response.data;
            return orders.value;
        } catch (error){
			orders.value = {};
            throw error;
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
		status.value.push(order);
		toast.info(`The order (#${order.id}) is now on the status ${order.status}!`)
	});

	return {
		order, status, orders,
		orderItems, totalItems, totalOrderCost, orderStatus, orderPoints, orderPointsDiscount,
		totalOrderDetailItems, totalOrderDetailCost,
		addItemToOrder, updateQuantityItemOnOrder, deleteItemOnOrder, cancelOrder, orderNotes,
		completeOrder, restoreLocalStorage, fetchOrders
	}
})
