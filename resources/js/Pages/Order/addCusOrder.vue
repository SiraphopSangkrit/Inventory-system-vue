<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';


const query = ref(null);
const results = ref([]);
const customerName = ref('');
const showResults = ref(false);

const searchMembers = async () => {
    try {
        const response = await axios.get(route('order.create.search'), {
            params: { query: query.value },
        });
        results.value = response.data;
    } catch (error) {
        console.error('Error fetching members:', error);
    }
};

watch(query, () => {
    if (query.value) {
        searchMembers();
        showResults.value = true;
    } else {
        results.value = [];
        showResults.value = false;
    }
});

const select = (result) => {
    customerName.value = result.cus_name;
    query.value = result.cus_id;
    results.value = [];
    showResults.value = false;
};


const showResultsOnFocus = () => {
    if (!query.value) {
        searchMembers();
    }
    showResults.value = true;
};

const hideResultsOnBlur = () => {
    setTimeout(() => {
        showResults.value = false;
    }, 100);
};
const form = useForm({
    cus_id: '',
    Order_date: '',
});

const submitOrder = () => {
    form.cus_id = query.value;
    form.Order_date = document.getElementById('datepicker-actions').value;
    form.post(route('order.header.store'), {
        onSuccess: () => {
        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        }
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
                                การบันทึก/แก้ไข การสั่งซื้อสินค้า
                            </h2>
                        </div>
                        <div class="ml-12 mt-8">
                            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                สถานะ เพิ่มรายการส่วน Header การรับคำสั่งซื้อสินค้า
                            </div>
                           
                            <div class="mt-6">

                                <form @submit.prevent="submitOrder">
                                    <div class="mb-6">
                                        เพิ่มข้อมูล Header
                                    </div>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">

                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัสลูกค้า
                                            </label>
                                            <input type="text" v-model="query" @focus="showResultsOnFocus"
                                                @blur="hideResultsOnBlur"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="รหัสลูกค้า" required />
                                            <div class="absolute z-50 mt-2 rounded-md dark:rounded-md hover:rounded-md shadow-lg"
                                                v-if="showResults && results.length">
                                                <div
                                                    class="rounded-md ring-1 ring-black ring-opacity-5 bg-white dark:bg-gray-700 ">

                                                    <div class="block px-4 py-2 rounded-md   dark:hover:text-white">
                                                        <ul>
                                                            <li v-for="result in results" :key="result.cus_id"
                                                                @click="select(result)"
                                                                class="cursor-pointer hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-white">
                                                               {{ result.cus_id }} {{ result.cus_name }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อลูกค้า</label>
                                            <input type="text" v-model="customerName"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="ชื่อลูกค้า" required disabled />
                                        </div>
                                        <div>
                                            <label
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันที่สั่งสินค้า
                                            </label>

                                            <div class="relative max-w-sm">
                                                <div
                                                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                    </svg>
                                                </div>
                                                <input id="datepicker-actions" datepicker datepicker-buttons
                                                    datepicker-autoselect-today datepicker-autohide type="text" v-model="form.Order_date" datepicker-format="yyyy-mm-dd"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Select date">
                                            </div>







                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        บันทึกและเพิ่มรายการสินค้าต่อ</button>
                                </form>
                            </div>

                            <div class="flex justify-end mt-8">
                                <div class="inline-flex rounded-md" role="group">
                                    <Link :href="route('order.index')" type="button"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    ออก</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </appLayout>

</template>
