<template>
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
		<router-link class="btn " :to="{ name: 'Bag' }">
			<i class="bi-chevron-left"></i>
			Back to bag
		</router-link>
		<h1 class="h2 text-uppercase text-bold">Checkout</h1>
		<div class="empty-menu"></div>
	</div>
	<div class="card border-0 shadow-sm mt-4">

		<form class="needs-validation px-3 px-sm-4 px-xl-5 pt-sm-1 pb-4 pb-sm-5" novalidate="" @submit.prevent>
			<div class="row my-4 pb-4 border-bottom">
				<h2 class="h5 pb-2">Customer Information</h2>
				<div class="col-12 col-md-6">
					<label for="inputName" class="form-label">Name<span class="text-danger">*</span></label>
					<input class="form-control" id="inputName" type="text" placeholder="Name" required v-model="orderCheckout.name">
				</div>
				<div class="col-12 col-md-6">
					<label for="inputEmail4" class="form-label">Email<span class="text-danger">*</span></label>
					<div class="input-group mb-3">
						<i class="bi-at position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
						<input class="form-control" :class="validateEmail ? 'is-valid' : (orderCheckout.email ? 'is-invalid' : '')" type="email" placeholder="Email" required v-model="orderCheckout.email">
					</div>
					<div class="invalid-feedback" :class="!validateEmail && orderCheckout.email && 'd-block'">
						Your email is invalid
					</div>
				</div>

				<div class="col-12 col-md-6">
					<label for="inputPhone" class="form-label">Phone<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="inputPhone" placeholder="911 111 111"
						   :class="validatePhone ? 'is-valid' : (orderCheckout.phone ? 'is-invalid' : '')"
						   required v-model="orderCheckout.phone">
					<div class="invalid-feedback" :class="!validatePhone && orderCheckout.phone && 'd-block'">
						Your phone is invalid
					</div>
				</div>
				<div class="col-12 col-md-6">
					<label for="inputNif" class="form-label">NIF<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="inputNif" placeholder="123 123 123"
						   :class="validateNif ? 'is-valid' : (orderCheckout.nif ? 'is-invalid' : '')"
						   required v-model="orderCheckout.nif">
					<div class="invalid-feedback" :class="!validateNif && orderCheckout.nif && 'd-block'">
						Your NIF is invalid
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 mb-4 mb-sm-0">
					<h2 class="h5 pb-2">Order Payment</h2>
					<div class="accordion accordio-flush shadow-sm rounded-3 mb-4" id="payment-methods">
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table accordion-button" :class="orderCheckout.pay_type !== 'visa' && 'collapsed'" data-bs-toggle="collapse" data-bs-target="#credit-card" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-card" value="visa" v-model="orderCheckout.pay_type" @change="orderCheckout.pay_reference = ''">
									<label class="form-check-label fw-medium" for="payment-card">
										<i class="bi-credit-card text-muted fs-lg align-middle mt-n1 ms-2"></i>
										Credit card
									</label>
								</div>
							</div>
							<div class="collapse" :class="orderCheckout.pay_type === 'visa' && 'show'" id="credit-card" data-bs-parent="#payment-methods">
								<div class="accordion-body py-2">
									<input class="form-control bg-image-none mb-3" type="text" v-model="orderCheckout.pay_reference" placeholder="4xxxxxxxxxxxxxxx">
								</div>
							</div>
						</div>
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table accordion-button" :class="orderCheckout.pay_type !== 'paypal' && 'collapsed'" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-paypal" value="paypal" v-model="orderCheckout.pay_type" @change="orderCheckout.pay_reference = ''">
									<label class="form-check-label fw-medium" for="payment-paypal">
										<i class="bi-paypal text-muted fs-base align-middle mt-n1 ms-2"></i>
										PayPal
									</label>
								</div>
							</div>
							<div class="collapse" :class="orderCheckout.pay_type === 'paypal' && 'show'" id="paypal" data-bs-parent="#payment-methods">
								<div class="accordion-body pt-2">
									<input class="form-control" type="text" required="" id="fd-phone" v-model="orderCheckout.pay_reference" placeholder="email@email.com">
								</div>
							</div>
						</div>
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table accordion-button" :class="orderCheckout.pay_type !== 'mbway' && 'collapsed'" data-bs-toggle="collapse" data-bs-target="#cash" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-mbway" value="mbway" v-model="orderCheckout.pay_type" @change="orderCheckout.pay_reference = ''">
									<label class="form-check-label fw-medium" for="payment-mbway">
										<i class="bi-qr-code text-muted fs-lg align-middle mt-n1 ms-2"></i>
										MbWay
									</label>
								</div>
							</div>
							<div class="collapse" :class="orderCheckout.pay_type === 'mbway' && 'show'" id="cash" data-bs-parent="#payment-methods">
								<div class="accordion-body pt-2">
									<input class="form-control" type="text" required="" v-model="orderCheckout.pay_reference" placeholder="9xxxxxxxx">
								</div>
							</div>
						</div>
						<div class="accordion-item" v-if="userStore.isCustomer">
							<div class="accordion-header">
								<div class="accordion-button fw-medium collapsed" data-bs-toggle="collapse" data-bs-target="#points" aria-expanded="false">
									<i class="bi-gift me-2"></i>Redeem Reward Points
								</div>
							</div>
							<div class="collapse" id="points" data-bs-parent="#payment-method">
								<div class="accordion-body">
									<div>
										You currently have<span class="fw-medium">&nbsp;{{ userStore.availablePoints }}</span>&nbsp;Reward Points to spend.
										<div class="align-items-center d-flex mb-3 small text-muted" role="alert">
											<i class="mr-2 bi-info-circle"></i>
											<div>For each 10 points, you will get a 5€ discount</div>
										</div>
									</div>
									<div class="d-block">
										<label class="form-label" for="use_points">Ammount of Reward Points to use for this order</label>
										<input type="range" class="form-range" id="use_points" step="10"
											   v-model.number="orderPoints" min="0" :max="userStore.availablePoints"
											   :disabled="userStore.availablePoints === 0">
										<span>{{ orderPoints }} points - {{ (orderPoints / 2) }}€</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<h2 class="h5 pb-2">Your total</h2>
					<div class="rounded-3 bg-secondary px-3 px-sm-4 py-4">
						<div class="d-flex justify-content-between fs-md border-bottom mb-3">
							<span>Subtotal:</span>
							<span class="text-heading">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}€</small></span>
						</div>
						<template v-if="userStore.isCustomer">
							<div class="d-flex justify-content-between fs-md pb-2">
								<span>Points Earned:</span>
								<span class="text-heading">{{ orderStore.orderPoints }}</span>
							</div>
							<div class="align-items-center d-flex mb-3 small text-muted" role="alert">
								<i class="mr-2 bi-info-circle"></i>
								<div>For each 10€, you will get 1 point</div>
							</div>
							<div class="d-flex justify-content-between fs-md py-2 border-top" v-if="orderPoints > 0">
								<span>Discount from points:</span>
								<span class="text-heading">-{{ (orderPoints / 2) }}€</span>
							</div>
						</template>
						<div class="d-flex justify-content-between border-top pt-3 fs-md mb-2">
							<span>Total:</span>
							<span class="text-heading fw-medium">{{ orderTotal }}.<small>{{ orderTotal_cent }}€</small></span>
						</div>
					</div>
					<button class="btn btn-primary d-block w-100 mt-3" type="submit" :disabled="isFormValid || orderCheckout.loading" @click="submitOrder">
						Proceed to Checkout
						<span v-if="orderCheckout.loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
						<i v-else class="bi-arrow-right-short"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</template>

