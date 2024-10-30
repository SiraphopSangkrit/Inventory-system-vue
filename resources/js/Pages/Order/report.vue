<script setup>
import appLayout from '@/Layouts/appLayout.vue';
import { Link, Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import '@/Sarabun-Regular-normal'

const props = defineProps({ dOrders: Object });

const gdoc_date1 = ref('');
const gdoc_date2 = ref('');

const form = useForm({
    gdoc_date1: '',
    gdoc_date2: '',
});



const filterOrders = () => {
    form.gdoc_date1 = document.getElementById('datepicker-range-start').value;
    form.gdoc_date2 = document.getElementById('datepicker-range-end').value;
    form.get(route('order.report', { gdoc_1: form.gdoc_date1, gdoc_2: form.gdoc_date2 }), {
        preserveState: true, onSuccess: (response) => {
            if (!response.props.dOrders || response.props.dOrders.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่มีข้อมูล',
                    text: 'ไม่พบข้อมูลสำหรับช่วงวันที่ที่เลือก',
                    timer: 1000
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'พบข้อมูล',
                    text: 'พบข้อมูลสำหรับช่วงวันที่ที่เลือก',
                    timer: 1000
                });
            }
        }
    });
};

function printTable() {
    const printWindow = window.open('', '_blank');

    const today = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = today.toLocaleDateString('th-TH', options);
    printWindow.document.write(`
        <html>
        <head>
            <title >รายงานแสดงข้อมูลที่ครบกำหนดส่งสินค้าแล้วยังไม่ได้ส่งสินค้า วันที่: ${formattedDate} </title>

            	<link rel="preconnect" href="https://fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">

            <style>
                body { font-family: 'Tahoma', sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th,td { border: 2px solid #000; padding: 10px; text-align: center;}
                th { background-color: #f2f2f2;  }
                @media print {
                    button { display: none; }
                }
            </style>
        </head>
        <body>
            <h2><p>รายงานแสดงข้อมูลที่ครบกำหนดส่งสินค้าแล้วยังไม่ได้ส่งสินค้า</p>
                <p>วันที่: ${formattedDate}</p>
                </h2>
            ${document.querySelector('.relative.overflow-x-auto').outerHTML}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
    printWindow.close();
}

const totalAmount = computed(() => {
    return props.dOrders.reduce((total, order) => {
        return total + (order.amount || 0);
    }, 0);
});

const totalTotPrc = computed(() => {
    return props.dOrders.reduce((total, order) => {
        return total + (order.tot_prc || 0);
    }, 0);
});

const exportToExcel = () => {
    const header = [
        'ลำดับ', 'รายละเอียดลูกค้า', 'รายละเอียดสินค้า',
        'วันที่สั่ง', 'เลขที่สั่ง', 'วันกำหนดส่ง',
        'จำนวน', 'ราคา/หน่วย', 'ราคารวม'
    ];


    const tableData = props.dOrders.map((order, index) => ([
        index + 1,
        `${order.h_order.customers.cus_id} : ${order.h_order.customers.cus_name}`,
        `${order.goods.goods_id} : ${order.goods.goods_name}`,
        order.h_order.formatted_order_date,
        order.h_order.Order_no,
        order.formatted_ord_date,
        order.amount,
        order.goods.cost_unit,
        order.tot_prc
    ]));
    tableData.unshift(header);

    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.aoa_to_sheet(tableData);
    const today = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    XLSX.utils.book_append_sheet(workbook, worksheet, "Orders Report");
    XLSX.writeFile(workbook, `Order_Report_${new Date().toLocaleDateString('th-TH', options)}.xlsx`);
};

const generatePDF = () => {
    const doc = new jsPDF('p', 'mm', 'a4');



    const today = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = today.toLocaleDateString('th-TH', options);
    doc.setFont('Sarabun-Regular','normal');

    doc.text(`รายงานแสดงข้อมูลที่ครบกำหนดส่งสินค้าแล้วยังไม่ได้ส่งสินค้า วันที่: ${formattedDate}`, 10, 10);


    const tableData = props.dOrders.map((order, index) => ([
        index + 1,
        `${order.h_order.customers.cus_id} : ${order.h_order.customers.cus_name}`,
        `${order.goods.goods_id} : ${order.goods.goods_name}`,
        order.h_order.formatted_order_date,
        order.h_order.Order_no,
        order.formatted_ord_date,
        order.amount,
        order.goods.cost_unit,
        order.tot_prc
    ]));


    const columns = [
        { header: 'ลำดับ', dataKey: 'index' },
        { header: 'รายละเอียดลูกค้า', dataKey: 'customer' },
        { header: 'รายละเอียดสินค้า', dataKey: 'goods' },
        { header: 'วันที่สั่ง', dataKey: 'orderDate' },
        { header: 'เลขที่สั่ง', dataKey: 'orderNo' },
        { header: 'วันกำหนดส่ง', dataKey: 'deliveryDate' },
        { header: 'จำนวน', dataKey: 'amount' },
        { header: 'ราคา/หน่วย', dataKey: 'unitPrice' },
        { header: 'ราคารวม', dataKey: 'totalPrice' },
    ];

    const rows = tableData.map((order, index) => ({
        index: order[0],
        customer: order[1],
        goods: order[2],
        orderDate: order[3],
        orderNo: order[4],
        deliveryDate: order[5],
        amount: order[6],
        unitPrice: order[7],
        totalPrice: order[8],
    }));


    doc.autoTable({
        head: [columns.map(col => col.header)],
        body: rows.map(row => columns.map(col => row[col.dataKey])),
        startY: 20,
        theme: 'grid',
        styles: {
            font: "Sarabun-Regular"
        }
    });

    doc.save(`Order_Report_${formattedDate}.pdf`);
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
                                รายงานแสดงข้อมูลที่ครบกำหนดส่งสินค้าแล้วยังไม่ได้ส่งสินค้า
                            </h2>
                        </div>
                        <div class="mt-8">
                            <div class="ml-12">
                                <div class="mt-6">
                                    <div id="date-range-picker" date-rangepicker class="flex flex-row mb-6">
                                        <div class="flex justify-center mb-6">
                                            <div class="mr-6">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">วันที่กำหนดส่งตามแผน:
                                                </label>
                                                <input type="text" id="datepicker-range-start" name="start"
                                                    v-model="form.gdoc_date1" datepicker-format="yyyy-mm-dd"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="วันที่กำหนดส่งตามแผน" required />
                                            </div>
                                        </div>
                                        <div class="flex justify-center mb-6">
                                            <div class="mr-2">
                                                <label
                                                    class="block mb-2 text-m font-medium text-gray-900 dark:text-white">ถึงวันที่
                                                    :
                                                </label>
                                                <input type="text" id="datepicker-range-end" name="end"
                                                    v-model="form.gdoc_date2" datepicker-format="yyyy-mm-dd"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="ถึงวันที่" required />
                                            </div>
                                        </div>
                                        <div class="p-2.5 mt-6">
                                            <button type="button" @click="filterOrders"
                                                class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-m w-full  sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">แสดง</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="relative overflow-x-auto">
                        <table class="w-full text-m text-left rtl:text-right text-gray-500 dark:text-white">
                            <thead
                                class="text-m text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="text-center px-6 py-3 rounded-s-lg">
                                        ลำดับ
                                    </th>

                                    <th scope="col" class="text-center px-6 py-3">
                                        รายละเอียดลูกค้า
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        รายละเอียดสินค้า
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        วันที่สั่ง
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        เลขที่สั่ง
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        วันกำหนดส่ง
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        จำนวน
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        ราคา/หน่วย
                                    </th>
                                    <th scope="col" class="text-center px-6 py-3">
                                        ราคารวม
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(order, index) in dOrders" :key="order.order_detail_id"
                                    class="bg-white border-b dark:bg-gray-600 dark:border-gray-700 ">
                                    <th scope="row"
                                        class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ index + 1 }}
                                    </th>
                                    <td class="px-6 py-4 text-center">
                                        {{ order.h_order.customers.cus_id }} : {{ order.h_order.customers.cus_name }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.goods.goods_id }} : {{ order.goods.goods_name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ order.h_order.formatted_order_date }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.h_order.Order_no }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.formatted_ord_date }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.amount }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.goods.cost_unit }}
                                    </td>
                                    <td class="text-center px-6 py-4">
                                        {{ order.tot_prc }}
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-gray-900 dark:text-white">
                                    <th scope="row" class="text-center px-6 py-3 text-base">Total</th>
                                    <td class=" text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3">{{ totalAmount }}</td>
                                    <td class="text-center px-6 py-3"></td>
                                    <td class="text-center px-6 py-3">{{ totalTotPrc }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex justify-end mt-8">
                        <div class="inline-flex rounded-md" role="group">
                            <button type="button" @click="generatePDF"
                                class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                Export to PDF
                            </button>
                            <button type="button" @click="exportToExcel"
                                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Export to Excel
                            </button>
                            <button type="button" @click="printTable"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">พิมพ์</button>

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
