<script setup>
import { ref, watch, watchEffect, computed, inject } from "vue"

const axios = inject("axios")
const toast = inject("toast")

const props = defineProps({
  tasks: {
    type: Array,
    default: () => [],
  },
  showCreatedAt: {
    type: Boolean,
    default: true,
  },
  showTotalPrice: {
    type: Boolean,
    default: true,
  },
  showPointsGained: {
    type: Boolean,
    default: true,
  },
  showPointsUsedToPay: {
    type: Boolean,
    default: true,
  },
  showPaymentType: {
    type: Boolean,
    default: true,
  }
})

const emit = defineEmits(["completeToggled"])
</script>

<template>
 <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Created at</th>
                    <th>Total price</th>
                    <th>Points Gained</th>
                    <th>Points used to pay</th>
                    <th>Payment Type</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="order in editingOrders" :key="order.id">
                    <td class="py-3">{{ order.createdat }}</td>
                    <td class="py-3">{{ order.totalprice }}</td>
                    <td class="py-3">{{ order.pointsgained }}</td>
                    <td class="py-3">{{ order.pointsusedtopay }}</td>
                    <td class="py-3">{{ order.paymenttype }}</td>
                  </tr>
                </tbody>
              </table>
</template>

<style scoped>
</style>
