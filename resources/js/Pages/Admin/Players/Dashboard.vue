<script setup>

import {Link} from '@inertiajs/vue3'


defineProps({

games:Array

})

</script>


<template>

<div class="p-6">


<h1 class="text-3xl font-bold mb-6">
🎱 Player Dashboard
</h1>



<div class="grid md:grid-cols-3 gap-5">


<div
v-for="game in games"
:key="game.id"
class="bg-white shadow rounded-xl p-5">


<h2 class="text-xl font-bold">
{{game.title}}
</h2>


<p>
🎟 ${{game.ticket_price}}
</p>


<Link
:href="`/player/games/${game.id}`"
class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded">

Join Game

</Link>


</div>


</div>


</div>

</template>