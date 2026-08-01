<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({
    layout: AdminLayout
})


const form = useForm({

    title: '',

    description: '',

    ticket_price: 20,

    prize_percentage: 80,

    minimum_players: 10,

    maximum_players: 100,

    draw_interval: 5,

    started_at: ''

})


function submit(){

    form.post('/admin/games')

}

</script>



<template>

<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-white to-purple-100 p-6">


<div class="max-w-5xl mx-auto grid lg:grid-cols-3 gap-6">



<!-- FORM CARD -->

<div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-8 border">


<div class="mb-8">

<h1 class="text-4xl font-extrabold text-gray-800">

🎱 Create Bingo Game

</h1>

<p class="text-gray-500 mt-2">

Setup a new bingo event and manage prizes.

</p>

</div>





<form
@submit.prevent="submit"
class="space-y-6">





<!-- Title -->

<div>

<label class="font-semibold text-gray-700">

🎮 Game Title

</label>


<input

v-model="form.title"

placeholder="Friday Night Bingo"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
shadow-sm
focus:ring-2
focus:ring-indigo-500
"

>


</div>







<!-- Description -->

<div>

<label class="font-semibold text-gray-700">

📝 Description

</label>


<textarea

v-model="form.description"

rows="4"

placeholder="Describe your bingo game..."

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
shadow-sm
focus:ring-2
focus:ring-indigo-500
"

></textarea>


</div>








<!-- Price -->

<div class="grid md:grid-cols-2 gap-5">


<div>

<label class="font-semibold">

💰 Ticket Price

</label>


<input

type="number"

v-model="form.ticket_price"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
focus:ring-2
focus:ring-green-500
"

/>


</div>






<div>

<label class="font-semibold">

🏆 Prize Percentage %

</label>


<input

type="number"

v-model="form.prize_percentage"

min="0"

max="100"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
focus:ring-2
focus:ring-yellow-500
"

/>


</div>


</div>










<!-- Players -->

<div class="grid md:grid-cols-2 gap-5">


<div>

<label class="font-semibold">

👥 Minimum Players

</label>


<input

type="number"

v-model="form.minimum_players"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
"

/>


</div>





<div>

<label class="font-semibold">

👥 Maximum Players

</label>


<input

type="number"

v-model="form.maximum_players"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
"

/>


</div>


</div>









<!-- Draw -->

<div>

<label class="font-semibold">

🎲 Draw Interval (seconds)

</label>


<input

type="number"

v-model="form.draw_interval"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
"

/>


</div>









<!-- Date -->

<div>

<label class="font-semibold">

⏰ Start Time

</label>


<input

type="datetime-local"

v-model="form.started_at"

class="
mt-2
w-full
rounded-xl
border-gray-300
p-3
"

/>


</div>










<button

:disabled="form.processing"

class="
w-full
bg-gradient-to-r
from-green-500
to-emerald-600
text-white
font-bold
py-4
rounded-xl
shadow-lg
hover:scale-[1.02]
transition
"

>


<span v-if="!form.processing">

🚀 Create Bingo Game

</span>


<span v-else>

Creating...

</span>


</button>





</form>


</div>







<!-- PREVIEW CARD -->

<div class="
bg-gradient-to-br
from-indigo-600
to-purple-700
rounded-3xl
shadow-xl
text-white
p-6
h-fit
">


<h2 class="text-2xl font-bold mb-5">

🎱 Preview

</h2>



<div class="space-y-4 text-lg">


<div>

🎮

<span class="font-semibold">

{{form.title || 'Game Title'}}

</span>

</div>



<div>

💰 Ticket:

{{form.ticket_price}}

</div>



<div>

🏆 Prize:

{{form.prize_percentage}}%

</div>



<div>

👥 Players:

{{form.minimum_players}}

-

{{form.maximum_players}}

</div>



<div>

⏱ Draw:

{{form.draw_interval}} sec

</div>



</div>





<div class="
mt-8
bg-white/20
rounded-xl
p-4
">


<p class="text-sm">

Prize is calculated automatically:

</p>


<p class="font-bold text-xl">

Ticket Sales × {{form.prize_percentage}}%

</p>


</div>



</div>





</div>


</div>


</template>