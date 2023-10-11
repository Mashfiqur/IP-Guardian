import { acceptHMRUpdate, defineStore } from 'pinia'
import profileService from '@src/store/services/profileService';
import { useAuthStore } from '@src/store/auth';
import { useErrorStore } from '@src/store/error';

export const useProfileStore = defineStore({
  id: 'profile',
  state: () => ({
    profile: {
        name: null,
        email: null
    },
  }),
  actions: {
    async getProfile(){
      const authStore = useAuthStore()
      const errorStore = useErrorStore()
      errorStore.setError({});

      return profileService.getProfile()
            .then(response => {
              this.profile = response.data.data;
              authStore.setUserName(this.profile.name);
            })
            .catch(error => {
              errorStore.setError(error)
            });
    },
    async updateProfile(payload){
      const errorStore = useErrorStore()
      errorStore.setError({});

      return profileService.updateProfile(payload)
            .then(response => {
              this.getProfile();
            })
            .catch(error => {
              errorStore.setError(error)
            });
    }
  },
})

if(import.meta.hot){
  import.meta.hot.accept(acceptHMRUpdate(useProfileStore, import.meta.hot));
}