<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    gdoc_1: '',
    gdoc_2: '',
});


const DateProcess = () => {

    form.gdoc_1 = document.getElementById('datepicker-range-start').value;
    form.gdoc_2 = document.getElementById('datepicker-range-end').value;
    form.post(route('order.process'), {
    });
};
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
                        <form @submit.prevent="DateProcess">
                            <div class="mt-8">
                                <div class="ml-12">
                                    <div class="mt-6">
                                        <div id="date-range-picker" date-rangepicker
                                            class="flex flex-col justify-center">


                                            <div class="flex justify-center mb-6">
                                                <div class="mr-6">
                                                    <label
                                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ระหว่างวันทื่ส่งสินค้า
                                                        :
                                                    </label>
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    </div>
                                                    <input type="text" id="datepicker-range-start" name="start"
                                                        v-model="form.gdoc_1" datepicker-format="yyyy-mm-dd"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="ระหว่างวันทื่ส่งสินค้า" required />
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <div class="mr-6">
                                                    <label
                                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ถึงวันที่
                                                        :
                                                    </label>
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">

                                                    </div>
                                                    <input type="text" id="datepicker-range-end" name="end"
                                                        v-model="form.gdoc_2" datepicker-format="yyyy-mm-dd"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="ถึงวันที่" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-5">
                                        <button type="submit"
                                            class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึกและเพิ่มรายการสินค้าต่อ</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
