<template>
    <div class="flex items-center justify-between p-4">
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
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
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