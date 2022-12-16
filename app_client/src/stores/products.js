import {ref, computed, inject} from 'vue';
import {defineStore} from 'pinia'

export const useProductsStore = defineStore('products', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

	const products = ref([]);

	/**
	 * share information in the app
	 **/
	const productsItems = computed(() => {
		return productsItems.value.items;
	});

	/**
	 * product id
	 **/
	const productId = computed(() => {
		return products.value?.id ?? -1
	});

	
    async function loadProducts() {
        try {
            const response = await axios.get('products')
            products.value = response.data.data
            return products.value
        } catch (error) {
            clearProducts()
            throw error
        }
    }

	function clearProjects() {
        projects.value = []
    }

	/**
	 * update product status
	 **/
	socket.on('productStatusUpdate', (product) => {
		product.value.status.push(product);
		toast.info(`The order (#${product.id}) is now on the status ${product.status}!`)
	})

	/**
	 * remove item from the order
	 */
		async function deleteProduct() {
			const response = await axios.post('/product', product)
			products.value = response.data.data;
			socket.emit('productdeleted', response.data.data);
		}

	return {
		products, productsItems, loadProducts, clearProjects, deleteProduct
	}
})
