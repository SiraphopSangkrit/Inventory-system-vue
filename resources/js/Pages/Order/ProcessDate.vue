<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

</script>
<template>
    <appLayout>

        <Head title="ระบบจัดการสินค้าคงคลัง" />
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-start">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                การประมวลผลข้อมูลสั่งซื้อสินค้า
                            </h2>
                        </div>
                        <div class="mt-8">
                            <div class="ml-12">
                                <div class="mt-6">
                                    <div class="flex justify-center mb-6">
                                        <div class="mr-6">
                                            <label for="cus_id"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ระหว่างวันทื่ส่งสินค้า
                                            </label>
                                            <input type="text" id="cus_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="รหัสลูกค้า" required />
                                        </div>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="mr-6">
                                            <label for="order_id"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ถึงวันที่ </label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Order No" required />
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-5">
                                        <button type="submit"
                                        class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึกและเพิ่มรายการสินค้าต่อ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8">
                        <div class="inline-flex rounded-md" role="group">
                            <Link :href="route('dashboard')" type="button"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            ออก</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </appLayout>

</template>
