import { ref, computed, inject } from 'vue';
import { defineStore } from 'pinia'

export const useOrdersStore = defineStore('dashboard', () => {
	const socket = inject("socket")
	const axios = inject('axios')
	const toast = inject("toast")

	const order = ref({
		id: 0,
		status: undefined,
		notes: undefined,
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
	});

	const orderPoints = computed(() => {
		let totalCost = 0;
		order.value.items.forEach( item => totalCost += item.price * item.count);
		const points = totalCost / 10;
		return Math.floor(points);
	});
	/**
	 * order notes for kitchen
	 **/
	function orderNotes(note) {
		order.value.notes = note;
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
		orderItems, totalItems, totalOrderCost, orderStatus, orderPoints,
		addItemToOrder, updateQuantityItemOnOrder, deleteItemOnOrder, cancelOrder, orderNotes,
		completeOrder
	}
})
