<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
});




</script>

<template>
    <div v-if="message" class="absolute">
        <p class="text-sm text-red-600 dark:text-red-400">
            {{ message }}
        </p>
    </div>
</template>
