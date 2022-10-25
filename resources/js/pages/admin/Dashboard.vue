<template>

    <div class="py-12">
        <div class="max-w-[85%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class=" text-xxl  text-green-500">
                            Products
                        </h1>
                    </div>
                    <div class="p-3">
                        <div class="overflow-x-auto">

                            <table class="table-auto w-full">
                                <thead class="text-xs  uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Name</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Price</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Status</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Category</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Created Date</div>
                                    </th>
                                    <th class="p-2 whitespace-nowrap">
                                        <div class=" text-center">Actions</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in allProducts.data">
                                    <td class="border px-4 py-2 text-center">{{ product.name }}</td>
                                    <td class="border px-2 py-2 text-center">{{ product.price }}</td>
                                    <td class="border py-3 px-6 text-center">
                            <span
                                :class="product.status === 'pending' ? 'bg-yellow-500' : product.status === 'reject' ? 'bg-red-500' : 'bg-green-700'"
                                class="text-white py-2 px-4 rounded-full text-xs"
                            >
                            {{ product.status }}
                            </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center">{{ product.category.name }}</td>
                                    <td class="border px-4 py-2 text-center">{{ product.created_at }}</td>
                                    <td class="px-2 py-2 space-x-4 md:border md:border-grey-500 text-left block md:table-cell text-center">
                                        <button
                                            :disabled="product.status === 'approve'"
                                            :class="product.status === 'approve' ? 'bg-green-700' : 'bg-green-700 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out'"
                                            class="btn btn-success btn-sm w-20
                                            bg-gradient-to-r from-green-500 via-green-600
                                            to-green-700 hover:bg-gradient-to-br focus:ring-4
                                            focus:outline-none focus:ring-green-400
                                            dark:focus:ring-green-800 shadow-lg shadow-green-500/50
                                            dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg"
                                            @click="changeProductStatus(product, 'approve')"
                                        >
                                            Approve
                                        </button>
                                        <button
                                            :disabled="product.status === 'reject'"
                                            :class="product.status === 'reject' ? 'bg-red-600' : 'bg-red-600 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out'"
                                            class="btn btn-danger btn-sm w-20
                                            bg-gradient-to-r from-red-500 via-red-600
                                            to-red-700 hover:bg-gradient-to-br focus:ring-4
                                            focus:outline-none focus:ring-red-400
                                            dark:focus:ring-red-800 shadow-lg shadow-red-500/50
                                            dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg"
                                            @click="changeProductStatus(product, 'reject')"
                                        >
                                            Reject
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div v-if="allProducts.links.length > 3">
                                <div class="mt-10 flex justify-center">
                                    <template v-for="(link, key) in allProducts.links" :key="key">
                                        <div
                                            v-if="link.url === null"
                                            class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                                            v-html="link.label"
                                        />
                                        <a
                                            v-else
                                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded focus:border-primary focus:text-primary"
                                            :class="{ 'bg-green-500 text-white': link.active }"
                                            :href="link.url"
                                            v-html="link.label"
                                        ></a>
                                    </template>
                                </div>
                            </div>

                            <change-product-status
                                v-if="openStatusProductModal"
                                :changesProductId="changesProduct.id"
                                :status="newStatus"
                                @close="openStatusProductModal = false"
                                @changedStatusProduct="changedStatusProduct">

                            </change-product-status>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import ChangeProductStatus from "../../components/admin/ChangeProductStatus.vue";

export default {
    name: "Dashboard.vue",

    components: {
        ChangeProductStatus
    },

    props: [
        'products',
    ],

    data() {
        return {
            openStatusProductModal: false,
            allProducts: [],
            changesProduct: {},
            newStatus: ''
        }
    },

    methods: {
        changeProductStatus(product, status) {
            this.openStatusProductModal = !this.openStatusProductModal;
            this.changesProduct = product;
            this.newStatus = status;
        },

        changedStatusProduct() {
            this.changesProduct.status = this.newStatus;
            this.openStatusProductModal = false;
        }
    },

    created() {
        this.allProducts = this.products
    }
}
</script>
