import { acceptHMRUpdate, defineStore } from 'pinia'
import authService from '@src/store/services/authService';
import { useErrorStore } from '@src/store/error';
import setAxiosAuthHeader from '@src/utils/setAxiosAuthHeader';
import router from '@src/router';

export const useAuthStore = defineStore({
  id: 'auth',
  state: () => ({
    user: null,
  }),
  actions: {
    resetAuthStore(){
      this.user = null;
    },
    setUserName(name){
      this.user.name = name;
    },
    async login(payload) {
      const errorStore = useErrorStore();
      errorStore.setError({});

      return authService.login(payload)
        .then(async (response) => {
          localStorage.setItem('bearer_token', response.data.token);
          setAxiosAuthHeader();
          await this.authorization();
          router.push({name: 'dashboard'});
        })
        .catch(error => {
          errorStore.setError(error)
        });
    },
    async authorization() {
      const errorStore = useErrorStore();
      errorStore.setError({});

      return authService.authorize()
        .then(response => {
            this.user = response.data.user;
        })
        .catch(error => {
          errorStore.setError(error);
        });
    },
    async logout() {
      const errorStore = useErrorStore()
      errorStore.setError({})

      return authService.logout()
            .then(response => {
              localStorage.removeItem('bearer_token');
              this.resetAuthStore();
              router.push({name: 'login'});
            })
            .catch(error => {
              errorStore.setError(error)
            })
            .then(() => {
                
            });
    },
  },
})

if(import.meta.hot){
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot));
}