<script setup>

import { Head, router } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref, watch } from 'vue'


const props = defineProps({

    game:Object,
    card:Array,
    drawnNumbers:Array,
    winner:Object,
    noWinner:Boolean

})



const numbers = ref(
    props.drawnNumbers ?? []
)


const winnerData = ref(
    props.winner ?? null
)
const noWinnerData = ref(
    props.noWinner ?? false
)

const gameFinished = ref(
    props.game.status === 'finished'
)


let timer = null




// Update drawn numbers
watch(
    () => props.drawnNumbers,
    (value)=>{

        console.log(
            "Drawn Numbers:",
            value
        )

        numbers.value = [
            ...(value ?? [])
        ]

    },
    {
        immediate:true
    }
)





// Update winner automatically
watch(
    () => props.winner,
    (value)=>{

        console.log(
            "Winner:",
            value
        )

        winnerData.value = value

    },
    {
        immediate:true
    }
)





// Game status watcher
watch(
    () => props.game.status,
    (status)=>{


        console.log(
            "Game Status:",
            status
        )


        if(status === 'finished'){

            gameFinished.value = true


            if(timer){

                clearInterval(timer)

            }

        }


    },
    {
        immediate:true
    }
)

watch(
    () => props.noWinner,
    (value)=>{

        console.log("No Winner:", value)

        noWinnerData.value = Boolean(value)

    },
    {
        immediate:true
    }
)


onMounted(()=>{


    timer = setInterval(()=>{


       router.reload({

    only:[
        'game',
        'drawnNumbers',
        'winner',
        'noWinner'
    ],

    preserveState:false,

    preserveScroll:true

})


    },5000)



})







onUnmounted(()=>{


    if(timer){

        clearInterval(timer)

    }


})






function isDrawn(number){


    return numbers.value.includes(
        Number(number)
    )


}





function claim(){


    router.post(

        route(
            'player.claim',
            props.game.id
        ),

        {},

        {

            preserveScroll:true

        }

    )


}


</script>





<template>


<Head title="Bingo Room"/>


<div class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-200 p-6">


<div class="max-w-5xl mx-auto">





<!-- HEADER -->

<div
class="bg-blue-700 text-white rounded-2xl shadow p-6 mb-6"
>


<h1 class="text-4xl font-bold">

🎱 {{game.title}}

</h1>


<p class="mt-2">

Game Code:

{{game.game_code}}

</p>



<p class="mt-2">

Status:

<span class="font-bold">

{{game.status}}

</span>

</p>


</div>







<!-- FINISHED -->
<div
v-if="gameFinished && !winnerData && !noWinnerData"

class="mb-6 bg-green-600 text-white p-4 rounded-xl text-center shadow-lg"

>

🎉 Bingo Game Finished!

<br>

Checking winner...

</div>



<div
v-else-if="noWinnerData"

class="mb-6 bg-red-600 text-white p-6 rounded-xl text-center shadow-lg"

>

<h2 class="text-3xl font-bold">
❌ NO WINNER
</h2>

<p class="mt-2 text-lg">
All players lost. No bingo pattern was completed.
</p>

</div>






<!-- WINNER -->

<div

v-if="winnerData"

class="mb-6 bg-yellow-500 text-white p-6 rounded-xl text-center shadow-xl"

>


<h2 class="text-3xl font-bold">

🏆 WINNER

</h2>



<p
v-if="winnerData.user"
class="text-2xl mt-3"
>

{{winnerData.user.name}}

</p>



<p class="mt-2">

Prize:

<strong>

${{winnerData.prize_amount}}

</strong>

</p>


</div>









<!-- BINGO CARD -->


<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-2xl font-bold text-center mb-5">

Your Bingo Card

</h2>





<div class="grid grid-cols-5 gap-3 mb-3">


<div

v-for="letter in ['B','I','N','G','O']"

:key="letter"

class="bg-blue-700 text-white h-12 flex items-center justify-center rounded-xl font-bold text-xl"

>

{{letter}}

</div>


</div>





<div class="grid grid-cols-5 gap-3">


<template

v-for="(row,r) in card"

:key="r"

>


<div

v-for="(number,c) in row"

:key="c"

class="h-16 flex items-center justify-center rounded-xl text-xl font-bold shadow"


:class="[

number === 'FREE'

?

'bg-yellow-400 text-white'


:


isDrawn(number)

?

'bg-green-500 text-white scale-110'


:

'bg-blue-100'

]"


>

{{number}}

</div>


</template>


</div>



</div>









<!-- DRAWN NUMBERS -->


<div class="mt-6 bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold">

🎯 Drawn Numbers

</h2>



<div class="flex flex-wrap gap-3 mt-4">


<span

v-for="num in numbers"

:key="num"

class="bg-red-600 text-white px-4 py-2 rounded-full font-bold"

>

{{num}}

</span>


</div>



<div

v-if="numbers.length===0"

class="text-gray-500 mt-4"

>

Waiting for first number...

</div>


</div>








<!-- CLAIM -->


<button

@click="claim"

class="mt-6 w-full bg-yellow-500 hover:bg-yellow-600 text-white text-xl font-bold py-4 rounded-2xl shadow"

>


🎉 Claim Bingo


</button>



</div>


</div>


</template>