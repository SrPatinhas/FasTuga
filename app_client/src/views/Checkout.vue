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
			<div class="row pb-4 pt-3">
				<div class="col-sm-6 mb-4">
					<label class="form-label" for="fd-name">Your name<sup class="text-danger ms-1">*</sup></label>
					<input class="form-control" type="text" required="" id="fd-name" v-model="orderCheckout.name">
					<div class="invalid-feedback">Please enter your name!</div>
				</div>
				<div class="col-sm-6 mb-4">
					<label class="form-label" for="fd-phone">Phone number<sup class="text-danger ms-1">*</sup></label>
					<input class="form-control" type="text" required="" id="fd-phone" v-model="orderCheckout.phone">
					<div class="invalid-feedback">Please enter your phone number!</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 mb-4 mb-sm-0">
					<h2 class="h5 pb-2">Order Payment</h2>
					<div class="accordion accordio-flush shadow-sm rounded-3 mb-4" id="payment-methods">
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table accordion-button" data-bs-toggle="collapse" data-bs-target="#credit-card" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-card" value="visa" v-model="orderCheckout.payment.type" @change="orderCheckout.payment.account = ''">
									<label class="form-check-label fw-medium" for="payment-card">
										<i class="bi-credit-card text-muted fs-lg align-middle mt-n1 ms-2"></i>
										Credit card
									</label>
								</div>
							</div>
							<div class="collapse" id="credit-card" data-bs-parent="#payment-methods">
								<div class="accordion-body py-2">
									<input class="form-control bg-image-none mb-3" type="text" v-model="orderCheckout.payment.account" placeholder="4xxxxxxxxxxxxxxx">
								</div>
							</div>
						</div>
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table collapsed accordion-button" data-bs-toggle="collapse" data-bs-target="#paypal" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-paypal" value="paypal" v-model="orderCheckout.payment.type" @change="orderCheckout.payment.account = ''">
									<label class="form-check-label fw-medium" for="payment-paypal">
										<i class="bi-paypal text-muted fs-base align-middle mt-n1 ms-2"></i>
										PayPal
									</label>
								</div>
							</div>
							<div class="collapse" id="paypal" data-bs-parent="#payment-methods">
								<div class="accordion-body pt-2">
									<input class="form-control" type="text" required="" id="fd-phone" v-model="orderCheckout.payment.account" placeholder="email@email.com">
								</div>
							</div>
						</div>
						<div class="accordion-item border-bottom">
							<div class="accordion-header">
								<div class="d-table collapsed accordion-button" data-bs-toggle="collapse" data-bs-target="#cash" aria-expanded="false">
									<input class="form-check-input" type="radio" name="license" id="payment-mbway" value="mbway" v-model="orderCheckout.payment.type" @change="orderCheckout.payment.account = ''">
									<label class="form-check-label fw-medium" for="payment-mbway">
										<i class="bi-qr-code text-muted fs-lg align-middle mt-n1 ms-2"></i>
										MbWay
									</label>
								</div>
							</div>
							<div class="collapse" id="cash" data-bs-parent="#payment-methods">
								<div class="accordion-body pt-2">
									<input class="form-control" type="text" required="" v-model="orderCheckout.payment.account" placeholder="9xxxxxxxx">
								</div>
							</div>
						</div>
						<div class="accordion-item">
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
										<input type="range" class="form-range" id="use_points" step="1"
											   v-model="orderCheckout.points" min="0" :max="userStore.availablePoints"
											   :disabled="userStore.availablePoints === 0">
									</div>
								</div>
							</div>
						</div>
					</div>
					<button class="btn btn-primary d-block w-100 mt-3" type="submit" :disabled="checkoutDisabled" @click="submitOrder">
						Proceed to Checkout
						<i class="bi-arrow-right-short"></i>
					</button>
				</div>
				<div class="col-sm-6">
					<h2 class="h5 pb-2">Your total</h2>
					<div class="rounded-3 bg-secondary px-3 px-sm-4 py-4">
						<div class="d-flex justify-content-between fs-md border-bottom mb-3">
							<span>Subtotal:</span>
							<span class="text-heading">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}</small></span>
						</div>
						<div class="d-flex justify-content-between fs-md pb-2">
							<span>Points Earned:</span>
							<span class="text-heading">{{ orderStore.orderPoints }}</span>
						</div>
						<div class="align-items-center d-flex mb-3 small text-muted" role="alert">
							<i class="mr-2 bi-info-circle"></i>
							<div>For each 10€, you will get 1 point</div>
						</div>
						<div class="d-flex justify-content-between border-top pt-3 fs-md mb-2">
							<span>Total:</span>
							<span class="text-heading fw-medium">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}</small></span>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script setup>
	import {computed, inject, ref} from "vue";
	import {useRouter} from "vue-router";

	const toast = inject("toast");
	const router = useRouter();

	import validations from "@/utils/validations";
	import {useOrdersStore} from "@/stores/order";
	import {useUserStore} from "@/stores/user";

	const userStore = useUserStore();
	const orderStore = useOrdersStore();

	const orderCheckout = ref({
		payment: {
			type: undefined,
			account: undefined
		},
		name: '',
		phone: '',
		email: '',
		points: false
	});


	const checkPayment = () => {
		let paymentValid = false;
		let paymentType = orderCheckout.value.payment.type;
		let paymentAccount = orderCheckout.value.payment.account;

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
		return orderCheckout.value.name.trim() === '' || orderStore.totalItems === 0 || !checkPayment();
	});

	const submitOrder = () => {
		// TODO finish checkout miguel.cerejo
		if(!checkPayment()) {
			alert('Payment not accepted');
			return false;
		}
		if( orderStore.completeOrder(orderCheckout)) {
			toast.success(`The order (#${orderStore.order.id}) is now on the status ${order.status}!`)
			console.log('order submited');
			router.push({name: "OrderDetail", params: {id: '1'}});
		} else {
			console.log('order error payment');
			toast.error(`There was an error with your order, please try again!`)
		}
	}
</script>