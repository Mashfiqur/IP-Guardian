import { acceptHMRUpdate, defineStore } from 'pinia'
import router from '@src/router';

export const useErrorStore = defineStore({
    id: 'error',
    state: () => ({
        error: {},
        showableErrorCodes: [403,404, 500],
        errorCode: 200,
    }),
    getters: {
        formErrors: state => {
            const errorBag = []

            if (Object.keys(state.error).length === 0) return errorBag;
            if (state.error && state.error.response.status === 422) {
                for (const key in state.error.response.data.errors) {
                    errorBag[key] = state.error.response.data.errors[key][0]
                }
                return errorBag;
            }
        },
        isShowableErrorCode: state => {
            return state.showableErrorCodes.includes(state.errorCode)
        },
        errorMessage: state => {
            return Object.keys(state.error).length != 0 ? state.error?.response?.data?.message : ''
        }
    },
    actions: {
        setError(error) {
            this.error = error;
            if(error?.code == 'ERR_NETWORK'){
                console.log('Connection is not ok');
            }

            this.errorCode = error?.response?.status != undefined ? error?.response?.status : 200;
            this.handleError()
        },
        handleError(){
            if(this.errorCode == 401){
                localStorage.removeItem('bearer_token');
                router.push({name: 'login'});
            }
        },
        setErrorCode(code){
            this.errorCode = code;
        }
    }
})


if(import.meta.hot){
    import.meta.hot.accept(acceptHMRUpdate(useErrorStore, import.meta.hot));
}