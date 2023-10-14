<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="text-lg font-semibold">Audit Log</h1>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Before
                    </th>
                    <th scope="col" class="px-6 py-3">
                        After
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actioned By
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actioned At
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="auditLogStore.logs.length" v-for="log in auditLogStore.logs" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ log.action_type }}
                    </th>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">{{ index + ':' + change[0] }}</li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        <ul>
                            <li v-for="(change, index) in log.difference">{{ index + ':' + change[1] }}</li>
                        </ul>
                    </td>
                    <td class="px-6 py-4">
                        {{ log.actioned_by?.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ log.actioned_at }}
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="4" class="text-center py-5 text-gray-600">Data Not Found</td>
                </tr>
            </tbody>
        </table>
        <Paginator
            :title="'Audit Logs'"
            :fetchRecords="auditLogStore.fetchAuditLogs"
        />
    </div>
</template>

<script setup>
import { useAuditLogStore } from '@src/store/auditLog';
import Paginator from '@src/components/global/Paginator.vue';

// Initiate stores
const auditLogStore = useAuditLogStore();

auditLogStore.fetchAuditLogs();
</script>