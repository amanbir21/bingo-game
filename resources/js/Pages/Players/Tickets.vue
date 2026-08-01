<script setup>
import { onMounted, onUnmounted } from 'vue'
//import { router } from '@inertiajs/vue3'
import { Head, Link, router } from '@inertiajs/vue3'
import axios from 'axios'


defineProps({
    tickets: {
        type: Array,
        default: () => []
    }
})

const changeTicket = async (gameId) => {

    if (!confirm('Are you sure you want to change your ticket?')) {
        return
    }

    try {

        const response = await axios.post(
            route('player.games.change-ticket', {
                game: gameId
            })
        )


        console.log(response.data)


        if(response.data.success){

            alert(response.data.message)

            router.reload()

        }else{

            alert(response.data.message)

        }


    } catch(error){

        console.log("ERROR:", error)

        console.log("STATUS:", error.response?.status)

        console.log("DATA:", error.response?.data)


        alert(
            error.response?.data?.message 
            ?? 'Failed to change ticket.'
        )

    }

}


let refresh = null

onMounted(() => {
    refresh = setInterval(() => {
        router.reload({
            only: ['tickets'],
            preserveScroll: true,
            preserveState: true,
        })
    }, 5000) // refresh every 5 seconds
})

onUnmounted(() => {
    clearInterval(refresh)
})
</script>


<template>

<Head title="My Tickets" />


<div class="min-h-screen bg-gray-100">


<!-- Header -->

<div class="bg-blue-700 text-white shadow">

<div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">


<div>

<h1 class="text-3xl font-bold">
🎫 My Tickets
</h1>

<p class="text-blue-100">
View all your purchased bingo tickets
</p>

</div>


<Link
:href="route('player.dashboard')"
class="bg-white text-blue-700 px-5 py-2 rounded-lg font-semibold"
>
← Dashboard
</Link>


</div>

</div>





<div class="max-w-7xl mx-auto p-6">



<!-- Summary -->

<div class="bg-white rounded-2xl shadow p-6 mb-6">

<div class="flex justify-between items-center">


<div>

<h2 class="text-2xl font-bold">
My Bingo Tickets
</h2>


<p class="text-gray-500">
Total Tickets: {{ tickets.length }}
</p>


</div>


<div class="text-6xl">
🎟
</div>


</div>

</div>







<!-- Tickets -->


<div
v-if="tickets.length"
class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
>



<div
v-for="ticket in tickets"
:key="ticket.id"
class="bg-white rounded-2xl shadow-lg overflow-hidden"
>



<!-- Header -->


<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-5">


<h2 class="text-2xl font-bold">
{{ ticket.game.title }}
</h2>


<p class="text-blue-100">
{{ ticket.ticket_number }}
</p>


<p class="text-yellow-200 text-sm mt-2">
Status: {{ ticket.game.status }}
</p>


</div>







<div class="p-5 space-y-4">



<!-- Result -->


<div class="flex justify-between items-center">


<span class="text-gray-500">
Result
</span>



<span
v-if="ticket.winner"
class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold"
>
🏆 WIN ${{ ticket.winner.prize_amount }}
</span>



<span
v-else-if="ticket.game.status === 'finished'"
class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold"
>
❌ LOSS
</span>



<span
v-else
class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold"
>
🎮 PLAYING
</span>


</div>







<div class="flex justify-between">

<span class="text-gray-500">
Ticket Price
</span>


<span class="font-bold">
${{ ticket.ticket_price }}
</span>


</div>







<div class="flex justify-between">

<span class="text-gray-500">
Joined
</span>


<span>
{{ ticket.joined_at }}
</span>


</div>








<!-- Buttons -->


<div class="mt-5 space-y-3">





<!-- Enter Game Room -->


<Link
v-if="ticket.game.status !== 'finished'"
:href="route('player.games.show', ticket.game.id)"
class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-bold"
>
🎮 Enter Game Room
</Link>







<!-- Change Ticket -->


<button
@click="changeTicket(ticket.game.id)"
class="block w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-bold"
>
🎲 Change Ticket
</button>






<!-- Finished -->


<div
v-if="ticket.game.status === 'finished'"
class="block w-full bg-gray-400 text-white text-center py-3 rounded-xl font-bold"
>
✅ Game Finished
</div>




</div>




</div>




</div>



</div>







<!-- Empty -->


<div
v-else
class="bg-white rounded-2xl shadow p-12 text-center"
>


<div class="text-7xl mb-5">
🎫
</div>


<h2 class="text-2xl font-bold">
No Tickets Yet
</h2>


<p class="text-gray-500 mt-2">
Join a bingo game to receive your first ticket.
</p>



<Link
:href="route('player.dashboard')"
class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold"
>
🎱 Browse Games
</Link>



</div>



</div>


</div>


</template>