<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'


defineOptions({

    layout: AdminLayout

})


defineProps({

    payments:Array

})

</script>


<template>

<div class="min-h-screen bg-gray-100 p-6">


<div class="max-w-6xl mx-auto">


<h1 class="text-3xl font-bold mb-6">
💳 Payments
</h1>



<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">
User
</th>

<th class="p-4 text-left">
Amount
</th>

<th class="p-4 text-left">
Status
</th>

</tr>

</thead>



<tbody>


<tr
v-for="payment in payments"
:key="payment.id"
class="border-t hover:bg-gray-50"
>


<td class="p-4">

{{ payment.user?.name }}

</td>


<td class="p-4 font-semibold">

${{ payment.amount }}

</td>


<td class="p-4">


<span
:class="
payment.status === 'completed'
? 'bg-green-100 text-green-700'
: 'bg-yellow-100 text-yellow-700'
"
class="px-3 py-1 rounded-full text-sm"
>

{{ payment.status }}

</span>


</td>


</tr>


</tbody>


</table>


</div>


</div>


</div>


</template>