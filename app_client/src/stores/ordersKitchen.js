import { ref, computed, inject } from 'vue';
import { defineStore } from 'pinia'

export const useOrdersKitchenStore = defineStore('ordersKitchen', () => {
	const socket = inject("socket")
	const axios = inject('axios')
	const toast = inject("toast")

	const ordersKitchen = ref([]);

	/**
	* share information in the app
	**/
	const orderKitchenItems = computed(() => {
		return orderKitchenItems.value.items;
	});

	/**
	* complete order (after payment)
	**/
	async function completeOrder() {
		// Note that when an error occours, the exception should be
		// catch by the function that called the deleteProject
		const response = await axios.post('/ordersKitchen', ordersKitchen)
		order.value = response.data.data;
		socket.emit('ordersKitchenCompleted', response.data.data);
	}

	/**
	* update order status
	**/
	socket.on('orderStatusUpdate', (ordersKitchen) => {
		orderKitchenItems.value.status.push(ordersKitchen);
		toast.info(`The order (#${ordersKitchen.id}) is now on the status ${ordersKitchen.status}!`)
	})
	
	/**
	* remove item from the order
	*
		async function cancelOrder() {
			const response = await axios.post('/ordersKitchen', ordersKitchen)
			ordersKitchen.value = response.data.data;
			socket.emit('orderCancelled', response.data.data);
		}*/

	return {
		ordersKitchen, status, orderKitchenItems, completeOrdersKitchen
	}
})
