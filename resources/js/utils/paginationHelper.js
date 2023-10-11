import { usePaginationStore } from '@src/store/pagination';

// Initiate Store
const paginationStore = usePaginationStore();

export const mergeRequestDataWithPagination = (payload) => {
    try{
        let requestedData = paginationStore.paginationDataForRequest;

        if(payload != undefined){
            return { ...requestedData, ...payload}
        }
        return requestedData;
    }
    catch(e){
        return paginationStore.paginationDataForRequest;
    }
}