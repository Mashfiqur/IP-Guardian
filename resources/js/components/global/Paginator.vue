<template>
    <nav class="flex items-center justify-between py-3 px-2" aria-label="Table navigation" v-if="paginationStore.paginationData.total">
        <ul class="inline-flex -space-x-px text-sm h-8">
            <li @click="previousPageClicked" :class="{ disabled: paginationStore.paginationData.current_page == 1 }">
                <button to="#" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Previous
                </button>
            </li>
            <li v-for="page in paginationStore.pages" @click="pageClick(page)">
                <button to="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :class="[page == paginationStore.paginationData.current_page ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : '']">
                    {{ page }}
                </button>
            </li>
            <li @click="nextPageClicked" :class="{ disabled: paginationStore.paginationData.current_page == paginationStore.paginationData.last_page }">
                <button to="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Next
                </button>
            </li>
        </ul>
        <span class="flex flex-column text-sm font-normal text-gray-500 dark:text-gray-400">
            <div>
                Showing 
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ paginationStore.paginationData.from }} - {{ paginationStore.paginationData.to }}
                </span> of 
                <span class="font-semibold text-gray-900 dark:text-white">
                     {{ paginationStore.paginationData.total }} {{ title }}
                </span>
            </div>
            <select v-model="paginationStore.per_page" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ml-2">
                <option :value="perPageValue" v-for="perPageValue in PAGINATION_PER_PAGE_LIST"> 
                    {{ perPageValue }}
                </option>
            </select>
        </span>
    </nav>
</template>

<script setup>
import { PAGINATION_PER_PAGE_LIST } from '@src/config/constants';
import { usePaginationStore } from '@src/store/pagination';
import { watch } from 'vue';

const paginationStore = usePaginationStore();

const props = defineProps({
    title: {
        type: String
    },
    fetchRecords: {
        type: Function
    },
});

watch(() => paginationStore.paginationData.per_page, (val) => {
    paginationStore.setCurrentPage(1);
    props.fetchRecords();
});

function nextPageClicked() {
    let targettedPage = paginationStore.paginationData.current_page + 1;
    if (targettedPage > paginationStore.paginationData.last_page) return;
    paginationStore.setCurrentPage(targettedPage);
    props.fetchRecords();
}

function previousPageClicked() {
    let targettedPage = paginationStore.paginationData.current_page - 1;
    if (targettedPage == 0) return;
    paginationStore.setCurrentPage(targettedPage);
    props.fetchRecords();
}

function pageClick(page) {
    paginationStore.setCurrentPage(page);
    props.fetchRecords();
}
</script>

<style scoped>
.disabled-pagination {
    pointer-events: none;
}
</style>