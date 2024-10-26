<script setup>
import { ref } from 'vue';
import Themeswitch from '@/Components/Themeswitch.vue';
</script>
<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <header class="bg-white shadow dark:bg-gray-800">
            <div class="flex flex-row">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        ระบบจัดการสินค้าคงคลัง
                    </h2>
                </div>
                <div class="mt-6 mr-6">
                    <Themeswitch></Themeswitch>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>

</template>
