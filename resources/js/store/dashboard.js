import { acceptHMRUpdate, defineStore } from 'pinia';
import dashboardService from '@src/store/services/dashboardService';
import {useErrorStore} from '@src/store/error';

const errorStore = useErrorStore();

export const useDashboardStore = defineStore({
    id: 'dashboard',
    state: () => ({
        overview: {
            total_ip_addresses: 0,
            total_ip_addresses_this_month: 0,
        },
        recentLogins: []
    }),
    actions: {
        async fetchOverview() {
            errorStore.setError({});

            return dashboardService.overview()
                .then(response => {
                    this.overview = response.data;
                })
                .catch(error => {
                    errorStore.setError(error);
                });
        },
        async fetchRecentLogins() {
            errorStore.setError({});

            return dashboardService.getRecentLogins()
                .then(response => {
                    this.recentLogins = response.data.data;
                })
                .catch(error => {
                    errorStore.setError(error);
                });
        },
    },
})

if(import.meta.hot){
    import.meta.hot.accept(acceptHMRUpdate(useDashboardStore, import.meta.hot));
}