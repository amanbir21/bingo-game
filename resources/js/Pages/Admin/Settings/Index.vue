<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'


defineOptions({

    layout: AdminLayout

})


defineProps({

    settings:Array

})


</script>



<template>


<div class="min-h-screen bg-gray-100 p-6">


<div class="max-w-5xl mx-auto">


<h1 class="text-3xl font-bold mb-6">
⚙️ System Settings
</h1>



<div class="bg-white shadow rounded-xl p-6">


<div
v-for="setting in settings"
:key="setting.id"
class="mb-5"
>


<label class="block font-semibold mb-2">

{{ setting.key }}

</label>



<input

:value="setting.value"

class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"

>



</div>


</div>


</div>


</div>


</template>