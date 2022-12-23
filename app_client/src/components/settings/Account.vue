<script setup>
	import {useUserStore} from "@/stores/user";
	const userStore = useUserStore();
	function save() {

	}
</script>

<template>
	<!-- Content-->
	<section class="col-lg-8 pt-lg-4 pb-4 mb-3">
		<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
			<h2 class="h3 py-2 text-center text-sm-start">Personal data</h2>
			<!-- Tabs-->
			<ul class="nav nav-pills nav-justified" role="tablist" v-if="userStore.isCustomer">
				<li class="nav-item" role="presentation">
					<a class="nav-link active px-0" href="#profile" data-bs-toggle="tab" role="tab" aria-selected="true">
						<div class="d-none d-lg-block">
							<i class="bi-people opacity-60 me-2"></i>Profile
						</div>
						<div class="d-lg-none text-center">
							<i class="bi-people opacity-60 d-block fs-xl mb-2"></i>
							<span class="fs-ms">Profile</span>
						</div>
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link px-0" href="#userInformation" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
						<div class="d-none d-lg-block"><i class="bi-receipt opacity-60 me-2"></i>User information</div>
						<div class="d-lg-none text-center">
							<i class="bi-receipt opacity-60 d-block fs-xl mb-2"></i>
							<span class="fs-ms">User information</span>
						</div>
					</a>
				</li>
				<li class="nav-item" role="presentation" v-if="userStore.isCustomer">
					<a class="nav-link px-0" href="#payment" data-bs-toggle="tab" role="stab" aria-selected="false" tabindex="-1">
						<div class="d-none d-lg-block"><i class="bi-credit-card opacity-60 me-2"></i>Payment methods</div>
						<div class="d-lg-none text-center">
							<i class="bi-credit-card opacity-60 d-block fs-xl mb-2"></i>
							<span class="fs-ms">Payment</span>
						</div>
					</a>
				</li>
			</ul>
			<!-- Tab content-->
			<div class="tab-content">
				<!-- Profile-->
				<div class="tab-pane fade show active" id="profile" role="tabpanel">
					<div class="row mt-3">
						<div class="col-sm-12">
							<div class="bg-secondary rounded-3 p-4 mb-4">
								<div class="d-flex align-items-center">
									<img class="rounded" :src="userStore.userPhotoUrl" width="90" :alt="userStore.user.name">
									<div class="ps-3">
										<button class="btn btn-light btn-shadow btn-sm mb-2" type="button"><i
											class="ci-loading me-2"></i>Change <span class="d-none d-sm-inline">avatar</span>
										</button>
										<div class="p mb-0 fs-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300 required.
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="dashboard-fn">Name</label>
							<input type="text" class="form-control" id="inputName" placeholder="User Name" required v-model="userStore.user.name"/>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="dashboard-email">Email address</label>
							<input type="email" class="form-control" id="inputEmail" placeholder="Email" required v-model="userStore.user.email"/>
						</div>
						<div class="mb-3 d-flex justify-content-end mt-3">
							<button type="button" class="btn btn-primary px-5" @click="save">Save</button>
							<button type="button" class="btn btn-light px-5" @click="cancel">Cancel</button>
						</div>
					</div>
				</div>
				<!-- User information -->
				<div class="tab-pane fade" id="userInformation" role="tabpanel" v-if="userStore.isCustomer">
					<div class="row gx-4 gy-3 mt-3">
						<div class="col-sm-6">
							<label class="form-label" for="inputPhoneNumber">Phone Number</label>
							<input type="number" class="form-control" id="inputPhoneNumber" placeholder="Phone Number" required v-model="userStore.customer.phone"/>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="inputNIF">NIF</label>
							<input type="number" class="form-control" id="inputNIF" placeholder="NIF" required v-model="userStore.customer.nif"/>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="inputpoints">Total points owned</label>
							<input disabled="" type="text" class="form-control" id="inputpoints" placeholder="Total points owned" required v-model="userStore.customer.points"/>
						</div>
						<div class="col-12">
							<div class="mb-3 d-flex justify-content-end mt-3">
								<button class="btn btn-primary mt-3 mt-sm-0" type="button">Save changes</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Payment methods-->
				<div class="tab-pane fade" id="payment" role="tabpanel" v-if="userStore.isCustomer">
					<div class="row mt-3 gx-4 gy-3">
						<div class="col-sm-12">
							<div class="bg-secondary rounded-3 p-4 mb-4">
								<p class="fs-sm text-muted mb-0">Primary payment method is used by default</p>
							</div>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="inputdefaultpaymenttype">Default payment type</label>
							<input disabled="" type="text" class="form-control" id="inputdefaultpaymenttype" placeholder="Default payment type" required v-model="userStore.customer.default_payment_type"/>
						</div>
						<div class="col-sm-6">
							<label class="form-label" for="inputPayRef">Default payment reference</label>
							<input type="number" class="form-control" id="inputNIF" placeholder="Default payment reference" required v-model="userStore.customer.default_payment_reference"/>
						</div>
						<div class="text-sm-end">
							<a class="btn btn-primary" href="#add-payment" data-bs-toggle="modal">Change payment method</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<form class="needs-validation modal fade" method="post" id="add-payment" tabindex="-1" novalidate="" aria-modal="true" role="dialog" v-if="userStore.isCustomer">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Update your payment method</h5>
					<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-check mb-4">
						<input class="form-check-input" type="radio" id="visa" name="payment-method" checked="" v-model="userStore.customer.default_payment_type" value="visa">
						<label class="form-check-label" for="visa">Credit / Debit card</label>
					</div>
					<div class="form-check mb-4">
						<input class="form-check-input" type="radio" id="paypal" name="payment-method" v-model="userStore.customer.default_payment_type" value="paypal">
						<label class="form-check-label" for="paypal">PayPal</label>
					</div>
					<div class="form-check mb-4">
						<input class="form-check-input" type="radio" id="mbway" name="payment-method" v-model="userStore.customer.default_payment_type" value="mbway">
						<label class="form-check-label" for="mbway">MBway</label>
					</div>
					<div class="row g-3 mb-2">
						<div class="col-sm-12" v-if="userStore.customer.default_payment_type === 'visa'">
							<label class="form-label">Visa / Master card Number</label>
							<input class="form-control" type="text" placeholder="Card Number" required="" v-model="userStore.customer.default_payment_reference">
							<div class="invalid-feedback">Please fill in the card number!</div>
						</div>
						<div class="col-sm-12" v-if="userStore.customer.default_payment_type === 'paypal'">
							<label class="form-label">Paypal Email</label>
							<input class="form-control" type="text" placeholder="Email" required="" v-model="userStore.customer.default_payment_reference">
							<div class="invalid-feedback">Please provide a valid email!</div>
						</div>
						<div class="col-sm-12" v-if="userStore.customer.default_payment_type === 'mbway'">
							<label class="form-label">MBway Phone Number</label>
							<input class="form-control" type="text" placeholder="Phone Number" required="" v-model="userStore.customer.default_payment_reference">
							<div class="invalid-feedback">Please provide phone number valid!</div>
						</div>
						<div class="col-sm-12 text-center">
							<button class="btn btn-primary" type="submit">Update payment information</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>