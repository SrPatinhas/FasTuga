import { ref, computed, inject } from 'vue';
import { defineStore } from 'pinia';

export const useMenuStore = defineStore('menu', () => {
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
            id: 142,
            name: 'Água do Luso',
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
        {
            id: 152,
            name: 'Alheira',
            image: 'jBMVpJbZ8uJMRE8N.jpg',
            price: 9.90,
            type: 'hot dish',
            description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
        },
        {
            id: 125,
            name: 'Arroz de Marisco',
            image: 'RmoYdKAGJzm10l9J.jpg',
            price: 9.90,
            type: 'hot dish',
            description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
        },
        {
            id: 212,
            name: 'Salada decNoodles',
            image: 'ulSMYjBpImeqSSEE.jpg',
            price: 9.90,
            type: 'cold dish',
            description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
        },
        {
            id: 126,
            name: 'Salada Fria de Frango',
            image: 'Vt0rlSQBE3jfJniu.jpg',
            price: 4.00,
            type: 'cold dish',
            description: "Alice dodged behind a great deal to come once a week: HE taught us Drawling, Stretching, and Fainting in Coils.' 'What was that?' inquired Alice. 'Reeling and Writhing, of course, I meant,' the King."
        },
    ]);
    const productTypes = ref(['hot dish', 'cold dish', 'drink', 'dessert']);

    // Local products count
    const totalProducts = computed(() => {
        return products.value.length;
    });

    function getProductsByFilter(type) {
        return products.value.filter( prod => prod.type === type);
    }
    
    function getProductsByFilterTotal(type) {
        return getProductsByFilter(type).length;
    }

    function clearProducts() {
        products.value = [];
    }

    async function fetchProducts() {
        try {
            const response = await axios.get('/products');
            products.value = response.data.data;
            return products.value;
        } catch (error){
            clearProducts();
            throw error;
        }
    }
    // TODO Sera que queremos isto?
    socket.on('newProduct', (product) => {
        products.value.push(product);
        toast.success(`A new product was added (#${product.id} : ${product.name})`);
    }) ;

    socket.on('deleteProject', (product) => {
        deleteProductOnArray(product);
        toast.info(`The product (#${product.id} : ${product.name}) was deleted!`);
    });

    function deleteProductOnArray(deleteProduct) {
        let idx = products.value.findIndex((t) => t.id === deleteProduct.id);
        if (idx >= 0) {
            products.value.splice(idx, 1);
        }
    }
    
    return {
        products, productTypes,
        totalProducts,
        fetchProducts,
        getProductsByFilter, getProductsByFilterTotal
    }
})
