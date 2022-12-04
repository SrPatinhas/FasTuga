import { ref, computed, inject } from 'vue';
import { defineStore } from 'pinia'

export const useOrdersStore = defineStore('orders', () => {
	const socket = inject("socket")
	const axios = inject('axios')
	const toast = inject("toast")

	const order = ref({
		id: 0,
		status: undefined,
		items: []
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
		return totalCost.toFixed(2) + "€";
	});

	const orderStatus = computed(() => {
		return status.value.at(-1);
	})


	/**
	 * add item or quantity to the order
	 **/
	function addItemToOrder(addItem) {
		let idx = order.value.items.findIndex((item) => item.id === addItem.id)
		if (idx >= 0) {
			order.value.items[idx].count += 1;
		} else {
			order.value.items.push(addItem);
		}
	}
	/**
	 * remove item or quantity from the order
	 **/
	function updateQuantityItemOnOrder(itemUpdate, quantity) {
		let idx = order.value.items.findIndex((item) => item.id === itemUpdate.id);
		if (idx >= 0) {
			order.value.items[idx].count += quantity;
			if(order.value.items[idx].count === 0) {
				deleteItemOnOrder(itemUpdate);
			}
		}
	}
	/**
	 * remove item from the order
	 **/
	function deleteItemOnOrder(deleteItem) {
		let idx = order.value.items.findIndex((item) => item.id === deleteItem.id)
		if (idx >= 0) {
			order.value.items.splice(idx, 1)
		}
	}
	/**
	 * remove item from the order
	 **/
	function cancelOrder() {
		order.value = {
			id: 0,
			status: undefined,
			items: []
		};
		status.value = [];
	}

	/**
	 * complete order (after payment)
	 **/
	async function completeOrder() {
		// Note that when an error occours, the exception should be
		// catch by the function that called the deleteProject
		const response = await axios.post('/order', order)
		order.value = response.data.data;
		socket.emit('orderCompleted', response.data.data);
	}
	/**
	 * update order status
	 **/
	socket.on('orderStatusUpdate', (order) => {
		status.value.push(order);
		toast.info(`The order (#${order.id}) is now on the status ${order.status}!`)
	})

	return {
		order, status,
		orderItems, totalItems, totalOrderCost, orderStatus,
		addItemToOrder, updateQuantityItemOnOrder, deleteItemOnOrder, cancelOrder,
		completeOrder
	}
})
