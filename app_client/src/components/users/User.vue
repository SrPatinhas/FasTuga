<script setup>
  import { ref, watch, inject } from 'vue'
  import { useUserStore } from "@/stores/user";
  import UserDetail from "./UserDetail.vue"
  import { useRouter, onBeforeRouteLeave } from 'vue-router'  
  
  const router = useRouter()  
  const axios = inject('axios')
  const socket = inject("socket")
  const toast = inject('toast')
  const userStore = useUserStore()
  
  const newUser = () => {
      return {
        id: null,
        name: '',
        email: '',
        gender: 'M',
        photo_url: null
      }
  }

  const user = ref(newUser())
  const errors = ref(null)
  const confirmationLeaveDialog = ref(null)


  const props = defineProps({
      id: {
        type: Number,
        default: null
      }
  })

  let originalValueStr = ''
  const loadUser = (id) => {    
    originalValueStr = ''
      errors.value = null
      if (!id || (id < 0)) {
        user.value = newUser()
        originalValueStr = dataAsString()
      } else {
        axios.get('users/' + id)
          .then((response) => {
            user.value = response.data.data
            originalValueStr = dataAsString()
          })
          .catch((error) => {
            console.log(error)
          })
      }
  }

  const save = () => {
      errors.value = null
      axios.put('users/' + props.id, user.value)
        .then((response) => {
          user.value = response.data.data
          socket.emit('updateUser', user.value)
          if (user.value.id == userStore.user.id) {
            userStore.user = user.value 
          }
          originalValueStr = dataAsString()
          toast.success('User #' + user.value.id + ' was updated successfully.')
          router.back()
        })
        .catch((error) => {
          if (error.response.status == 422) {
              toast.error('User #' + props.id + ' was not updated due to validation errors!')
              errors.value = error.response.data.errors
            } else {
              toast.error('User #' + props.id + ' was not updated due to unknown server error!')
            }
        })
  }

  const cancel = () => {
    originalValueStr = dataAsString()
    router.back()
  }

  const dataAsString = () => {
      return JSON.stringify(user.value)
  }

  let nextCallBack = null
  const leaveConfirmed = () => {
      if (nextCallBack) {
        nextCallBack()
      }
  }

  onBeforeRouteLeave((to, from, next) => {
    nextCallBack = null
    let newValueStr = dataAsString()
    if (originalValueStr != newValueStr) {
      nextCallBack = next
      confirmationLeaveDialog.value.show()
    } else {
      next()
    }
  })  

  watch(
    () => props.id,
    (newValue) => {
        loadUser(newValue)
      },
    {immediate: true}  
    )

</script>

<template>
  <confirmation-dialog
    ref="confirmationLeaveDialog"
    confirmationBtn="Discard changes and leave"
    msg="Do you really want to leave? You have unsaved changes!"
    @confirmed="leaveConfirmed"
  >
  </confirmation-dialog>  

  <user-detail
    :user="user"
    :errors="errors"
    @save="save"
    @cancel="cancel"
  ></user-detail>
</template>
