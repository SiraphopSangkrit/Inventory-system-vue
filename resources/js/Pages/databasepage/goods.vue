<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue';

const form = useForm({
    goods_id: '',
    goods_name: '',
    cost_unit: '',
});

const formEdit = useForm({
    goods_id_Edit: null,
    goods_name_Edit: '',
    goods_cost_unit_Edit: '',


});
const showMessage = ref(false);
const successMessage = ref('');
const GoodsEditModal = ref(false);

const GoodsCreateSubmit = () => {
    form.post(route('goods.store'), {
        onSuccess: () => {
            Swal.fire({ title: "เพิ่มสินค้าแล้วเรียบร้อย", icon: "success", timer: 2000 });
            form.goods_id = '';
            form.goods_name = '';
            form.cost_unit = '';
        },
        onError: () => {
            console.log('Error submitting form:', form.errors);
        },
    });
}

const openEditModal = (good) => {
    formEdit.goods_id_Edit = good.goods_id;
    formEdit.goods_name_Edit = good.goods_name;
    formEdit.goods_cost_unit_Edit = good.cost_unit;
    GoodsEditModal.value = true;
};

const GoodsUpdateSubmit = (good) => {
    formEdit.patch(route('goods.update', { id: formEdit.goods_id_Edit }), {
        onSuccess: () => {
            Swal.fire({ title: "แก้ไขสินค้าแล้วเรียบร้อย", icon: "success", timer: 2000 });
            handleClose();
            formEdit.goods_id_Edit = '';
            formEdit.goods_name_Edit = '';
            formEdit.goods_cost_unit_Edit = '';
        },
        onError: () => {
            console.log('Error submitting form:', formEdit.errors);
        },
    });
}

defineProps({ goods: Object });

const handleDelete = ($goodsId) => {
    Swal.fire({
        title: 'ต้องการลบสิ่งนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ไม่ต้องการ',
        confirmButtonText: 'ใช่,ฉันต้องการลบ!',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('goods.destroy', $goodsId),);
            Swal.fire(
                { title: "ลบสินค้าแล้วเรียบร้อย", icon: "success", timer: 2000 }
            );
        }
    });
};

const handleClose = () => {
    GoodsEditModal.value = false;
};

</script>
<template>

    <Head title="ระบบจัดการสินค้าคงคลัง"></Head>
    <appLayout>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-center">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                การบันทึก/แก้ไข ข้อมูลสินค้า
                            </h2>
                        </div>
                        <ActionMessage :on="showMessage">
                            <div v-if="successMessage"
                                class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <span class="font-medium">{{ successMessage }}</span>
                            </div>
                        </ActionMessage>

                        <form @submit.prevent="GoodsCreateSubmit">
                            <div class="flex flex-row mb-6 mt-6 ml-6">
                                <div class="mr-6 w-1/6">
                                    <label
                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสสินค้า
                                    </label>
                                    <input type="text" id="goods_id" v-model="form.goods_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="รหัสสินค้า " required />
                                    <InputError class="mt-2" :message="form.errors.goods_id" />
                                </div>
                                <div class="mr-6 w-3/6">
                                    <label
                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                                    </label>
                                    <input type="text" id="goods_name" v-model="form.goods_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="รายละเอียดสินค้า " required />
                                    <InputError class="mt-2" :message="form.errors.goods_name" />
                                </div>
                                <div class="mr-6">
                                    <label
                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ราคา/หน่วย
                                    </label>
                                    <input type="number" id="cost_unit" aria-describedby="helper-text-explanation"
                                        v-model="form.cost_unit"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="ราคา/หน่วย" required min="0" />
                                    <InputError class="mt-2" :message="form.errors.cost_unit" />
                                </div>
                                <div class="p-2.5 mt-6">
                                    <button type="submit"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm p-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่ม</button>
                                </div>
                            </div>
                        </form>


                        <hr class="h-px my-12 bg-gray-200 border-0 dark:bg-gray-700" />
                        <div class="mx-6 mt-8">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-m text-left rtl:text-right text-gray-500 dark:text-white">
                                    <thead
                                        class="text-base text-center  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="text-center px-6 py-3">
                                                รหัสสินค้า
                                            </th>
                                            <th scope="col" class="text-center px-6 py-3">
                                                รายละเอียดสินค้า
                                            </th>
                                            <th scope="col" class="text-center px-6 py-3">
                                                ราคา/หน่วย
                                            </th>
                                            <th scope="col" class="text-center px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="good in goods" :key="good.goods_id"
                                            class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                            <th scope="row"
                                                class=" text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ good.goods_id }}
                                            </th>
                                            <td class="text-center px-6 py-4">
                                                {{ good.goods_name }}
                                            </td>
                                            <td class="text-center px-6 py-4">
                                                {{ good.cost_unit }}
                                            </td>
                                            <td class="text-center  px-6 py-4">
                                                <button type="button" @click="openEditModal(good)"
                                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">แก้ไข</button>
                                                <button type="button" @click="handleDelete(good.goods_id)"
                                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบ</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        </div>
        <Modal :show="GoodsEditModal" @close="handleClose" maxWidth="6xl" closeable>
            <template #default>
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        แก้ไขรายการสินค้า
                    </h3>
                    <button type="button" @click="GoodsEditModal = false"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form @submit.prevent="GoodsUpdateSubmit" class="space-y-4">
                        <div class="flex flex-row mb-6 mt-6 ml-6">
                            <div class="mr-6 w-1/6">
                                <label class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสสินค้า
                                </label>
                                <input type="text" id="goods_id" v-model="formEdit.goods_id_Edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="รหัสสินค้า " disabled />

                            </div>
                            <div class="mr-6 w-3/6">
                                <label
                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                                </label>
                                <input type="text" id="goods_name" v-model="formEdit.goods_name_Edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="รายละเอียดสินค้า " required />

                            </div>
                            <div class="mr-6">
                                <label class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ราคา/หน่วย
                                </label>
                                <input type="number" id="cost_unit" aria-describedby="helper-text-explanation"
                                    v-model="formEdit.goods_cost_unit_Edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="ราคา/หน่วย" required min="0" />
                            </div>
                            <div class="p-2.5 mt-6 max-w-fit">
                                <button type="submit"
                                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-m p-5 py-2.5 me-2 mb-2 w-full dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">แก้ไข</button>
                            </div>
                        </div>
                    </form>
                </div>
            </template>
        </Modal>
    </appLayout>
</template>
