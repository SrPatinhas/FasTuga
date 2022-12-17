import {ref, computed, inject} from 'vue';
import {defineStore} from 'pinia'

export const useProductsStore = defineStore('products', () => {
	const socket = inject("socket");
	const axios = inject('axios');
	const toast = inject("toast");

	const products = ref([
		{
			id: 12,
			name: '7-Up',
			image: 'KPNzRRCrbwnrxbgk.jpg',
			price: 1.4,
			type: 'drink',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 123,
			name: 'Água das Pedras',
			image: 'KPNzRRCrbwnrxbgk.jpg',
			price: 1.4,
			type: 'drink',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
		{
			id: 121,
			name: 'Aletria',
			image: 'QSJ8nyCgMiw40EkV.jpg',
			price: 3.40,
			type: 'dessert',
			description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
		},
	]);

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

	function clearProducts() {
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
	function deleteProductOnArray(deleteProduct) {
        let idx = products.value.findIndex((t) => t.id === deleteProduct.id);
        if (idx >= 0) {
            products.value.splice(idx, 1);
        }
    }

	/**
	 * add new product
	 */
	socket.on('newProduct', (product) => {
        products.value.push(product);
        toast.success(`A new product was added (#${product.id} : ${product.name})`);
    }) ;

	/**
	 * delete new product
	 */
    socket.on('deleteProduct', (product) => {
        deleteProductOnArray(product);
        toast.info(`The product (#${product.id} : ${product.name}) was deleted!`);
    });

    

	return {
		products, productsItems, loadProducts, clearProjects, deleteProduct
	}
})
