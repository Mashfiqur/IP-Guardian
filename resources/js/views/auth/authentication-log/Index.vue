<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="text-lg font-semibold">Authentication Log</h1>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                <tr v-if="authenticationLogStore.logs.length" v-for="log in authenticationLogStore.logs" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ log.user?.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ log.ip_address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log.user_agent }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log.login_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log.logout_at }}
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="5" class="text-center py-5 text-gray-600">Data Not Found</td>
                </tr>
            </tbody>
        </table>
        <Paginator
            :title="'Authentication Logs'"
            :fetchRecords="authenticationLogStore.fetchAuthenticationLogs"
        />
    </div>
</template>

<script setup>
import { useAuthenticationLogStore } from '@src/store/authenticationLog';
import Paginator from '@src/components/global/Paginator.vue';

// Initiate stores
const authenticationLogStore = useAuthenticationLogStore();

authenticationLogStore.fetchAuthenticationLogs();
</script>