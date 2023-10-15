<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="text-lg font-semibold">My Profile</h1>
    </div>
    <Form class="space-y-4 md:space-y-6" @submit="profileUpdateHandle" :validation-schema="profileUpdateSchema" v-slot="{ errors }">
        <div class="grid md:grid-cols-2 md:gap-6">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :class="{ 'text-red-600 dark:text-red-400': errors.name }">
                   Full Name
                </label>
                <Field
                    v-model="profileStore.profile.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.name }" :validateOnInput="true" type="text"
                    name="name" placeholder="e.g. Mashfiqur Rahman" 
                />
                <FormInputErrorMessage :message="errors.name" />
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :class="{ 'text-red-600 dark:text-red-400': errors.email }">
                    Email
                </label>
                <Field
                    v-model="profileStore.profile.email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.email }" :validateOnInput="true" type="email"
                    name="email" placeholder="e.g. mashfiqurrr@gmail.com" 
                />
                <FormInputErrorMessage :message="errors.email" />
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :class="{ 'text-red-600 dark:text-red-400': errors.password }">
                    Password
                </label>
                <Field
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.password }" :validateOnInput="true" type="password"
                    name="password"
                />
                <FormInputErrorMessage :message="errors.password" />
            </div>
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :class="{ 'text-red-600 dark:text-red-400': errors.password_confirmation }">
                    Password Confirmation
                </label>
                <Field
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.password_confirmation }" :validateOnInput="true" type="password"
                    name="password_confirmation"
                />
                <FormInputErrorMessage :message="errors.password_confirmation" />
            </div>
        </div>
        <FormInputErrorMessage 
            v-if="profileUpdateError"
            :message="profileUpdateError" 
        />
        <button type="submit" class="text-white bg-gray-600 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <span v-if="!isLoading">
                Save Changes
            </span>
            <div class="text-center" v-else>
                <div role="status">
                    <svg aria-hidden="true"
                        class="inline w-5 h-5 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                </div>
            </div>
        </button>
    </Form>
</template>

<script setup>
import { Form, Field } from 'vee-validate';
import { profileUpdateSchema } from '@src/validation-schema/authValidationSchema';
import FormInputErrorMessage from '@src/components/global/FormInputErrorMessage.vue';
import { useProfileStore } from '@src/store/profile';
import { useErrorStore } from '@src/store/error';
import { ref } from 'vue';


// Initiate store
const profileStore = useProfileStore();
const errorStore = useErrorStore();

const isLoading = ref(false);
const profileUpdateError = ref(null);

profileStore.getProfile();

const setIsLoading = (status) => isLoading.value = status;
const setProfileUpdateError = (errorMessage = null) => profileUpdateError.value = errorMessage;

const profileUpdateHandle = async (values, actions) => {
    try {
        setProfileUpdateError();
        setIsLoading(true);

        let formData = new FormData();

        formData.append('name', values.name);
        formData.append('email', values.email);

        if (values.password && values.password != '' && values.password === values.password_confirmation) {
            formData.append('password', values.password);
            formData.append('password_confirmation', values.password_confirmation);
        }

        await profileStore.updateProfile(formData);

        setIsLoading(false);

        if (errorStore.errorCode === 422) {
            actions.setErrors(errorStore.formErrors);
        } 
        else if (errorStore.errorCode !== 422 && errorStore.errorMessage) {
            setProfileUpdateError(errorStore.errorMessage);
        }
    } catch (e) {
        setProfileUpdateError(e.message);
        setIsLoading(false);
    }
};
</script>