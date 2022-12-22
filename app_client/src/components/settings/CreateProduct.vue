<script setup>
import {ref, inject, computed, reactive} from 'vue'
	import {useRouter} from 'vue-router'
	import {useUserStore} from "@/stores/user";
	import PhotoUploader from "@/components/global/photoUploader.vue";
	import validations from "@/utils/validations";

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
			if(product.photo != null) {
				formData.append('photo', product.photo);
			}
			for (const [key, value] of Object.entries(product)) {
				if(key !== "loading" && key !== "photo"){
					formData.append(key, value);
				}
			}
			const response = await axios.post('products', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			});
        	socket.emit('newProduct');
			product.loading = false;
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

<template>
	  <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
		<router-link class="btn " :to="{ name: 'Products' }">
			<i class="bi bi-arrow-left"></i>
		</router-link>
                <h2 class="h3 py-2 text-center text-sm-start">New Product</h2>

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
							<div class="forms_buttons">
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


<style scoped>
/**
 * * Page background
 * */
.register {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;

	height: 100%;
	padding-top: 0;
	padding-bottom: 0;
	margin-top: 5%;
}
.user_options-container {
	position: relative;
	display: flex;
	justify-content: space-evenly;
	align-items: center;
}
.user_options-text {
	width: 30%;
	max-width: 500px;
}

/**
 * * Registered and Unregistered user box and text
 * */
.user_options-registered,
.user_options-unregistered {
	width: 100%;
	padding: 75px 45px;
	color: var(--bs-black);
	font-weight: 300;
}

/**
 * * Login and signup forms
 * */
.user_options-forms {
	width: 70%;
	min-width: 350px;
	min-height: 380px;
	height: 100%;
	background-color: #fff;
	border-radius: 3px;
	box-shadow: 2px 0 15px rgba(0, 0, 0, 0.25);
	padding: 30px 40px;
	transition: transform 0.4s ease-in-out;
}
.user_options-forms .forms_title {
	margin-bottom: 45px;
	font-size: 1.5rem;
	font-weight: 500;
	line-height: 1em;
	text-transform: uppercase;
	color: #e8716d;
	letter-spacing: 0.1rem;
}
.user_options-forms .forms_field:not(:last-of-type) {
	margin-bottom: 20px;
}
.user_options-forms .forms_field-input {
	width: 100%;
	border-bottom: 1px solid #ccc;
	padding: 6px 20px 6px 6px;
	font-size: 1rem;
	font-weight: 300;
	color: gray;
	letter-spacing: 0.1rem;
	transition: border-color 0.2s ease-in-out;
}
.user_options-forms .forms_field-input:focus {
	border-color: gray;
}
.user_options-forms .forms_buttons {
	display: flex;
	justify-content: end;
	align-items: center;
	margin-top: 35px;
}
/**
 * * Responsive 990px
 * */
@media screen and (max-width: 990px) {
	.user_options-forms {
		min-height: 350px;
	}
	.user_options-forms .forms_buttons {
		flex-direction: column;
	}
	.user_options-forms .user_forms-login .forms_buttons-action {
		margin-top: 30px;
	}
	.user_options-forms .user_forms-signup,
	.user_options-forms .user_forms-login {
		top: 40px;
	}
	.user_options-registered,
	.user_options-unregistered {
		padding: 50px 45px;
	}
}

</style>