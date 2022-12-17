import { ref, computed, inject } from 'vue';
import { defineStore } from 'pinia';

export const useMenuStore = defineStore('menu', () => {
    const socket = inject("socket");
    const axios = inject('axios');
    const toast = inject("toast");
    
    const products = ref([]);
    const productsTrending = ref([]);

    const productsLoading = ref(true);
    const productsTrendingLoading = ref(true);

    const productTypes = ref([
        {type: 'hot dish', icon: 'bi-cup-hot'},
        {type: 'cold dish', icon: 'bi-cup'},
        {type: 'drink', icon: 'bi-cup-straw'},
        {type: 'dessert', icon: 'bi-hypnotize'}// bi-brightness-alt-low
    ]);

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
        productsLoading.value = false;
    }

    function clearProductsTrending() {
        productsTrending.value = [];
        productsTrendingLoading.value = false;
    }

    async function fetchProducts() {
        try {
            productsLoading.value = true;
            const response = await axios.get('/products');
            products.value = response.data.data;
            productsLoading.value = false;
            return products.value;
        } catch (error){
            clearProducts();
            throw error;
        }
    }

    async function fetchProductsTrending() {
        try {
            productsTrendingLoading.value = true;
            const response = await axios.get('/products/trending');
            productsTrending.value = response.data.data;
            productsTrendingLoading.value = false;
            return productsTrending.value;
        } catch (error){
            clearProductsTrending();
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
        products, productTypes, productsTrending,
        totalProducts, productsLoading, productsTrendingLoading,
        fetchProducts, fetchProductsTrending,
        getProductsByFilter, getProductsByFilterTotal
    }
})
