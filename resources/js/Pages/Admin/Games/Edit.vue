<script setup>

import {useForm} from '@inertiajs/vue3'


const props = defineProps({
game:Object
})


const form=useForm({

name:props.game.name,
ticket_price:props.game.ticket_price,
max_players:props.game.max_players,
start_time:props.game.start_time

})


function update(){

form.put(`/admin/games/${props.game.id}`)

}


</script>



<template>

<div class="p-6">


<h1 class="text-2xl font-bold">
Edit Game
</h1>


<form @submit.prevent="update">


<input v-model="form.name"
class="border p-2 w-full">


<button class="bg-blue-600 text-white p-2 mt-3">
Update
</button>


</form>


</div>

</template>