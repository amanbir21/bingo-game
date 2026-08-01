<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'


defineOptions({

    layout: AdminLayout

})


defineProps({

    players: Array

})

</script>


<template>

<div class="min-h-screen bg-gray-100 p-6">


<div class="max-w-6xl mx-auto">


<h1 class="text-3xl font-bold mb-6">
👥 Players
</h1>



<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-gray-100">

<tr>

<th class="text-left p-4">
Name
</th>

<th class="text-left p-4">
Email
</th>

<th class="text-left p-4">
Status
</th>

</tr>

</thead>



<tbody>


<tr
v-for="player in players"
:key="player.id"
class="border-t hover:bg-gray-50"
>


<td class="p-4">
{{ player.name }}
</td>


<td class="p-4">
{{ player.email }}
</td>


<td class="p-4">


<span
v-if="player.is_active"
class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

Active

</span>


<span
v-else
class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

Blocked

</span>


</td>


</tr>


</tbody>


</table>


</div>


</div>


</div>

</template>