<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
import { ref, watch, computed,onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';

const query = ref(null);
const results = ref([]);
const GoodsName = ref('');
const GoodsCost = ref('');
const showResults = ref(false);
const Amount = ref(null);
const showMessage = ref(false);
const successMessage = ref('');

const tot_prc = computed(() => {
    const amountValue = Number(Amount.value) || 0;
    const costUnitValue = Number(GoodsCost.value) || 0;
    return amountValue * costUnitValue;
});
const props = defineProps({ order: Object,orderDetails: Object });
const searchGoods = async () => {
    try {
        const response = await axios.get(route('order.goods.search'), {
            params: { query: query.value },
        });
        results.value = response.data;
    } catch (error) {
        console.error('Error fetching members:', error);
    }
};
watch(query, () => {
    if (query.value) {
        searchGoods();
        showResults.value = true;
    } else {
        results.value = [];
        showResults.value = false;
    }
});
watch(tot_prc, (newValue) => {
    form.tot_prc = newValue;
});
const select = (result) => {
    GoodsName.value = result.goods_name;
    GoodsCost.value = result.cost_unit;
    query.value = result.goods_id;
    results.value = [];
    showResults.value = false;
};
const showResultsOnFocus = () => {
    if (!query.value) {
        searchGoods();
    }
    showResults.value = true;
};
const hideResultsOnBlur = () => {
    setTimeout(() => {
        showResults.value = false;
    }, 100);
};
const form = useForm({
    Order_no: '',
    goods_id: '',
    Ord_date: '',
    Fin_date: '',
    amount: '',
    cost_unit: '',
    tot_prc: ''
});
const cus_id = props.order?.cus_id || '';
const Order_no = props.order?.Order_no || '';

const submitOrderDetail = () => {
    form.Order_no = Order_no;
    form.goods_id = query.value;
    form.Ord_date = document.getElementById('datepicker-1').value;
    form.Fin_date = document.getElementById('datepicker-2').value;
    form.amount = Amount.value;
    form.cost_unit = GoodsCost.value;
    form.tot_prc = tot_prc.value;
    form.post(route('order.create.detail.store', { cus_id, Order_no }), {
        onSuccess: () => {
            Swal.fire({ title: "เพิ่มสินค้าแล้วเรียบร้อย", icon: "success", timer: 2000 });
            Amount.value = '';
            GoodsCost.value = '';
            GoodsName.value = '';
            query.value = '';
            form.reset();


            document.getElementById('datepicker-1').value = '';
            document.getElementById('datepicker-2').value = '';


        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        }
    });
};
onMounted(() => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('datepicker-1').value = today;
});
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

                        <form @submit.prevent="submitOrderDetail">
                            <div class="mt-8">

                                <div class="ml-12">
                                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        สถานะ เพิ่มรายการส่วน Header การรับคำสั่งซื้อสินค้า
                                    </div>
                                    <div class="mt-6">
                                        <div class="mb-6">
                                            เพิ่มข้อมูล Header
                                        </div>
                                        <div>

                                        </div>
                                        <div class="flex flex-row mb-6">


                                            <div class="mr-6">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสลูกค้า
                                                </label>
                                                <input type="text" id="cus_id" v-model="order.cus_id"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="รหัสลูกค้า" disabled />
                                            </div>
                                            <div class="mr-6">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ชื่อลูกค้า</label>
                                                <input type="text" id="cus_name" v-model="order.customers.cus_name"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="ชื่อลูกค้า" disabled />
                                            </div>
                                            <div class="mr-6">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันที่สั่งสินค้า
                                                </label>
                                                <input id="order-date" v-model="order.Order_date"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Order No" disabled />
                                            </div>
                                            <div class="mr-6">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">Order
                                                    No</label>
                                                <input type="text" id="order-no" v-model="order.Order_no"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Order No" disabled />
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700" />


                                <div class="flex flex-row mb-6 ml-12 ">
                                    <div class="mr-6">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                                        <input type="text" v-model="query" @focus="showResultsOnFocus"
                                            @blur="hideResultsOnBlur"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="รหัสลูกค้า" required />
                                            <InputError class="mt-2" :message="form.errors.goods_id" />
                                        <div class="absolute z-50 mt-2 rounded-md dark:rounded-md hover:rounded-md shadow-lg"
                                            v-if="showResults && results.length">
                                            <div
                                                class="rounded-md ring-1 ring-black ring-opacity-5 bg-white dark:bg-gray-700 ">

                                                <div class="block px-4 py-2 rounded-md   dark:hover:text-white">
                                                    <ul>
                                                        <li v-for="result in results" :key="result.goods_id"
                                                            @click="select(result)"
                                                            class="cursor-pointer hover:bg-gray-400 dark:hover:bg-gray-600 dark:text-white">
                                                            {{ result.goods_id }} {{ result.goods_name }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mr-6 w-2/3">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า</label>
                                        <input type="text" id="last_name" v-model="GoodsName"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="รายละเอียดสินค้า" required />
                                    </div>
                                </div>
                                <div class="flex flex-row mb-6 ml-12">
                                    <div>
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันกำหนดส่ง</label>
                                        <div class="relative max-w-sm">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input datepicker id="datepicker-1" type="text"
                                                datepicker-format="yyyy-mm-dd"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="วันกำหนดส่ง">
                                        </div>


                                    </div>
                                    <div class="ml-10">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันที่ส่งสินค้าจริง</label>


                                        <div class="relative max-w-sm">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input id="datepicker-2" datepicker datepicker-buttons
                                                    datepicker-autoselect-today datepicker-autohide type="text" datepicker-format="yyyy-mm-dd"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="วันที่ส่งสินค้าจริง">
                                        </div>


                                    </div>
                                    <div class="ml-10">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">จำนวนที่สั่ง</label>
                                        <input type="number" id="amount" v-model="Amount"
                                            aria-describedby="helper-text-explanation"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="จำนวนที่สั่ง" required min="0" />
                                    </div>
                                </div>
                                <div class="flex flex-row mb-6 ml-12">
                                    <div>
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ราคา/หน่วย</label>
                                        <input type="text" id="cost_unit" v-model="GoodsCost"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="ราคา/หน่วย" required />
                                    </div>
                                    <div class="ml-10">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ราคารวม</label>
                                        <input type="text" id="tot_prc" v-model="tot_prc"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="ราคารวม" required disabled />
                                    </div>
                                </div>
                                <button type="submit"
                                    class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึกและเพิ่มรายการสินค้าต่อ</button>
                            </div>
                        </form>
                    </div>
                    <div class="mx-12 mt-8 ">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-m text-left rtl:text-right text-gray-500 dark:text-white">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="orderDetail in orderDetails" :key="orderDetail.order_detail_id"
                                    class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ orderDetail.goods.goods_id }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ orderDetail.goods.goods_name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ orderDetail.formatted_ord_date || 'N/A'  }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ orderDetail.formatted_fin_date || 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ orderDetail.amount }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ orderDetail.cost_unit }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ orderDetail.tot_prc }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8">
                        <Link :href="route('order.detail',{cus_id:order.cus_id,order_id:order.Order_no})" type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-m px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        ออก</Link>
                    </div>
                </div>
            </div>
        </div>

    </appLayout>

</template>
