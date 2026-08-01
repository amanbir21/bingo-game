<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'


defineOptions({
    layout: AdminLayout
})


const props = defineProps({

    games:{
        type:Array,
        default:()=>[]
    }

})


const search = ref('')
const status = ref('all')



const filteredGames = computed(()=>{

    return props.games.filter(game=>{


        let matchSearch =
        game.title
        ?.toLowerCase()
        .includes(search.value.toLowerCase())


        let matchStatus =
        status.value === 'all'
        ||
        game.status === status.value



        return matchSearch && matchStatus


    })

})



function deleteGame(id){

    if(confirm('Delete this bingo game?'))
    {
        router.delete(`/admin/games/${id}`)
    }

}


function statusColor(value){

    if(value==='running')
        return 'bg-green-100 text-green-700'

    if(value==='waiting')
        return 'bg-blue-100 text-blue-700'

    if(value==='finished')
        return 'bg-gray-200 text-gray-700'


    return 'bg-red-100 text-red-700'

}


</script>



<template>


<div>



<!-- HEADER -->

<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-4xl font-bold text-gray-800">

🎱 Bingo Games

</h1>


<p class="text-gray-500 mt-2">

Create, manage and monitor live bingo competitions

</p>


</div>



<Link
href="/admin/games/create"
class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition">

➕ New Game

</Link>


</div>







<!-- FILTER BAR -->


<div class="bg-white rounded-xl shadow p-5 mb-8 flex gap-4">


<input
v-model="search"
placeholder="🔍 Search game..."
class="border rounded-lg p-3 flex-1"
/>



<select
v-model="status"
class="border rounded-lg p-3">


<option value="all">
All Games
</option>


<option value="waiting">
Waiting
</option>


<option value="running">
Running
</option>


<option value="finished">
Finished
</option>


</select>


</div>








<!-- EMPTY -->

<div
v-if="filteredGames.length===0"
class="bg-white rounded-2xl shadow p-12 text-center">


<div class="text-7xl animate-bounce">

🎱

</div>


<h2 class="text-3xl font-bold mt-5">

No Games Found

</h2>


<p class="text-gray-500 mt-2">

Create a new bingo game and start receiving players.

</p>


<Link
href="/admin/games/create"
class="inline-block mt-6 bg-blue-600 text-white px-8 py-3 rounded-xl">

Create Game

</Link>


</div>







<!-- GAME CARDS -->


<div
class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">



<div
v-for="game in filteredGames"
:key="game.id"
class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition hover:-translate-y-1 overflow-hidden">





<!-- TOP -->

<div
class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5">


<div class="flex justify-between">


<h2 class="text-xl font-bold">

{{game.title}}

</h2>


<span
class="px-3 py-1 rounded-full text-sm bg-white/20">

{{game.status}}

</span>


</div>


<p class="mt-2 opacity-80">

Code:
{{game.game_code}}

</p>


</div>







<div class="p-6">



<div class="grid grid-cols-2 gap-4">



<div class="bg-gray-100 rounded-xl p-4">

<p class="text-gray-500">

🎟 Ticket

</p>

<h3 class="text-xl font-bold">

${{game.ticket_price}}

</h3>

</div>





<div class="bg-gray-100 rounded-xl p-4">

<p class="text-gray-500">

💰 Prize

</p>

<h3 class="text-xl font-bold">

${{game.prize_pool ?? 0}}

</h3>

</div>


</div>







<!-- PLAYER BAR -->


<div class="mt-5">


<div class="flex justify-between mb-2">

<span>

👥 Players

</span>


<span>

{{game.players_count ?? 0}}
/
{{game.maximum_players}}

</span>


</div>



<div class="h-3 bg-gray-200 rounded-full">


<div
class="h-3 bg-blue-600 rounded-full transition-all"
:style="{
width:
((game.players_count ?? 0)
/
game.maximum_players*100)+'%'
}">

</div>


</div>


</div>







<div class="mt-6 flex gap-3">


<Link
:href="`/admin/games/${game.id}`"
class="flex-1 text-center bg-green-600 text-white py-2 rounded-lg">

View

</Link>



<Link
:href="`/admin/games/${game.id}/edit`"
class="flex-1 text-center bg-yellow-500 text-white py-2 rounded-lg">

Edit

</Link>


</div>




<button
@click="deleteGame(game.id)"
class="mt-3 w-full bg-red-600 text-white py-2 rounded-lg">

🗑 Delete Game

</button>



</div>




</div>



</div>


</div>


</template>