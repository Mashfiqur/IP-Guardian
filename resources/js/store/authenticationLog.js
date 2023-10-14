import { acceptHMRUpdate, defineStore } from 'pinia';
import authenticationLogService from '@src/store/services/authenticationLogService';
import {useErrorStore} from '@src/store/error';
import { usePaginationStore } from '@src/store/pagination';
import { mergeRequestDataWithPagination } from '@src/utils/paginationHelper';

const errorStore = useErrorStore();
const paginationStore = usePaginationStore();

export const useAuthenticationLogStore = defineStore({
    id: 'authenticationLog',
    state: () => ({
        logs: [],
        searchParam: {},
    }),
    actions: {
        initiateSearchParam(){
            this.searchParam = {}
        },
        setSearchParam(payload){
            if(typeof payload === 'object'){
                this.searchParam = {...this.searchParam, ...payload};
            }
        },
        async fetchAuthenticationLogs(payload = {}) {
            errorStore.setError({});

            payload = {...this.searchParam, ...payload}
            payload = mergeRequestDataWithPagination(payload);

            return authenticationLogService.index(payload)
                .then(response => {
                    this.logs = response.data.data;
                    paginationStore.setPaginationData(response.data.meta);
                })
                .catch(error => {
                    errorStore.setError(error);
                });
        },
        
    },
})

if(import.meta.hot){
    import.meta.hot.accept(acceptHMRUpdate(useAuthenticationLogStore, import.meta.hot));
}