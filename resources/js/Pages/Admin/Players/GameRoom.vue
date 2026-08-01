<script setup>

import { router } from '@inertiajs/vue3'
import Echo from 'laravel-echo'
import { ref, onMounted, onUnmounted, watch } from 'vue'


const props = defineProps({

    game:Object,
    card:Array,
    drawnNumbers:Array,
    player:Object,
    winner:Object

})



const liveDrawnNumbers = ref(
    props.drawnNumbers ?? []
)



const gameWinner = ref(
    props.winner ?? null
)



// Update winner when Laravel sends new props
watch(
    () => props.winner,
    (value) => {

        gameWinner.value = value

    }
)




function claimBingo(){

    router.post(
        `/player/games/${props.game.id}/claim`,
        {},
        {
            preserveScroll:true
        }
    )

}




function isCalled(number){

    return liveDrawnNumbers.value.includes(
        Number(number)
    )

}




let channel = null



onMounted(()=>{


    channel = Echo.channel(
        `game.${props.game.id}`
    )



    channel.listen(
        '.number.drawn',
        (event)=>{


            console.log(
                'New number:',
                event.draw
            )



            const newNumber = Number(
                event.draw.number
            )



            if(
                !liveDrawnNumbers.value.includes(newNumber)
            ){

                liveDrawnNumbers.value.push(newNumber)

            }



            // Reload winner information
            router.reload({

                only:[
                    'winner'
                ],

                preserveScroll:true

            })


        }
    )



})





onUnmounted(()=>{


    if(channel){

        Echo.leave(
            `game.${props.game.id}`
        )

    }


})



</script>



<template>


<div class="min-h-screen bg-gray-100 p-6">


<div class="max-w-6xl mx-auto">



<!-- HEADER -->

<div
class="bg-gradient-to-r from-blue-700 to-purple-700 text-white rounded-2xl p-6 shadow"
>


<div class="flex justify-between">


<div>

<h1 class="text-3xl font-bold">
🎱 {{game.title}}
</h1>


<p class="mt-2">
Game Code: {{game.game_code}}
</p>


</div>



<div class="text-right">

<p class="text-xl">
Status
</p>


<span
class="bg-white/20 px-4 py-2 rounded-full"
>
{{game.status}}
</span>


</div>


</div>


</div>





<!-- WINNER NOTIFICATION -->

<div
v-if="gameWinner"
class="mt-6 bg-yellow-500 text-white rounded-xl p-5 text-center shadow-xl"
>

<h2 class="text-3xl font-bold">
🏆 WINNER
</h2>


<p class="text-xl mt-2">
{{gameWinner.user.name}}
</p>


<p>
Prize: {{gameWinner.prize_amount}}
</p>


</div>






<div class="grid lg:grid-cols-3 gap-6 mt-8">





<!-- BINGO CARD -->


<div
class="lg:col-span-2 bg-white rounded-2xl shadow p-6"
>


<h2 class="text-2xl font-bold mb-5">
My Bingo Card
</h2>




<!-- HEADER -->

<div class="grid grid-cols-5 gap-3 mb-3">


<div
v-for="letter in ['B','I','N','G','O']"
:key="letter"

class="h-12 bg-blue-700 text-white rounded-xl flex items-center justify-center font-bold text-xl"
>

{{letter}}

</div>


</div>





<!-- CARD NUMBERS -->

<div class="grid grid-cols-5 gap-3">


<template
v-for="(row,r) in card"
:key="r"
>


<div
v-for="(number,c) in row"
:key="c"


class="w-16 h-16 rounded-xl flex items-center justify-center text-xl font-bold transition"


:class="[

number === 'FREE'
?
'bg-yellow-400 text-white'

:

isCalled(number)
?
'bg-green-600 text-white scale-110'

:
'bg-gray-200'

]"

>


{{number}}


</div>


</template>


</div>





<button

@click="claimBingo"

class="mt-8 w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-xl text-xl font-bold"

>

🏆 CLAIM BINGO

</button>



</div>








<!-- LIVE NUMBERS -->


<div
class="bg-white rounded-2xl shadow p-6"
>


<h2 class="text-xl font-bold mb-5">

🔢 Called Numbers

</h2>




<div
class="flex flex-wrap gap-3"
>


<div

v-for="number in liveDrawnNumbers"

:key="number"

class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold"

>

{{number}}

</div>


</div>




<div
v-if="liveDrawnNumbers.length===0"
class="text-gray-500 mt-4"
>

Waiting for first number...

</div>



</div>






</div>



</div>


</div>


</template>