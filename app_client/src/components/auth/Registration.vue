<script setup>
import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'
//

const router = useRouter()
const axios = inject('axios')
const toast = inject('toast')
//const userStore = useUserStore()

const credentials = ref({
	name: '',
    email: '',
    password: '',
    password_confirmation: '',
    type: 'C',
    photo: null
})

const emit = defineEmits(['registration'])

	const registration=async() => {
		const data = new FormData()
		
            data.append('photo', credentials.value.photo)
            data.append('email', credentials.value.email)
            data.append('name', credentials.value.name)
            data.append('password', credentials.value.password)
            data.append('type', credentials.value.type)
			data.append('password_confirmation', credentials.value.password_confirmation)
           /* if(!this.$store.state.user){
                data.append('password_confirmation', credentials.value.password_confirmation)
            }*/
            this.$emit('registration', data)
            /*credentials.value.password = '';
            credentials.value.password_confirmation = '';*/
	}
   /* mounted() {
        if(this.$store.state.user){
            this.inputForm.fullname = this.$store.state.user.name;
            this.inputForm.email = this.$store.state.user.email;
            this.inputForm.type = this.$store.state.user.type;
			this.inputForm.password = '';
            this.inputForm.password_confirmation = '';
        }
    }*/
</script>

<template>
<div class="col-md-6 pt-4 mt-3 mt-md-0">
            <h2 class="h4 mb-3">No account? Sign up</h2>
            <p class="fs-sm text-muted mb-4">Create account to enjoy earning points.</p>
            <form class="needs-validation" novalidate="">
              <div class="row gx-4 gy-3">
                <div class="col-sm-6">
                  <label class="form-label" for="reg-fn">Name</label>
                  <input class="form-control" type="text" required v-model="credentials.name"  id="reg-fn">
                  <div class="invalid-feedback">Please enter your name!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-email">E-mail Address</label>
                  <input class="form-control" type="email" required v-model="credentials.email"  id="reg-email">
                  <div class="invalid-feedback">Please enter valid email address!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-password">Password</label>
                  <input class="form-control" type="password" required v-model="credentials.password" id="reg-password">
                  <div class="invalid-feedback">Please enter password!</div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label" for="reg-password-confirm">Confirm Password</label>
                  <input class="form-control" type="password" required v-model="credentials.password_confirmation" id="reg-password-confirm">
                  <div class="invalid-feedback">Passwords do not match!</div>
                </div>
                <div class="col-12 text-end">
                  <button type="button" value="Sign Up" class="btn btn-primary" @click="registration">Sign Up<i class="ci-user me-2 ms-n1"></i></button>
                </div>
              </div>
            </form>
          </div>
</template>

<style scoped>
.col-md-6pt-4mt-3mt-md-0{
	height: 100%;
	display: flex;
	align-items: center;
	padding-top: 0px;
	padding-bottom: 0px;
	justify-content: center;
}
</style>

