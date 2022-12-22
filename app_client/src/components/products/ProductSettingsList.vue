<template>
	<div v-if="productStore.products?.data?.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No Products to show <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>
				<p class="col-md-8 fs-5">Create your first product</p>
				<router-link class="btn btn-primary btn-lg" :to="{ name: 'Menus' }">Menu</router-link>
			</div>
		</div>
	</div>
	<div v-else>
		
		<router-link class="nav-link-style d-flex align-items-center px-4 py-3" :class="{ active: $route.name === 'CreateProduct' }" :to="{ name: 'CreateProduct' }">
			<button type="button" class="btn btn-primary">Add product</button>
		</router-link>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(product, index) of productStore.products.data" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" style="width: 12.5rem;">
				<img :src="product.photo_url" class="card-img-top" :alt="name">
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ product.name }}</h3>
				<div class="d-inline-block text-accent">{{ product.description }}</div>
				<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
					Price:
					<span class="fw-medium">{{ product.price }}</span>
				</div>
				<div class="d-flex justify-content-center justify-content-sm-start pt-3">
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="modal" data-bs-target="#edit-product" @click="fetchProduct(product.id)" > 
						<i class="bi bi-pencil"></i>
					</button>
					<button class="btn bg-faded-danger btn-icon" type="button" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" @click="deleteProduct(product.id)" >
						<i class="bi bi-trash"></i>
					</button>
				</div>
			</div>
		</div>
		<div v-if="productStore.products?.meta !== undefined">
			<Pagination @page-change="updateProducts()" :pagination="productStore.products.meta"/>
		</div>
	</div>
	
	

	<div class="modal fade" id="edit-product" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit product - {{ productDetail.name }}</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row gx-4 gy-3">
                <div class="col-12">
                  <label class="form-label" for="ticket-subject">Name</label>
                  <input class="form-control" type="text" id="input-name" 
                  required v-model="productDetail.name">
				</div>
				<div class="col-12">
                  <label class="form-label" for="ticket-subject">Description</label>
                  <input class="form-control" type="text" id="input-description"
                  required v-model="productDetail.description">
                  <div class="invalid-feedback">Please fill in the name!</div>
                </div>
				<div class="col-12">
				<label class="form-label" for="ticket-subject">Price</label>
                  <input class="form-control" type="text" id="input-price"
                  required v-model="productDetail.price">
				</div>
                <div class="col-sm-6">
                  <label class="form-label" for="input-type">Type</label>
                  <select class="form-select" id="ticket-type" required v-model="productDetail.type">
				  	<option value="hot_dish">Hot dish</option>
					<option value="cold_dish">Cold dish</option>
					<option value="dessert">Dessert</option>
					<option value="drink">Drink</option>
                  </select>
                  <div class="invalid-feedback">Please choose ticket type!</div>
                </div>
				<div class="col-12" id="inputPhoto">
								<PhotoUploader @image-change="changeUploadImage"/>
				</div>
              </div>
            </div>
		
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit"  @click="SaveProduct(productDetail.id)">
					Save
					<span  class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
			  </button>
            </div>
          </div>
        </div>
	</div>
</template>

<script setup>
	import {useProductsStore} from "@/stores/products.js";
	import {ref, reactive, inject} from 'vue';
	import Pagination from "@/components/navigation/Pagination.vue";
	import PhotoUploader from "@/components/global/photoUploader.vue";

	const axios = inject('axios');
	const productStore = useProductsStore();
	productStore.fetchProducts();

	function updateProducts(newPage) {
		productStore.fetchProducts(newPage);
	}

	const changeUploadImage = (image) => {
		product.photo = image;
	}

	const productDetail = ref({});

	const productUpdate = reactive({
		name: '',
		type: '',
		price: '',
		description: '',
		photo: null,
		loading: false
	});

	async function fetchProduct(id) {
		try {
			const response = await axios.get('/products/' + id);
			productDetail.value = response.data.data;
			productDetail.id = id;
			return true;
		} catch (error){
			throw error;
		}
	}

	async function SaveProduct() {
		//productUpdate.loading = true;
		try {
			const formData = new FormData();
			if(productDetail.photo != null) {
				formData.append('photo', productDetail.photo);
			}
			for (const [key, value] of Object.entries(productDetail)) {
				if(key !== "loading" && key !== "photo"){
					formData.append(key, value);
				}
			}
			const response = await axios.put('products/'+ productDetail.id, formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
        	//socket.emit('newProduct');
			//productUpdate.loading = false;
        	return true;
		} catch (error) {
			//productUpdate.loading = false;
			return false;
		}
	}

	async function deleteProduct(id) {
		try {
			const response = await axios.delete('/products/' + id);
			productDetail.value = response.data.data;
			productStore.fetchProducts();
			return true;
		} catch (error){
			throw error;
		}
	}
</script>