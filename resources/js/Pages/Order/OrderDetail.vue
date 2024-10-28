<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

defineProps({ orderHeader: Object, orderDetails: Object });

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
                        <div class="mt-8">
                            <div class="ml-12">
                                <div class="mt-6">
                                    <div class="flex flex-row mb-6">

                                        <div class="mr-6">
                                            <label
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสลูกค้า
                                            </label>
                                            <input type="text" id="cus_id" v-model="orderHeader.cus_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="รหัสลูกค้า" disabled />
                                        </div>
                                        <div class="mr-6">
                                            <label
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ชื่อลูกค้า</label>
                                            <input type="text" id="cus_name" v-model="orderHeader.customers.cus_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="ชื่อลูกค้า" disabled />
                                        </div>
                                        <div class="mr-6">
                                            <label
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันที่สั่งสินค้า
                                            </label>
                                            <input id="order-date" v-model="orderHeader.Order_date"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Order No" disabled />
                                        </div>
                                        <div class="mr-6">
                                            <label
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">Order
                                                No</label>
                                            <input type="text" id="order-no" v-model="orderHeader.Order_no"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Order No" disabled />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700" />
                        <div class="mx-12 mt-8 ">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="table-auto w-full text-m text-left rtl:text-right text-gray-500 dark:text-white">
                                    <thead
                                        class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                รหัสสินค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                รายละเอียด
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                วันกำหนดส่ง
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                วันที่ส่งสินค้าจริง
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                จำนวนที่สั่ง
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                ราคา/หน่วย
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center">
                                                ราคารวม
                                            </th>
                                            <th scope="col" class="flex justify-center px-6 py-4 w-full">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="orderDetail in orderDetails" :key="orderDetail.order_detail_id"
                                    class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                        <th scope="row"
                                            class=" text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ orderDetail.goods.goods_id }}
                                        </th>
                                        <td class=" text-center px-6 py-4">
                                            {{ orderDetail.goods.goods_name }}
                                        </td>

                                        <td class="text-center px-6 py-4">
                                            {{ orderDetail.formatted_ord_date || 'N/A'  }}
                                        </td>
                                        <td class="text-center px-6 py-4 ">
                                            {{ orderDetail.formatted_fin_date || 'N/A' }}
                                        </td>
                                        <td class="text-center px-6 py-4">
                                            {{ orderDetail.amount }}
                                        </td>
                                        <td class="text-center px-6 py-4">
                                            {{ orderDetail.cost_unit }}
                                        </td>
                                        <td class="text-center px-6 py-4">
                                            {{ orderDetail.tot_prc }}
                                        </td>
                                            <td class="flex justify-center px-6 py-4 w-full">
                                                <Link :href="route('order.edit.detail',{cus_id:orderHeader.cus_id,order_id:orderHeader.Order_no,order_detail_id:orderDetail.order_detail_id})" type="button"
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
                    </div>
                    <div class="flex justify-end mt-8">
                        <Link :href="route('order.index')" type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-m px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        ออก</Link>
                    </div>
                </div>
            </div>
        </div>

    </appLayout>

</template>
