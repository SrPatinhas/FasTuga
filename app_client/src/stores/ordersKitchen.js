import {ref, computed, inject} from 'vue';
import {defineStore} from 'pinia'

export const useOrdersKitchenStore = defineStore('ordersKitchen', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

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
		// TODO update single item
		//order.value = response.data.data;
		socket.emit('ordersKitchenCompleted', response.data.data);
	}

	/**
	 * update order status
	 **/
	socket.on('orderStatusUpdate', (orderKitchen) => {
		ordersKitchen.value.status.push(orderKitchen);
		toast.info(`The order (#${orderKitchen.id}) is now on the status ${orderKitchen.status}!`)
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
		ordersKitchen, orderKitchenItems
	}
})
