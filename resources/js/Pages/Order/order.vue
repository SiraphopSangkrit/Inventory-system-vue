<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

defineProps({ orders: Object });
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
                                การบันทึก/แก้ไข การสั่งซื้อสินค้า
                            </h2>
                        </div>


                        <div class="ml-12 mt-8">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-m text-left rtl:text-right text-gray-500 dark:text-white">
                                    <thead
                                        class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                รหัสลูกค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                ชื่อลูกค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                ลำดับ
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                จำนวนรายการที่สั่ง
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                จำนวนรายการที่สั่ง
                                            </th>
                                            <th scope="col" class="flex justify-center px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in orders" :key="order.Order_no"
                                            class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                            <th scope="row"
                                                class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ order.cus_id}}
                                            </th>
                                            <td class="px-6 py-4 text-center">
                                                {{ order.customers.cus_name }}
                                            </td>
                                            <td class="px-6 py-4 text-center ">
                                                {{ order.Order_no }}
                                            </td>
                                            <td class="px-6 py-4 text-center ">
                                                {{ order.d_order_count }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ order.d_order_sum_amount }}
                                            </td>
                                            <td class="flex justify-center px-6 py-4 w-full">
                                                <Link :href="route('order.detail',{ cus_id: order.cus_id, order_id: order.Order_no })" type="button"
                                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                                                แก้ไข</Link>
                                                <button type="button"
                                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบ</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end mt-8">
                            <div class="inline-flex rounded-md" role="group">
                                <Link :href="route('order.create.header')" type="button"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                เพิ่มข้อมูลการสั่งซื้อสินค้า</Link>
                                <Link :href="route('dashboard')" type="button"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                ออก</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </appLayout>

</template>
