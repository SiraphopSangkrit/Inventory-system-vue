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
                                การบันทึก/แก้ไข การสั่งซื้อสินค้า
                            </h2>
                        </div>
                        <div class="mt-8">
                            <div class="ml-12">
                                <div class="mt-6">
                                    <div class="flex flex-row mb-6">
                                        <div class="mr-6">
                                            <label for="cus_id"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสลูกค้า
                                            </label>
                                            <input type="text" id="cus_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="รหัสลูกค้า" required />
                                        </div>
                                        <div class="mr-6">
                                            <label for="cus_name"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ชื่อลูกค้า</label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="ชื่อลูกค้า" required />
                                        </div>
                                        <div class="mr-6">
                                            <label for="cus_name"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันที่สั่งสินค้า
                                            </label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Order No" required />
                                        </div>
                                        <div class="mr-6">
                                            <label for="order_id"
                                                class="block mb-2 text-m font-medium text-gray-900 dark:text-white">Order
                                                No</label>
                                            <input type="text" id="last_name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Order No" required />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <Link :href="route('order.create.detail')"
                            class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        เพิ่มข้อมูล</Link>
                        <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700" />
                        <div class="mx-12 mt-8 ">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                รหัสสินค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                รายละเอียด
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                วันกำหนดส่ง
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                วันที่ส่งสินค้าจริง
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                จำนวนที่สั่ง
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ราคา/หน่วย
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ราคารวม
                                            </th>
                                            <th scope="col" class="flex justify-center px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Apple MacBook Pro 17"
                                            </th>
                                            <td class="px-6 py-4">
                                                Silver
                                            </td>
                                            <td class="px-6 py-4">
                                                dd/mm/yyyy
                                            </td>
                                            <td class="px-6 py-4">
                                                dd/mm/yyyy
                                            </td>
                                            <td class="px-6 py-4">
                                                99999
                                            </td>
                                            <td class="px-6 py-4">
                                                99999
                                            </td>
                                            <td class="px-6 py-4">
                                                99999
                                            </td>
                                            <td class="flex justify-center px-6 py-4">
                                                <Link :href="route('order.update.detail')" type="button"
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
                        <Link :href="route('dashboard')" type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-m px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        ออก</Link>
                    </div>
                </div>
            </div>
        </div>

    </appLayout>

</template>
