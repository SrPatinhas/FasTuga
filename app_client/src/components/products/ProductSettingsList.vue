<template>
	<div class="align-items-center d-flex justify-content-between pb-3">
		<h2 class="h3 py-2 text-center text-sm-start">Products</h2>
		<router-link class="btn btn-success" :to="{ name: 'CreateProduct' }">+ Add Product</router-link>
	</div>
	<div v-if="productsLoading">
		<div class="p-5 bg-faded-info rounded-3">
			<div class="">
				<h1 class="align-items-center d-flex fw-bold justify-content-between">
					Loading products
					<span class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</span>
				</h1>
			</div>
		</div>
	</div>
	<div v-else-if="products.length === 0">
		<div class="p-5 bg-faded-warning rounded-3">
			<div class="">
				<h1 class="fw-bold">No Products to show <i class="bi bi-emoji-frown fs-2 text-danger"></i></h1>
				<p class="col-md-8 fs-5">Create your first product</p>
				<router-link class="btn btn-success" :to="{ name: 'CreateProduct' }">+ Add Product</router-link>
			</div>
		</div>
	</div>
	<div v-else>
		<div class="d-block d-sm-flex align-items-center py-4 border-bottom" v-for="(product, index) of products" :key="index">
			<div class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto width-110">
				<img :src="product.photo_url" class="card-img-top" :alt="product.name">
			</div>
			<div class="text-center text-sm-start">
				<h3 class="h6 product-title mb-2">{{ product.name }}</h3>
				<div class="d-inline-block text-accent w-75">{{ product.description }}</div>
				<div class="w-100">
					<div class="d-inline-block text-muted fs-ms mt-2 pt-2">
						Price: <span class="fw-medium">{{ product.price.toFixed(2) }}€</span>
					</div>
					<div class="d-inline-block text-muted fs-ms border-start ms-2 ps-2">
						Is Deleted: <span class="fw-medium">{{ product.is_deleted }}</span>
					</div>
				</div>
			</div>
			<div class="btn-group btn-group-sm me-2" role="group" aria-label="First group">
				<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit-product" @click="fetchProduct(product.id)">
					<i class="bi bi-pencil m-0"></i>
				</button>
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-product"  @click="fetchProduct(product.id)">
					<i class="bi bi-trash m-0"></i>
				</button>
			</div>
		</div>
		<div v-if="pagination !== undefined">
			<Pagination @page-change="updateProductsList" :pagination="pagination"/>
		</div>
	</div>


	<div class="modal fade" id="edit-product" tabindex="-1" aria-hidden="true">
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
							<input class="form-control" type="text" id="input-name" required v-model="productDetail.name">
						</div>
						<div class="col-12">
							<label class="form-label" for="ticket-subject">Description</label>
							<textarea class="form-control" type="text" id="input-description" required v-model="productDetail.description"> </textarea>
							<div class="invalid-feedback">Please fill in the name!</div>
						</div>
						<div class="col-12">
							<label class="form-label" for="ticket-subject">Price</label>
							<input class="form-control" type="text" id="input-price" required v-model="productDetail.price">
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
							<PhotoUploader @image-change="changeUploadImage" :url-old="productDetail.photo_url"/>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="submit" @click="SaveProduct(productDetail.id)">
						Save
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="delete-product" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Delete product - {{ productDetail.name }}</h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row gx-4 gy-3">
						<div class="col-12">
							<label class="form-label" for="ticket-subject">Do you want delete the product {{ productDetail.name }}?</label>
						</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="submit" @click="deleteProduct(productDetail.id)"  data-bs-dismiss="modal">
							Delete
					</button>
				</div>

			</div>
		</div>
	</div>
</div>
	</div>
</template>

<script setup>
	import {ref, inject} from 'vue';
	const socket = inject("socket");
	const axios = inject('axios');

	import Pagination from "@/components/navigation/Pagination.vue";
	import PhotoUploader from "@/components/global/photoUploader.vue";

	const productDetail = ref({
		name: '',
		type: '',
		price: '',
		description: '',
		photo: null,
		loading: false
	});
	const pagination = ref({});
	const products = ref([]);
	const productsLoading = ref(true);


	const changeUploadImage = (image) => {
		productDetail.value.photo = image;
	}


	async function fetchProducts(page = 1) {
		try {
			productsLoading.value = true;
			const response = await axios.get('/products/list?page=' + page);
			products.value = response.data.data;
			pagination.value = response.data.meta;
			productsLoading.value = false;
			return products.value;
		} catch (error) {
			products.value = [];
			productDetail.value = {};
			productsLoading.value = false;
			throw error;
		}
	}

	function updateProductsList(newPage) {
		fetchProducts(newPage);
	}

	async function fetchProduct(id) {
		try {
			//productsLoading.value = true;
			const response = await axios.get('/products/' + id);
			productDetail.value = response.data.data;
			//productsLoading.value = false;
			return true;
		} catch (error) {
			//productsLoading.value = false;
			throw error;
		}
	}

	async function SaveProduct(id) {
		//productDetail.loading = true;
		try {
			const formData = new FormData();
			formData.append('method','PUT')
			if (productDetail.value.photo != null) {
				formData.append('photo', productDetail.value.photo);
			}
			for (const [key, value] of Object.entries(productDetail.value)) {
				if (key !== "photo") {
					formData.append(key, value);
				}
			}
			await axios.post('products/' + id, formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			socket.emit('newProduct');
			updateProductsList(1);
			return true;
		} catch (error) {
			return false;
		}
	}

	async function deleteProduct(id) {
		try {
			const response = await axios.delete('/products/' + id);
			productDetail.value = response.data.data;
			updateProductsList(1);
			return true;
		} catch (error) {
			throw error;
		}
	}

	fetchProducts(1);
</script>