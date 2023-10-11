import { acceptHMRUpdate, defineStore } from 'pinia';
import ipAddressService from '@src/store/services/ipAddressService';
import {useErrorStore} from '@src/store/error';
import { usePaginationStore } from '@src/store/pagination';
import router from '@/router';
import { mergeRequestDataWithPagination } from '@src/utils/paginationHelper';

const errorStore = useErrorStore();
const paginationStore = usePaginationStore();

export const useIPAddressStore = defineStore({
    id: 'ipAddress',
    state: () => ({
        ipAddresses: [],
        ipAddress: {},
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
        initiateIPAddress(){
            this.ipAddress = {
                ip: "",
                label: "",
                comment: "",
            }
        },
        async fetchIPAddresses(payload = {}) {
            errorStore.setError({});

            payload = {...this.searchParam, ...payload}
            payload = mergeRequestDataWithPagination(payload);

            return ipAddressService.index(payload)
                .then(response => {
                    this.ipAddresses = response.data.data
                    paginationStore.setPaginationData(response.data.meta)
                })
                .catch(error => {
                    errorStore.setError(error)
                });
        },
        async storeIPAddress(payload) {
            errorStore.setError({})

            return ipAddressService.store(payload)
                .then(response => {
                    router.push({name: 'ip-address'});
                })
                .catch(error => {
                    errorStore.setError(error)
                });
        },
        async showIPAddress(id) {
            errorStore.setError({});

            return ipAddressService.show(id)
                .then(response => {
                    this.ipAddress  = response.data.data;
                })
                .catch(error => {
                    errorStore.setError(error)
                });
        },
        async updateIPAddress(id, payload) {
            errorStore.setError({})

            return ipAddressService.update(id, payload)
                .then(response => {
                    router.push({name: 'ip-address'});
                })
                .catch(error => {
                    errorStore.setError(error)
                });
        },
    },
})

if(import.meta.hot){
    import.meta.hot.accept(acceptHMRUpdate(useIPAddressStore, import.meta.hot));
}