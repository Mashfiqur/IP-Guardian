<template>
    <div class="flex items-center justify-between py-4 mt-3">
        <h1 class="text-lg font-semibold text-3xl">Recent Login</h1>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3">
                        IP Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User Agent
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Login At
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Logout At
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="dashboardStore.recentLogins.length" v-for="login in dashboardStore.recentLogins" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ login.user?.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ login.ip_address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ login.user_agent }}
                    </td>
                    <td class="px-6 py-4">
                        {{ login.login_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ login.logout_at }}
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="5" class="text-center py-5 text-gray-600">Data Not Found</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { useDashboardStore } from '@src/store/dashboard';

// Initiate Store
const dashboardStore = useDashboardStore();

dashboardStore.fetchRecentLogins();
</script>