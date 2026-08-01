<script setup>

import { Link, usePage, router } from '@inertiajs/vue3'


const page = usePage()


defineProps({
    games: {
        type: Array,
        default: () => []
    },
    canLogin: Boolean,
    canRegister: Boolean
})


function logout(){

    router.post('/logout')

}


</script>


<template>

<div class="min-h-screen bg-gray-100">


<!-- Header -->

<header class="bg-blue-700 text-white p-5 shadow">

<div class="max-w-6xl mx-auto flex justify-between items-center">


<h1 class="text-3xl font-bold">
🎱 Bingo Master
</h1>


<nav class="flex gap-3">

<!-- Guest User -->

<template v-if="!page.props.auth?.user">

    <Link
        href="/login"
        class="px-5 py-2 bg-white text-blue-700 rounded-lg font-semibold hover:bg-gray-100"
    >
        Login
    </Link>


    <Link
        v-if="canRegister"
        href="/register"
        class="px-5 py-2 bg-yellow-400 text-black rounded-lg font-semibold hover:bg-yellow-300"
    >
        Register
    </Link>

</template>



<!-- Logged User -->

<template v-else>

    <Link
        v-if="page.props.auth.user.role === 'admin'"
        href="/admin/dashboard"
        class="px-5 py-2 bg-white text-blue-700 rounded-lg font-semibold"
    >
        Admin Dashboard
    </Link>


    <Link
        v-else
        href="/player/dashboard"
        class="px-5 py-2 bg-white text-blue-700 rounded-lg font-semibold"
    >
        Player Dashboard
    </Link>


    <button
        @click="logout"
        class="px-5 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600"
    >
        Logout
    </button>

</template>


</nav>


</div>

</header>




<!-- Hero Section -->

<section class="text-center py-20">


<h2 class="text-5xl font-bold text-gray-800">

Play Online Bingo & Win Prizes 🎉

</h2>


<p class="mt-5 text-xl text-gray-600">

Join exciting bingo games and compete with players worldwide.

</p>



<Link
href="/register"
class="inline-block mt-8 bg-green-600 text-white px-10 py-3 rounded-lg text-lg hover:bg-green-700">

Start Playing

</Link>


</section>





<!-- Available Games -->

<section class="max-w-6xl mx-auto px-6 pb-16">


<h2 class="text-3xl font-bold mb-8">

Available Games 🎲

</h2>



<div
v-if="games.length"
class="grid md:grid-cols-3 gap-6">


<div
v-for="game in games"
:key="game.id"
class="bg-white shadow-lg rounded-xl p-6">


<h3 class="text-2xl font-bold text-blue-700">

{{ game.title }}

</h3>



<p class="mt-3">

🎟 Ticket:
<strong>
${{ game.ticket_price }}
</strong>

</p>



<p>

👥 Players:

{{ game.players_count ?? 0 }}

/

{{ game.maximum_players }}

</p>



<span
class="inline-block mt-4 px-4 py-1 rounded-full bg-green-100 text-green-700">

{{ game.status }}

</span>


</div>


</div>



<div
v-else
class="bg-white p-8 rounded shadow text-center">

<h3 class="text-xl">

No games available now

</h3>

<p class="text-gray-500 mt-2">

Please check again later.

</p>


</div>


</section>





<!-- How To Play -->

<section class="bg-white py-12">


<div class="max-w-5xl mx-auto px-6">


<h2 class="text-3xl font-bold text-center">

How To Play Bingo

</h2>



<div class="grid md:grid-cols-3 gap-6 mt-10">



<div class="p-6 shadow rounded-xl">

<h3 class="text-xl font-bold">

1️⃣ Register

</h3>


<p class="mt-2 text-gray-600">

Create your player account.

</p>

</div>




<div class="p-6 shadow rounded-xl">

<h3 class="text-xl font-bold">

2️⃣ Join Game

</h3>


<p class="mt-2 text-gray-600">

Buy tickets and enter a live bingo game.

</p>

</div>




<div class="p-6 shadow rounded-xl">

<h3 class="text-xl font-bold">

3️⃣ Win Prize

</h3>


<p class="mt-2 text-gray-600">

Match numbers and become the winner.

</p>

</div>



</div>


</div>


</section>





<footer class="bg-gray-900 text-white text-center p-5">


© 2026 Bingo Master


</footer>


</div>

</template>