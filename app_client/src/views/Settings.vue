<script setup>
	import {useRouter, RouterLink} from "vue-router"
	import {inject} from "vue"
	import {useUserStore} from "@/stores/user";
  import SettingsBar from "../components/navigation/SettingsBar.vue"
  import Account from "../components/settings/Account.vue"


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
            <router-view></router-view>
        </div>
      </div>
   </div>
</template>