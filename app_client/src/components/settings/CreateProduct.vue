<template>
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="align-items-center d-flex pb-3">
			<router-link class="btn btn-secondary mr-2" :to="{ name: 'Products' }">
				<i class="bi-arrow-left m-0"></i>
			</router-link>
			<h2 class="h3 text-center text-sm-start m-0">New Product</h2>
		</div>
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<form class="row g-3" @submit.prevent="">
				<div class="col-12" id="inputPhoto">
					<PhotoUploader @image-change="changeUploadImage"/>
				</div>
				<div class="col-12 col-md-6">
					<label for="inputName" class="form-label">Name</label>
					<input class="form-control" id="inputName" type="text" placeholder="" v-model="product.name">
				</div>
				<div class="col-12 col-md-6">
					<label for="inputState" class="form-label">Type</label>
					<select id="inputType" class="form-select form-control" v-model="product.type">
						<option value="hot_dish">Hot dish</option>
						<option value="cold_dish">Cold dish</option>
						<option value="dessert">Dessert</option>
						<option value="drink">Drink</option>
					</select>
				</div>
				<div class="col-12 col-md-6">
					<label for="inputPrice" class="form-label">Price</label>
					<input class="form-control" id="inputPrice" type="number" placeholder="" v-model="product.price">
				</div>
				<label for="inputDescription" class="form-label">Description</label>
				<textarea class="form-control" id="inputDescription" rows="8" required="" v-model="product.description"></textarea>
				<div class="forms_buttons align-items-end">
					<button class="btn btn-primary" type="submit" :disabled="product.loading" @click="insertProduct">
						Add
						<span v-if="product.loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
						<i v-else class="bi-arrow-right-short"></i>
					</button>
				</div>
			</form>
		</div>
	</section>
</template>

<script setup>
	import {inject, reactive} from 'vue'
	import {useRouter} from 'vue-router'
	import {useUserStore} from "@/stores/user";
	import PhotoUploader from "@/components/global/photoUploader.vue";

	const router = useRouter()
	const axios = inject('axios')
	const toast = inject('toast')
	const userStore = useUserStore();

	const product = reactive({
		name: '',
		type: '',
		price: '',
		description: '',
		photo: null,
		loading: false
	});


	async function insertProduct() {
		product.loading = true;
		try {
			const formData = new FormData();
			if (product.photo != null) {
				formData.append('photo', product.photo);
			}
			for (const [key, value] of Object.entries(product)) {
				if (key !== "loading" && key !== "photo") {
					formData.append(key, value);
				}
			}
			await axios.post('products', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
			socket.emit('newProduct');
			product.loading = false;
			router.push({name: 'Products'});
			return true;
		} catch (error) {
			product.loading = false;
			return false;
		}
	}

	const changeUploadImage = (image) => {
		product.photo = image;
	}
</script>
