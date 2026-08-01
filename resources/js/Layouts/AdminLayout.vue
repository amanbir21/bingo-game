<script setup>

import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const page = usePage()


const currentUrl = computed(() => page.url)


</script>



<template>


<div class="min-h-screen bg-gray-100 flex">



<!-- SIDEBAR -->

<aside
class="w-72 bg-gradient-to-b from-gray-950 via-gray-900 to-blue-950 text-white shadow-xl">



<!-- Logo -->

<div
class="p-6 border-b border-white/10">


<div class="flex items-center gap-3">


<div
class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-2xl shadow-lg">

🎱

</div>



<div>

<h1 class="text-xl font-bold">

Bingo Master

</h1>


<p class="text-xs text-gray-400">

Admin Panel

</p>


</div>


</div>


</div>





<!-- Menu -->

<nav class="p-5 space-y-2">



<Link
href="/admin/dashboard"
:class="currentUrl === '/admin/dashboard'
?'bg-blue-600 shadow-lg'
:'hover:bg-white/10'"
class="flex items-center gap-3 px-4 py-3 rounded-xl transition">


<span>
🏠
</span>

Dashboard

</Link>





<Link
href="/admin/games"
:class="currentUrl.startsWith('/admin/games')
?'bg-blue-600 shadow-lg'
:'hover:bg-white/10'"
class="flex items-center gap-3 px-4 py-3 rounded-xl transition">


<span>
🎮
</span>

Games

</Link>





<Link
href="/admin/players"
class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">


<span>
👥
</span>

Players

</Link>





<Link
href="/admin/payments"
class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">


<span>
💰
</span>

Payments

</Link>





<Link
href="/admin/winners"
class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">


<span>
🏆
</span>

Winners

</Link>





<Link
href="/admin/settings"
class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">


<span>
⚙️
</span>

Settings

</Link>



</nav>






<!-- Bottom -->

<div
class="absolute bottom-0 w-72 p-5 border-t border-white/10">


<div
class="bg-white/10 rounded-xl p-3 flex items-center gap-3 mb-3">


<div
class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold">

A

</div>


<div>

<p class="font-bold">
Admin
</p>

<p class="text-xs text-gray-400">

Online

</p>

</div>


</div>



<Link
href="/logout"
method="post"
as="button"
class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-xl transition">

🚪 Logout

</Link>


</div>




</aside>







<!-- MAIN AREA -->


<div class="flex-1">





<!-- TOP HEADER -->

<header
class="bg-white shadow-sm px-8 py-5 flex justify-between items-center">



<div>


<h1 class="text-3xl font-bold text-gray-800">

Bingo Management

</h1>


<p class="text-gray-500">

Control your online bingo platform

</p>


</div>





<div class="flex items-center gap-4">


<button
class="bg-gray-100 p-3 rounded-xl hover:bg-gray-200">

🔔

</button>



<div
class="flex items-center gap-3 bg-gray-100 px-4 py-2 rounded-xl">


<div
class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">

A

</div>


<div>

<p class="font-bold text-sm">

Administrator

</p>


<p class="text-xs text-green-600">

● Online

</p>


</div>


</div>



</div>



</header>






<!-- PAGE CONTENT -->


<main class="p-8">


<slot />


</main>



</div>



</div>


</template>