<template>
    <p 
        v-if="message"
        id="outlined_error_help" 
        class="mt-2 text-xs text-red-600 dark:text-red-400"
    >
        <span class="font-medium">{{ message }}</span>
    </p>    
</template>

<script setup>
const props = defineProps({
    message: {
        type: String
    },
    customClass: {
        type: String,
        default: ''
    },
});
</script>