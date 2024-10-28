<script setup>
import appLayout from '@/Layouts/appLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue';

const form = useForm({
    cus_id: '',
    cus_name: '',

});

const showMessage = ref(false);
const successMessage = ref('');

const CustomerCreateSubmit = () =>{
    form.post(route('customer.store'), {
        onSuccess: () => {
            successMessage.value = 'Customer created successfully!';
            showMessage.value = true;
            handleSubmit();
            form.cus_id = '';
            form.cus_name = '';

        },

    });
}
const CustomerDestroy =  ($customerId)=> {
    router.delete(route('customer.destroy', $customerId), {
        onSuccess: () => {
            successMessage.value = 'Customer deleted successfully!';
            showMessage.value = true;
        },
    });
}
const handleSubmit = () => {
    setTimeout(() => {
        showMessage.value = false;
    }, 2000);
};

defineProps({ customers: Object });
</script>
<template>

    <Head title="การบันทึก/แก้ไข ข้อมูลลูกค้า"></Head>
    <appLayout>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-center">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                การบันทึก/แก้ไข ข้อมูลลูกค้า
                            </h2>
                        </div>
                        <ActionMessage :on="showMessage">
                            <div v-if="successMessage"
                                class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <span class="font-medium">{{ successMessage }}</span>
                            </div>
                        </ActionMessage>
                        <ActionMessage :on="showErrorMessage">
                            <div v-if="errorMessage"
                                class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                <span class="font-medium">{{ errorMessage }}</span>
                            </div>
                        </ActionMessage>
                        <form @submit.prevent="CustomerCreateSubmit">
                            <div class="flex flex-row mb-6 mt-6 ml-6">
                                <div class="mr-6">
                                    <label
                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">รหัสลูกค้า
                                    </label>
                                    <input type="text" id="cus_id" v-model="form.cus_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="รหัสลูกค้า" required />
                                        <InputError class="mt-2" :message="form.errors.cus_id" />
                                </div>
                                <div class="mr-6">
                                    <label
                                        class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ชื่อลูกค้า</label>
                                    <input type="text" id="cus_name" v-model="form.cus_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="ชื่อลูกค้า" required />
                                        <InputError class="mt-2" :message="form.errors.cus_name" />

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
                                                รหัสลูกค้า
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                รายละเอียดลูกค้า
                                            </th>

                                            <th scope="col" class="flex justify-center px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customer in customers" :key="customer.cus_id"
                                            class="bg-white border-b dark:bg-gray-600 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ customer.cus_id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ customer.cus_name }}
                                            </td>
                                            <td class="flex justify-center px-6 py-4">
                                                <button type="button"
                                                    class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">แก้ไข</button>
                                                <button type="button" @click="CustomerDestroy(customer.cus_id)"
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
