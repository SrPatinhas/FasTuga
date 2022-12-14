<script setup>
	import {useRouter, RouterLink} from "vue-router"
	import {inject} from "vue"
	import {useUserStore} from "@/stores/user";
  import SettingsBar from "../components/navigation/SettingsBar.vue"
  import SettingsAccount from "../views/SettingsAccount.vue"


	const router = useRouter()
	const toast = inject("toast")
	const userStore = useUserStore()

  const logout = async () => {
      if (await userStore.logout()) {
        toast.success('User has logged out of the application.')
        router.push({name: 'home'})
      } else {
        toast.error('There was a problem logging out of the application!')
      }
  }
</script>

<template>
   <div class="container mb-5 pb-3">
        <div class="bg-light shadow-lg rounded-3 overflow-hidden">
          <div class="row">
            <!-- Sidebar-->
            <settingsBar />
            <!-- Content-->
            <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
              <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
                <h2 class="h3 py-2 text-center text-sm-start">Settings</h2>
                <!-- Tabs-->
            <SettingsAccount />
                <!-- Tab content-->
                  <!-- Profile-->
                  <!-- User information -->
                  <!-- Payment methods-->
              </div>
            </section>
        </div>
      </div>
   </div>

      <form class="needs-validation modal fade" method="post" id="add-payment" tabindex="-1" novalidate="" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add a payment method</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="form-check mb-4">
                <input class="form-check-input" type="radio" id="paypal" name="payment-method">
                <label class="form-check-label" for="paypal">PayPal<img class="d-inline-block align-middle ms-2" src="img/card-paypal.png" width="39" alt="PayPal"></label>
              </div>
              <div class="form-check mb-4">
                <input class="form-check-input" type="radio" id="card" name="payment-method" checked="">
                <label class="form-check-label" for="card">Credit / Debit card<img class="d-inline-block align-middle ms-2" src="img/cards.png" width="187" alt="Credit card"></label>
              </div>
              <div class="row g-3 mb-2">
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="number" placeholder="Card Number" required="">
                  <div class="invalid-feedback">Please fill in the card number!</div>
                </div>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="name" placeholder="Full Name" required="">
                  <div class="invalid-feedback">Please provide name on the card!</div>
                </div>
                <div class="col-sm-3">
                  <input class="form-control" type="text" name="expiry" placeholder="MM/YY" required="">
                  <div class="invalid-feedback">Please provide card expiration date!</div>
                </div>
                <div class="col-sm-3">
                  <input class="form-control" type="text" name="cvc" placeholder="CVC" required="">
                  <div class="invalid-feedback">Please provide card CVC code!</div>
                </div>
                <div class="col-sm-6">
                  <button class="btn btn-primary d-block w-100" type="submit">Register this card</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
</template>