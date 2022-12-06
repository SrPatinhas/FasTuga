<template>
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<router-link class="btn " :to="{ name: 'Bag' }">
			<i class="bi-chevron-left"></i>
			Back to bag
		</router-link>
		<h1 class="h2 text-uppercase text-bold">Checkout</h1>
		<div class="empty-menu"></div>
	</div>
	<div class="rounded-3 shadow-lg mt-4 mb-5">
		<form class="needs-validation px-3 px-sm-4 px-xl-5 pt-sm-1 pb-4 pb-sm-5" novalidate="" @submit.prevent>
			<div class="row pb-4 pt-3">
				<div class="col-sm-6 mb-4">
					<label class="form-label" for="fd-name">Your name<sup class="text-danger ms-1">*</sup></label>
					<input class="form-control" type="text" required="" id="fd-name" v-model="order.name">
					<div class="invalid-feedback">Please enter your name!</div>
				</div>
				<div class="col-sm-6 mb-4">
					<label class="form-label" for="fd-phone">Phone number<sup class="text-danger ms-1">*</sup></label>
					<input class="form-control" type="text" required="" id="fd-phone" v-model="order.phone">
					<div class="invalid-feedback">Please enter your phone number!</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 mb-4 mb-sm-0">
					<h2 class="h5 mt-3 pt-4 pb-2">Online payment</h2>
					<span class="mb-2 d-block">Pay with:</span>
					<div class="mb-3">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment" id="online_visa" value="visa" v-model="order.payment.type" @change="order.payment.account = ''">
							<label class="form-check-label" for="online_visa">Visa</label>
						</div>
						<div v-if="order.payment.type == 'visa'">
							<label class="form-label small" for="fd-phone">Card Number<sup class="text-danger ms-1">*</sup></label>
							<input class="form-control" type="text" required="" id="fd-phone" v-model="order.payment.account" placeholder="4xxxxxxxxxxxxxxx">
						</div>
					</div>
					<div class="mb-3">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment" id="online_mbway" value="mbway" v-model="order.payment.type" @change="order.payment.account = ''">
							<label class="form-check-label" for="online_mbway">MbWay</label>
						</div>
						<div v-if="order.payment.type == 'mbway'">
							<label class="form-label small" for="fd-phone">Phone number<sup class="text-danger ms-1">*</sup></label>
							<input class="form-control" type="text" required="" id="fd-phone" v-model="order.payment.account" placeholder="9xxxxxxxx">
						</div>
					</div>
					<div class="mb-3">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment" id="online_paypal" value="paypal" v-model="order.payment.type" @change="order.payment.account = ''">
							<label class="form-check-label" for="online_paypal">PayPal</label>
						</div>
						<div v-if="order.payment.type == 'paypal'">
							<label class="form-label small" for="fd-phone">Paypal Email account<sup class="text-danger ms-1">*</sup></label>
							<input class="form-control" type="text" required="" id="fd-phone" v-model="order.payment.account" placeholder="email@email.com">
						</div>
					</div>

					<button class="btn btn-primary d-block w-100 mt-3" type="submit" :disabled="checkoutDisabled" @click="submitOrder">Complete order</button>
				</div>
				<div class="col-sm-6">
					<div class="d-fle flex-column h-100 rounded-3 bg-secondary px-3 px-sm-4 py-4">
						<h2 class="h5 pb-3">Your total</h2>
						<div class="d-flex justify-content-between fs-md border-bottom pb-3 mb-3">
							<span>Subtotal:</span>
							<span class="text-heading">{{ (orderStore.totalOrderCost).split(".")[0] }}.<small>{{ (orderStore.totalOrderCost).split(".")[1] }}</small></span>
						</div>
						<div class="d-flex justify-content-between fs-md pb-2">
							<span>Points Earned:</span>
							<span class="text-heading">{{ orderStore.orderPoints }}</span>
						</div>
						<div class="align-items-center d-flex mb-3 small text-muted" role="alert">
							<i class="mr-2 bi-info-circle"></i>
							<div>
								For each 10€, you will get 1 point
							</div>
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
	import {computed, ref} from "vue";
	import {useRouter} from "vue-router";
	import {useOrdersStore} from "../stores/order.js";

	const router = useRouter();
	const orderStore = useOrdersStore();

	const order = ref({
		payment: {
			type: undefined,
			account: undefined
		},
		name: undefined,
		phone: undefined,
		email: undefined
	});

	const validateEmail = (email) => {
		return String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	};

	const validatePhoneNumber = (phone) => {
		return phone.match(/^(9)[/0-9]{8}$/g);
	}

	const validateVisaCard = (card) => {
		// Visa Card
		const isVisa = card.match(/^4[0-9]{12}(?:[0-9]{3})?$/g);
		// Visa Master Card:
		const isVisaMaster = card.match(/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/g);
		return isVisa || isVisaMaster;
	}

	const checkPayment = () => {
		let paymentValid = false;
		if(order.value.payment.account == undefined){
			return paymentValid;
		}
		if (order.value.payment.type == "visa") { // for a Visa payment is the Visa Card ID with 16 digits;
			paymentValid = validateVisaCard(order.value.payment.account);
		} else if (order.value.payment.type == "mbway") { // the reference for the MbWay is the mobile phone number with 9 digits
			paymentValid = validatePhoneNumber(order.value.payment.account);
		} else if (order.value.payment.type == "paypal") { // the reference for the PayPal is a valid email
			paymentValid = validateEmail(order.value.payment.account);
		}
		return paymentValid;
	}

	const checkoutDisabled = computed(() => {
		return (order.value.name == undefined || (order.value.name).trim() == '') && orderStore.totalItems == 0;
	});

	const submitOrder = () => {
		// TODO finish checkout miguel.cerejo
		if(!checkPayment()) {
			alert('Payment not accepted');
		}
		console.log('order submited');
		router.push({name: "OrderDetail", params: {id: '1'}});
	}
</script>