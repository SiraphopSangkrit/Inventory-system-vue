<script setup>
import appLayout from '@/Layouts/appLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

function closeTab() {
    window.close();
}
</script>

<template>

    <Head title="ระบบจัดการสินค้าคงคลัง" />

    <appLayout>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row justify-center">
                        <!-------------ฐานข้อมูลอ้างอิง--------->
                        <div class="mr-6">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">ฐานข้อมูลอ้างอิง <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('customer.index')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        บันทึก/แก้ไข
                                        ข้อมูลลูกค้า
                                    </DropdownLink>
                                    <DropdownLink :href="route('goods.index')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        บันทึก/แก้ไข
                                        ข้อมูลสินค้า
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                        <div class="mr-6">
                            <!-------------การทำงานประจำวัน--------->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">การทำงานประจำวัน <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('order.index')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        บันทึก/แก้ไข การสั่งซื้อสินค้า
                                    </DropdownLink>
                                    <DropdownLink :href="route('order.process')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        การประมวลผลข้อมูลการสั่งสินค้า
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                        <div class="mr-6">
                            <!-------------ฐานข้อมูลอ้างอิง--------->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">รายงาน <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('order.report')"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        รายงานกำหนดส่งสินค้า
                                    </DropdownLink>

                                </template>
                            </Dropdown>
                        </div>
                        <div>
                            <button type="button"   @click="closeTab"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ออกจากระบบ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </appLayout>
</template>
