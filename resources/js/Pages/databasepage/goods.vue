<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue';

const form = useForm({
    goods_id: '',
    goods_name: '',
    cost_unit: '',
});

const showMessage = ref(false);
const successMessage = ref('');

const GoodsCreateSubmit = () => {
    form.post(route('goods.store'), {
        onSuccess: () => {
            successMessage.value = 'Goods created successfully!';
            showMessage.value = true;
            handleSubmit();
            form.goods_id = '';
            form.goods_name = '';
            form.cost_unit = '';
        },
        onError: () => {
            // Errors will automatically bind to form.errors
            console.log('Error submitting form:', form.errors);
        },
    });
}
const GoodsDestroy = ($goodsId) => {
    router.delete(route('goods.destroy', $goodsId), {
        onSuccess: () => {
            successMessage.value = 'Goods deleted successfully!';
            showMessage.value = true;
            handleSubmit();
        },
    });
}
const handleSubmit = () => {
    setTimeout(() => {
        showMessage.value = false;
    }, 2000);
};
defineProps({goods:Object});

</script>
<template>

    <Head title="การบันทึก/แก้ไข ข้อมูลสินค้า"></Head>
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
                                    <input type="number" id="cost_unit" aria-describedby="helper-text-explanation" v-model="form.cost_unit"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="ราคา/หน่วย" required  min="0"/>
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
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-base text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                รหัสสินค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                รายละเอียดสินค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ราคา/หน่วย
                                            </th>
                                            <th scope="col" class="flex justify-center px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="good in goods" :key="good.goods_id"
                                        class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ good.goods_id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ good.goods_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ good.cost_unit }}
                                            </td>
                                            <td class="flex justify-center px-6 py-4">
                                                <button type="button"
                                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">แก้ไข</button>
                                                <button type="button" @click="GoodsDestroy(good.goods_id)"
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
    </appLayout>
</template>
