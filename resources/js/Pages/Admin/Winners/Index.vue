<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'


defineOptions({

    layout: AdminLayout

})


defineProps({

    winners:Array

})

</script>


<template>

<div class="min-h-screen bg-gray-100 p-6">


<div class="max-w-6xl mx-auto">


<h1 class="text-3xl font-bold mb-6">
🏆 Winners
</h1>



<div class="bg-white rounded-xl shadow overflow-hidden">


<table class="w-full">


<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">
Player
</th>

<th class="p-4 text-left">
Game
</th>

<th class="p-4 text-left">
Prize
</th>

</tr>

</thead>



<tbody>

<tr
v-for="winner in winners"
:key="winner.id"
class="border-t hover:bg-gray-50"
>

<td class="p-4">
    {{ winner.user?.name }}
</td>


<td class="p-4">
    {{ winner.game?.title }}
</td>


<td class="p-4 font-bold text-green-600">
    ${{ winner.prize_amount }}
</td>

</tr>

</tbody>


</table>


</div>


</div>


</div>


</template>