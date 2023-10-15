<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="text-lg font-semibold text-3xl">Overview</h1>
    </div>
    <div class="lg:flex lg:flex-column lg:mt-3 sm:mt-3 lg:mt-0">
        <div class="space-y-6">
            <div class="pl-1 w-96 h-20 bg-green-400 rounded-lg shadow-md">
                <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                    <div class="my-auto">
                        <p class="font-bold">IP Address</p>
                        <p class="text-lg">{{ dashboardStore.overview.total_ip_addresses }}</p>
                    </div>
                    <div class="my-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:ml-3 space-y-6 sm:mt-3 lg:mt-0">
            <div class="pl-1 w-96 h-20 bg-blue-500 rounded-lg shadow-md">
                <div class="flex w-full h-full py-2 px-4 bg-white rounded-lg justify-between">
                    <div class="my-auto">
                        <p class="font-bold">IP Address (This Month)</p>
                        <p class="text-lg">{{ dashboardStore.overview.total_ip_addresses_this_month }}</p>
                    </div>
                    <div class="my-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useDashboardStore } from '@src/store/dashboard';

// Initiate Store
const dashboardStore = useDashboardStore();

dashboardStore.fetchOverview();
</script>