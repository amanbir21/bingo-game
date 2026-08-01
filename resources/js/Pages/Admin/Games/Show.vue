<script setup>

import { ref, onUnmounted } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'


defineOptions({
    layout: AdminLayout
})


const props = defineProps({
    game:Object,
    players:Array,
    drawnNumbers:Array,
    winner:Object,
    noWinner:Boolean
})


const drawing = ref(false)


const liveDrawnNumbers = ref([
    ...(props.drawnNumbers ?? [])
])


const winnerData = ref(
    props.winner ?? null
)


let timer = null



function startGame(){

    router.post(
        `/admin/games/${props.game.id}/start`,
        {},
        {

            preserveScroll:true,

            onSuccess(){

                liveDrawnNumbers.value = []

                winnerData.value = null

                router.reload({

                    only:[
                        'game',
                        'drawnNumbers',
                        'winner'
                    ],

                    preserveState:false,

                    preserveScroll:true

                })

            }

        }
    )

}





async function draw(){

    try {

        const response = await axios.post(
            `/admin/games/${props.game.id}/draw`
        )


        console.log(response.data)



        // add new number
        if(response.data.draw){

            liveDrawnNumbers.value.push(
                response.data.draw
            )

        }



        // winner found
        if(response.data.finished){

            stopAutoDraw()


            if(response.data.winner){

                winnerData.value = response.data.winner

            }


            router.reload({

                only:[
                    'game',
                    'winner',
                    'drawnNumbers',
                    'noWinner'
                ],

                preserveScroll:true,

                preserveState:false

            })


        }



    }
    catch(error){

        console.log(error.response)

        stopAutoDraw()

    }

}





function startAutoDraw(){

    if(drawing.value) return


    drawing.value = true



    draw()



    timer = setInterval(()=>{


        if(drawing.value){

            draw()

        }


    }, props.game.draw_interval * 1000)

}





function stopAutoDraw(){


    drawing.value = false



    if(timer){

        clearInterval(timer)

        timer=null

    }

}





function finishGame(){


    stopAutoDraw()



    router.post(

        `/admin/games/${props.game.id}/finish`,

        {},

        {

            onSuccess(){

                router.reload()

            }

        }

    )


}





onUnmounted(()=>{

    stopAutoDraw()

})


</script>




<template>


<div>



<!-- HEADER -->

<div class="flex justify-between items-center mb-8">


<div>

<h1 class="text-4xl font-bold">

🎱 {{game.title}}

</h1>


<p class="text-gray-500">

Game Code:
{{game.game_code}}

</p>


</div>




<div>

<span
class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-bold">

{{game.status}}

</span>

</div>


</div>






<!-- CONTROL -->

<div class="bg-white rounded-2xl shadow p-6 mb-8">


<h2 class="text-xl font-bold mb-5">
Game Control
</h2>



<div class="flex flex-wrap gap-4">



<button
@click="startGame"
class="bg-green-600 text-white px-6 py-3 rounded-xl">

▶ Start Game

</button>




<button
@click="startAutoDraw"
:disabled="drawing"
class="bg-blue-600 disabled:bg-gray-400 text-white px-6 py-3 rounded-xl">

{{drawing ? '🎲 Drawing...' : '🎲 Auto Draw'}}

</button>




<button
@click="stopAutoDraw"
class="bg-yellow-500 text-white px-6 py-3 rounded-xl">

⏸ Stop

</button>




<button
@click="finishGame"
class="bg-red-600 text-white px-6 py-3 rounded-xl">

🏁 Finish

</button>



</div>


</div>







<div class="grid md:grid-cols-3 gap-6">






<!-- LAST NUMBER -->


<div
class="bg-gradient-to-br from-purple-600 to-blue-600 text-white rounded-2xl p-8 text-center"
>


<p class="text-xl">
Last Number
</p>


<h1 class="text-7xl font-bold mt-5">


{{

liveDrawnNumbers.length

?

liveDrawnNumbers[liveDrawnNumbers.length-1].number

:

'-'

}}


</h1>


</div>








<!-- PLAYERS -->


<div
class="bg-white rounded-2xl shadow p-6"
>


<h2 class="text-xl font-bold mb-4">

👥 Players

</h2>



<div
v-for="player in players"
:key="player.id"
class="flex justify-between border-b py-3"
>


<span>
{{player.name}}
</span>


<span class="text-green-600">
Joined
</span>


</div>


</div>








<!-- WINNER -->


<div
class="bg-white rounded-2xl shadow p-6"
>


<h2 class="text-xl font-bold mb-4">

🏆 Winner

</h2>




<div v-if="winnerData">



<h3 class="text-2xl font-bold text-green-600">

{{winnerData.user?.name ?? 'Unknown'}}

</h3>



<p class="mt-3">

🎯 Pattern:

<b>

{{winnerData.pattern?.name ?? 'Bingo'}}

</b>

</p>



<p class="mt-3">

💰 Prize:

<b>

${{winnerData.prize_amount}}

</b>

</p>



</div>




<div v-else-if="noWinner">

<h3 class="text-2xl font-bold text-red-600">
❌ No Winner
</h3>

<p class="text-gray-500">
All players lost. No bingo pattern completed.
</p>

</div>


<div v-else>

<p class="text-gray-500">
Waiting for winner...
</p>

</div>


</div>





</div>








<!-- DRAW HISTORY -->


<div
class="mt-8 bg-white rounded-2xl shadow p-6"
>


<h2 class="text-xl font-bold mb-5">

🔢 Drawn Numbers

</h2>




<div class="flex flex-wrap gap-3">


<div

v-for="number in liveDrawnNumbers"

:key="number.draw_order"

class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-bold"

>

{{number.column}}-{{number.number}}


</div>


</div>



</div>






</div>


</template>