<script setup>
	import {computed, inject, reactive, ref} from "vue";
	import {useRouter} from "vue-router";
	import validations from "@/utils/validations";
	import {useOrdersStore} from "@/stores/order";
	import {useUserStore} from "@/stores/user";

	const toast = inject("toast");
	const router = useRouter();
	const userStore = useUserStore();
	const orderStore = useOrdersStore();

	const orderPoints = ref(0);
	const paymentLoading = ref(false);
	const orderCheckout = reactive({
		name: '',
		email: '',
		nif: '',
		phone: '',
		pay_type: '',
		pay_reference: '',
		points: 0,
		loading: false
	});

	if(userStore.user) {
		orderCheckout.name 	= userStore.user.name;
		orderCheckout.email = userStore.user.email;
	}
	if(userStore.customer) {
		orderCheckout.nif 				= userStore.customer.nif;
		orderCheckout.phone 			= userStore.customer.phone;
		orderCheckout.pay_type 			= userStore.customer.default_payment_type.toLowerCase();
		orderCheckout.pay_reference 	= userStore.customer.default_payment_reference;
	}
	if(orderStore.orderPoints) {
		orderCheckout.points = orderStore.orderPoints;
	}
	const checkPayment = () => {
		let paymentValid = false;
		let paymentType = orderCheckout.pay_type;
		let paymentAccount = orderCheckout.pay_reference;

		if(paymentAccount === undefined){
			return paymentValid;
		}
		if (paymentType === "visa") { // for a Visa payment is the Visa Card ID with 16 digits;
			paymentValid = validations.validateVisaCard(paymentAccount);
		} else if (paymentType === "mbway") { // the reference for the MbWay is the mobile phone number with 9 digits
			paymentValid = validations.validatePhoneNumber(paymentAccount);
		} else if (paymentType === "paypal") { // the reference for the PayPal is a valid email
			paymentValid = validations.validateEmail(paymentAccount);
		}
		return paymentValid;
	}

	const checkoutDisabled = computed(() => {
		return orderCheckout.name.trim() === '' || orderStore.totalItems === 0 || !checkPayment();
	});

	const submitOrder = async () => {
		paymentLoading.value = true;
		if(!checkPayment()) {
			alert('Payment not accepted');
			paymentLoading.value = false;
			return false;
		}

		const orderPayment = await orderStore.completeOrder(orderCheckout);
		if( orderPayment ) {
			toast.success(`The order (#${orderStore.order.id}) is now on the status ${orderStore.order.status}!`)
			console.log('order submited');
			router.push({name: "OrderDetail", params: {id: '1'}});
			paymentLoading.value = false;
		} else {
			console.log('order error payment');
			toast.error(`There was an error with your order, please try again!`);
			paymentLoading.value = false;
		}
	}

	const orderTotal = computed(() => {
		const value = orderStore.totalOrderCost - (orderPoints.value / 2);
		return (value.toFixed(2) + "").split(".")[0];
	});
	const orderTotal_cent = computed(() => {
		const value = orderStore.totalOrderCost - (orderPoints.value / 2);
		return (value.toFixed(2) + "").split(".")[1];
	});
	/*
	* From Registration
	* */

	const btnDisabled = ref(true);


	const register = async () => {
		if(isFormValid.value) {
			orderCheckout.loading = true;
			if (await userStore.register(credentials)) {
				orderCheckout.loading = false;
				toast.success('User ' + userStore.user.name + ' has entered the application.')
				emit('register');
				//router.back()
				console.log('register');
				router.push({name: 'Menus'});
			} else {
				orderCheckout.loading = false;
			}
		}
	}

	const validateEmail = computed(() => {
		return validations.isValidEmail(orderCheckout.email);
	});
	const validatePhone = computed(() => {
		return validations.isValidPhoneNumber(orderCheckout.phone);
	});
	const validateNif = computed(() => {
		return validations.isValidNIF(orderCheckout.nif);
	});
	const validatePayment = computed(() => {
		return checkPaymentDetaulf();
	});

	function checkPaymentDetaulf() {
		let isPaymentValid = false;
		const paymentType = orderCheckout.pay_type.toLowerCase();
		const paymentValue = orderCheckout.pay_reference;
		if (paymentType === "visa") { // for a Visa payment is the Visa Card ID with 16 digits;
			isPaymentValid = validations.validateVisaCard(paymentValue);
		} else if (paymentType === "mbway") { // the reference for the MbWay is the mobile phone number with 9 digits
			isPaymentValid = validations.isValidPhoneNumber(paymentValue);
		} else if (paymentType === "paypal") { // the reference for the PayPal is a valid email
			isPaymentValid = validations.isValidEmail(paymentValue);
		}
		return isPaymentValid;
	}

	const isFormValid = computed(() => {
		return validateEmail.value && validatePhone.value && validateNif.value && validatePayment.value;
	});
</script>