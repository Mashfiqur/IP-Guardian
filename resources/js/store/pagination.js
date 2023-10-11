import { defineStore } from 'pinia'
import { DEFAULT_PAGINATION_PER_PAGE} from '@src/config/constants'

export const usePaginationStore = defineStore({
    id: 'pagination',
    state: () => ({
        current_page : 1,
        last_page: 1,
        per_page: DEFAULT_PAGINATION_PER_PAGE,
        from: 1,
        to: 1,
        total: 0,
    }),
    getters: {
        paginationDataForRequest: state => {
            return {
                page : state.current_page,
                per_page: state.per_page,
            };
        },
        paginationData: state => {
            return {
                current_page : state.current_page,
                last_page    : state.last_page,
                to : state.to,
                from : state.from,
                per_page: state.per_page,
                total: state.total,
            };
        },

        pages: state => {
            const pages = [];

            let i = 1;
            while (i <= state.last_page) {
                if (i <= 3 || //the first three pages
                    i >= state.last_page - 2 || //the last three pages
                    i >= state.current_page - 1 && i <= state.current_page + 1) { //the currentPage, the page before and after
                  pages.push(i);
                  i++;
                } else {
                  pages.push('...');
                  i = i < state.current_page ? state.current_page - 1 : state.last_page - 2;
                }
            }
            return pages;
        },
        perPage: state => {
            return state.per_page;
        },
    },
    actions: {
        async initiate(data = {}){
            this.current_page   = data.hasOwnProperty('current_page') ? data.current_page : 1;
            this.last_page      = data.hasOwnProperty('last_page') ? data.last_page : 1;
            this.per_page       = data.hasOwnProperty('per_page') ? data.per_page : DEFAULT_PAGINATION_PER_PAGE;
            this.from           = data.hasOwnProperty('from') ? data.from : 1;
            this.to             = data.hasOwnProperty('to') ? data.to : 1;
            this.total          = data.hasOwnProperty('total') ? data.total : 0;
        },
        async setPaginationData(data){
            if(data === undefined) return;
            if(Object.keys(data).length === 0) return;

            this.current_page   = data.current_page;
            this.from           = data.from;
            this.last_page      = data.last_page;
            this.to             = data.to;
            this.per_page       = data.per_page;
            this.total          = data.total;
        },
        async setCurrentPage(page){
            return this.current_page   = page;
        }
    },
})