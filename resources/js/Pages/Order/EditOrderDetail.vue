<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';


const props = defineProps({ orderHeader: Object, orderDetail: Object });

const Amount = ref(props.orderDetail.amount || 0);

const total_prc = computed(() => {
    const amountValue = Number(Amount.value) || 0;
    const costUnitValue = Number(props.orderDetail.goods.cost_unit) || 0;
    return amountValue * costUnitValue;
});
const deliveryDate = ref(props.orderDetail.Ord_date || '');
const actualDeliveryDate = ref(props.orderDetail.Fin_date || '');

const form = useForm({
    amount: Amount.value,
    delivery_date: deliveryDate.value,
    actual_delivery_date: actualDeliveryDate.value,
    tot_prc:total_prc.value,
});


const UpdateOrderDetail = () => {
    form.amount = Amount.value;
    form.delivery_date = document.getElementById('datepicker-1').value;
    form.actual_delivery_date = document.getElementById('datepicker-2').value;
    form.tot_prc = total_prc.value;

    form.patch(route('order.edit.detail.update', {
        order_id: props.orderHeader.Order_no,
        cus_id: props.orderHeader.cus_id,
        order_detail_id: props.orderDetail.order_detail_id
    }),{

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
                        <form @submit.prevent="UpdateOrderDetail">
                            <div class="mt-8">
                                <div class="ml-12">
                                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        สถานะ เพิ่มรายการส่วน Header การรับคำสั่งซื้อสินค้า
                                    </div>
                                    <div class="mt-6">
                                        <div class="mb-6">
                                            เพิ่มข้อมูล Header
                                        </div>
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
                                                <input type="text" id="cus_name"
                                                    v-model="orderHeader.customers.cus_name"
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
                                <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700" />
                                <div class="flex flex-row mb-6 ml-12 ">
                                    <div class="mr-6">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                                        <input type="text" v-model="orderDetail.goods_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="รหัสสินค้า" disabled />
                                    </div>
                                    <div class="mr-6 w-2/3">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า</label>
                                        <input type="text" id="last_name" v-model="orderDetail.goods.goods_name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="รายละเอียดสินค้า" disabled/>
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
                                            <input datepicker id="datepicker-1" type="text" v-model="deliveryDate"
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
                                            <input datepicker id="datepicker-2" type="text" v-model="actualDeliveryDate"
                                                datepicker-format="yyyy-mm-dd"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
                                        <input type="text" id="cost_unit" v-model="orderDetail.goods.cost_unit"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="ราคา/หน่วย" required disabled />
                                    </div>
                                    <div class="ml-10">
                                        <label
                                            class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ราคารวม</label>
                                        <input type="text" id="tot_prc" v-model="total_prc"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="ราคารวม" required disabled />
                                    </div>
                                </div>
                                <button type="submit"
                                    class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">บันทึกข้อมูล</button>
                            </div>
                        </form>
                    </div>

                    <div class="flex justify-end mt-8">
                        <Link :href="route('order.detail',{cus_id:orderHeader.cus_id,order_id:orderHeader.Order_no})" type="button"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-m px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        ออก</Link>
                    </div>
                </div>
            </div>
        </div>

    </appLayout>

</template>
