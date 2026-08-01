<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'

defineOptions({
    layout: AdminLayout
})

defineProps({
    totalGames: {
        type: Number,
        default: 0,
    },
    totalPlayers: {
        type: Number,
        default: 0,
    },
    totalPayments: {
        type: Number,
        default: 0,
    },
    totalWinners: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <Head title="Admin Dashboard" />

    <div class="space-y-8">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    🎱 Admin Dashboard
                </h1>
                <p class="text-gray-500 mt-1">
                    Welcome to Bingo Master Management System
                </p>
            </div>

            <div class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow">
                Administrator
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Games</p>
                        <h2 class="text-4xl font-bold mt-2">
                            {{ totalGames }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        🎮
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Players</p>
                        <h2 class="text-4xl font-bold mt-2">
                            {{ totalPlayers }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        👥
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Payments</p>
                        <h2 class="text-4xl font-bold mt-2">
                            {{ totalPayments }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        💰
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Winners</p>
                        <h2 class="text-4xl font-bold mt-2">
                            {{ totalWinners }}
                        </h2>
                    </div>

                    <div class="text-5xl">
                        🏆
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-xl font-bold mb-5">
                Quick Actions
            </h2>

            <div class="grid md:grid-cols-3 gap-5">

                <a
                    href="/admin/games"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6 text-center transition">

                    <div class="text-5xl mb-3">
                        🎮
                    </div>

                    <h3 class="font-bold text-lg">
                        Manage Games
                    </h3>

                </a>

                <a
                    href="/admin/players"
                    class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-6 text-center transition">

                    <div class="text-5xl mb-3">
                        👥
                    </div>

                    <h3 class="font-bold text-lg">
                        Players
                    </h3>

                </a>

                <a
                    href="/admin/payments"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl p-6 text-center transition">

                    <div class="text-5xl mb-3">
                        💰
                    </div>

                    <h3 class="font-bold text-lg">
                        Payments
                    </h3>

                </a>

            </div>

        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b p-5">
                <h2 class="text-xl font-bold">
                    Recent Activity
                </h2>
            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="text-left p-4">
                            Activity
                        </th>

                        <th class="text-left p-4">
                            Date
                        </th>

                        <th class="text-left p-4">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr class="border-t">

                        <td class="p-4">
                            New Game Created
                        </td>

                        <td class="p-4">
                            Today
                        </td>

                        <td class="p-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Completed
                            </span>
                        </td>

                    </tr>

                    <tr class="border-t">

                        <td class="p-4">
                            Payment Received
                        </td>

                        <td class="p-4">
                            Today
                        </td>

                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                Success
                            </span>
                        </td>

                    </tr>

                    <tr class="border-t">

                        <td class="p-4">
                            Winner Announced
                        </td>

                        <td class="p-4">
                            Yesterday
                        </td>

                        <td class="p-4">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                Finished
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</template>