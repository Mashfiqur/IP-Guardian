<template>
    <div class="flex items-center justify-between py-4">
        <h1 class="flex text-lg font-semibold">
            <img src="@src/assets/angle-left.svg" class="cursor-pointer" alt="IP" width="20" @click="router.push({name: 'ip-address' })">
            <span class="text-gray-600">{{ id === undefined ? 'Add New' : 'Edit'}} IP Address</span>
        </h1>
    </div>
    <Form @submit="ipAddressHandle" :validation-schema="IpAddressSchema(id === undefined ? 1 : 2)" v-slot="{ errors }">
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-4 group">
                <label 
                    for="ip" class="block mb-2 text-sm font-medium text-dark-700"
                    :class="{ 'text-red-600 dark:text-red-400': errors.ip }"
                >
                    IP{{ id === undefined ? '*' : '' }}
                </label>
                <Field
                    v-model="ipAddressStore.ipAddress.ip"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.ip }" :validateOnInput="true" type="text" :disabled="id"
                    id="ip" name="ip" placeholder="11.11.11.11" />
                <FormInputErrorMessage :message="errors.ip" />
                <div v-if="id !== undefined" class="flex items-center p-1 mt-1 text-sm text-yellow-800 rounded-lg dark:bg-gray-800 dark:text-yellow-300" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        Read-only IP - This field is not editable.
                    </div>
                </div>
            </div>
            <div class="relative z-0 w-full mb-4 group">
                <label 
                    for="label" class="block mb-2 text-sm font-medium text-dark-700"
                    :class="{ 'text-red-600 dark:text-red-400': errors.label }"
                >
                    Label*
                </label>
                <Field
                    v-model="ipAddressStore.ipAddress.label"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="{ 'border-red-300': errors.label }" :validateOnInput="true" type="text"
                    id="label" name="label" placeholder="Office IP" />
                <FormInputErrorMessage :message="errors.label" />
            </div>
        </div>
        <div>
            <label 
                for="comment" class="block mb-2 text-sm font-medium text-dark-700"
                :class="{ 'text-red-600 dark:text-red-400': errors.comment }"
            >
                Comment
            </label>
            <Field
                v-model="ipAddressStore.ipAddress.comment"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :class="{ 'border-red-300': errors.comment }" :validateOnInput="true" as="textarea"
                id="comment" name="comment" placeholder="This is the Office IP" />
            <FormInputErrorMessage :message="errors.comment" />
        </div>
        <FormInputErrorMessage 
            v-if="ipAddressError"
            :message="ipAddressError" 
        />
        <button type="submit" class="mt-3 text-white bg-gray-600 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save</button>
    </Form>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Form, Field } from 'vee-validate';
import { IpAddressSchema } from '@src/validation-schema/ipAddressValidationSchema';
import FormInputErrorMessage from '@src/components/global/FormInputErrorMessage.vue';
import { useRoute } from 'vue-router';
import { useIPAddressStore } from '@src/store/ipAddress';
import { useErrorStore } from '@src/store/error';
import router from '@src/router';

// Initiate stores
const ipAddressStore = useIPAddressStore();
const errorStore = useErrorStore();

ipAddressStore.initiateIPAddress();

const route = useRoute();

const id = route.params.id;
const ipAddressError = ref(null);
const isLoading = ref(false);

const setIsLoading = (status) => isLoading.value = status;
const setIPAddressError = (errorMessage = null) => ipAddressError.value = errorMessage;

onMounted(async() => {
    if (id !== undefined) await ipAddressStore.showIPAddress(id);
})

const ipAddressHandle = async(values, actions) => {
    try {
        setIsLoading(true);
        setIPAddressError();

        const payload = values;

        if (id !== undefined){
            delete payload.ip;
            await ipAddressStore.updateIPAddress(id, payload);
        }
        else{
            await ipAddressStore.storeIPAddress(payload);
        }

        setIsLoading(false);

        if (!errorStore.errorCode) { actions.resetForm(); }

        if (errorStore.errorCode === 422) {
            actions.setErrors(errorStore.formErrors);
        } 
        else if (errorStore.errorCode && errorStore.errorMessage) {
            setIPAddressError(errorStore.errorMessage);
        } 
    } catch (e) {
        setIPAddressError(e.message);
        setIsLoading(false);
    }
};
</script>