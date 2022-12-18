<script setup>
	import {useOrdersStore} from "@/stores/order";
	import {ref} from "vue";

  const orderStore = useOrdersStore();
  orderStore.fetchOrders();
</script>

<template>
 <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Created at</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(order,index) of orderStore.orders" :key="index">
                    <td class="py-3">{{ order.total_price }}</td>
                    <!--<td class="py-3">{{ order.totalprice }}</td>
                    <td class="py-3">{{ order.pointsgained }}</td>
                    <td class="py-3">{{ order.pointsusedtopay }}</td>
                    <td class="py-3">{{ order.paymenttype }}</td>-->
                  </tr>
                </tbody>
              </table>
</template>

<style scoped>
</style>
