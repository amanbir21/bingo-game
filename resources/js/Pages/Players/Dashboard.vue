<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
console.log(page.props.flash)
    const props = defineProps({
    activeGames: {
        type: Number,
        default: 0,
    },

    tickets: {
        type: Number,
        default: 0,
    },

    winnings: {
        type: Number,
        default: 0,
    },

    games: {
        type: Array,
        default: () => [],
    },

    recentGames: {
        type: Array,
        default: () => [],
    },

    wallet: {
        type: Object,
        default: () => ({
            balance: 0,
            deposit: 0,
            withdraw: 0,
        }),
    },
})
</script>

<template>
    <Head title="Player Dashboard" />

    <div class="min-h-screen bg-gray-100">

        <!-- Header -->
        <div class="bg-blue-700 text-white shadow">
            <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold">🎱 Player Dashboard</h1>
                    <p class="text-blue-100">
                        Welcome to Bingo Master
                    </p>
                </div>

                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-lg">
                    Logout
                </Link>
            </div>
        </div>
<div
    v-if="page.props.flash?.error"
    class="bg-red-100 text-red-700 p-4 rounded-lg mb-5"
>
    {{ page.props.flash.error }}
</div>


<div
    v-if="page.props.flash?.success"
    class="bg-green-100 text-green-700 p-4 rounded-lg mb-5"
>
    {{ page.props.flash.success }}
</div>
      <div class="max-w-7xl mx-auto p-6">


<!-- WALLET TOP -->

<div class="mb-8 bg-green-600 text-white rounded-xl shadow p-6">


    <div class="flex justify-between items-center">


        <div>

            <p class="text-lg">
                💰 Wallet Balance
            </p>


            <h2 class="text-4xl font-bold mt-2">
                ${{ wallet.balance }}
            </h2>


            <p class="text-green-100 mt-2">
                Available balance
            </p>


        </div>



        <div class="text-6xl">
            💳
        </div>


    </div>




    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">


        <div class="bg-white/20 rounded-lg p-4">

            <p>
                Deposit
            </p>

            <h3 class="text-xl font-bold">
                ${{ wallet.deposit }}
            </h3>

        </div>



        <div class="bg-white/20 rounded-lg p-4">

            <p>
                Withdraw
            </p>

            <h3 class="text-xl font-bold">
                ${{ wallet.withdraw }}
            </h3>

        </div>



        <div class="flex gap-3 items-center">


            <button
            class="bg-white text-green-700 px-4 py-2 rounded-lg font-bold">

                💰 Deposit

            </button>


            <button
            class="bg-red-500 px-4 py-2 rounded-lg font-bold">

                Withdraw

            </button>


        </div>


    </div>


</div>





<!-- STATISTICS START HERE -->

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-5xl mb-3">🎮</div>
                    <p class="text-gray-500">Active Games</p>
                    <h2 class="text-4xl font-bold">
                        {{ activeGames }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-5xl mb-3">🎫</div>
                    <p class="text-gray-500">My Tickets</p>
                    <h2 class="text-4xl font-bold">
                        {{ tickets }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <div class="text-5xl mb-3">🏆</div>
                    <p class="text-gray-500">Total Wins</p>
                    <h2 class="text-4xl font-bold">
                        {{ winnings }}
                    </h2>
                </div>

            </div>

            <!-- Quick Actions -->
<div class="mt-8 bg-white rounded-2xl shadow-lg p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            🎮 Available Games
        </h2>

        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
            {{ games.length }} Games
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- Game Card -->
        <div
            v-for="game in games"
            :key="game.id"
            class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition duration-300"
        >

            <div class="p-6">

                <div class="flex justify-between items-center">

                    <div class="text-5xl">
                        🎱
                    </div>

                    <span
                        class="bg-green-500 px-3 py-1 rounded-full text-xs font-bold">
                        {{ game.status }}
                    </span>

                </div>

                <h3 class="text-2xl font-bold mt-4">
                    {{ game.title }}
                </h3>

                <div class="mt-4 space-y-2 text-blue-100">

                    <p>
                        🎟 Ticket Price:
                        <strong class="text-white">
                            ${{ game.ticket_price }}
                        </strong>
                    </p>

                    <p>
                        👥 Players:
                        <strong class="text-white">
                            {{ game.players_count ?? 0 }}
                        </strong>
                    </p>

                    <p>
                        🏆 Prize:
                        <strong class="text-yellow-300">
                            ${{ game.prize_pool }}
                        </strong>
                    </p>

                </div>

                <Link
                    :href="route('player.games.join', game.id)"
                    method="post"
                    as="button"
                    class="mt-6 w-full bg-white text-blue-700 font-bold py-3 rounded-xl hover:bg-gray-100 transition"
                >
                    🎮 Join Game
                </Link>

            </div>

        </div>

        <!-- My Tickets -->
        <Link
            href="/player/tickets"
            class="bg-green-600 hover:bg-green-700 text-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center transition hover:scale-105"
        >
            <div class="text-6xl mb-4">🎫</div>
            <h3 class="text-xl font-bold">My Tickets</h3>
            <p class="text-green-100 mt-2 text-center">
                View all purchased tickets
            </p>
        </Link>

        <!-- Profile -->
        <Link
            href="/player/profile"
            class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center transition hover:scale-105"
        >
            <div class="text-6xl mb-4">👤</div>
            <h3 class="text-xl font-bold">My Profile</h3>
            <p class="text-yellow-100 mt-2 text-center">
                Manage your account
            </p>
        </Link>

    </div>

</div>

            <!-- Recent Games -->
            <div class="mt-8 bg-white rounded-xl shadow">

                <div class="p-5 border-b">
                    <h2 class="text-xl font-bold">
                        Recent Games
                    </h2>
                </div>

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="text-left p-4">Game</th>
                            <th class="text-left p-4">Date</th>
                            <th class="text-left p-4">Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr
                            v-for="game in recentGames"
                            :key="game.id"
                            class="border-t">

                            <td class="p-4">
                                {{ game.title }}
                            </td>

                            <td class="p-4">
                                {{ game.date }}
                            </td>

                            <td class="p-4">
                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    {{ game.status }}
                                </span>
                            </td>

                        </tr>

                        <tr v-if="recentGames.length === 0">
                            <td
                                colspan="3"
                                class="text-center text-gray-500 p-6">
                                No games available.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</template>