<template>
    <!--THE CATEGORY TABLE-->
    <div class="py-12">
        <div class="max-w-[85%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 font-bold ">
                    <button type="button"
                            class="float-right text-green-800 mt-1
                            	   inline-block px-2 py-2.5 text-white
                            	   bg-gradient-to-r from-green-400
                            	   via-green-500 to-green-600 hover:bg-gradient-to-br
                            	   focus:ring-4 focus:outline-none focus:ring-green-300
                            	   dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg
                            	   ark:shadow-green-800/80 font-medium rounded-lg text-sm
                            	   ext-center mr-2 mb-2"
                            @click="openAddCategoryModal = !openAddCategoryModal">Add Category
                    </button>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-green-500">THE CATEGORIES TABLE</h3>
                    </div>
                    <div class="p-3">
                        <div class="overflow-x-auto">
                            <div v-if="Object.values(categories).length">
                                <table class="table-auto w-full">
                                    <thead class="font-bold text-sm uppercase  bg-gray-50 text-gray-400">
                                    <tr>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class="text-center font-semibold">Name</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class="text-center">Description</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class="text-center">Status</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class="text-center">Created Date</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class="text-center">Actions</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="category in categories.data">
                                        <td class="border py-3 px-6 text-center">
                                            {{ category.name }}
                                        </td>
                                        <div class="form-outline text-600">
                                            <textarea class="form-control" disabled
                                                      rows="2">{{ category.description }}</textarea>
                                        </div>
                                        <td class="border py-3 px-6 text-center">
                                            {{ category.status }}
                                        </td>
                                        <td class="border py-3 px-6 text-center">
                                            {{ category.created_at }}
                                        </td>
                                        <td class="border py-3 px-6 text-center space-x-2">
                                            <button class="btn btn-success btn-sm w-20
                                        bg-gradient-to-r from-green-500 via-green-600
                                        to-green-700 hover:bg-gradient-to-br focus:ring-4
                                        focus:outline-none focus:ring-green-400
                                        dark:focus:ring-green-800 shadow-lg shadow-green-500/50
                                        dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg"
                                                    @click="editCategory(category)">Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm w-20
                                        bg-gradient-to-r from-red-500 via-red-600
                                        to-red-700 hover:bg-gradient-to-br focus:ring-4
                                        focus:outline-none focus:ring-red-400
                                        dark:focus:ring-red-800 shadow-lg shadow-red-500/50
                                        dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg"
                                                    @click="deleteCategoryModal(category.id)"> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div v-if="categories.links.length > 3">
                                    <div class="flex flex-wrap mt-8">
                                        <template v-for="(link, key) in categories.links" :key="key">
                                            <div
                                                v-if="link.url === null"
                                                class="mr-1 mb-2 text-sm leading-4 text-gray-400 border rounded"
                                                v-html="link.label"
                                            />

                                            <button
                                                v-else
                                                @click="getCategories(link.url)"
                                                class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded focus:border-primary focus:text-primary"
                                                :class="{ 'bg-green-500 text-white': link.active }"
                                                v-html="link.label"
                                            ></button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div role="status">
                                    <svg
                                        class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <AddCategories
        v-if="openAddCategoryModal"
        @addCategory="addCategory"
        @close="openAddCategoryModal = false">
    </AddCategories>

    <EditCategory
        v-if="openCategoryEditModal"
        @close="openCategoryEditModal = false"
        @updateCategory="openCategoryEditModal = false"
        :selectedCategory="selectedCategory"
        :changesCat="changesCat">
    </EditCategory>

    <DeleteCategoryModal
        v-if="openDeleteCategoryModal"
        :id="selectedCategoryId"
        @close="openDeleteCategoryModal = false"
        :current_page="categories.current_page"
        @deleteCategory="deleteCategory">
    </DeleteCategoryModal>


    <!--THE PRODUCT TABLE-->
    <div class="py-12">
        <div class="max-w-[85%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 font-bold ">
                    <button type="button"
                            class="float-right text-green-800 mt-1
                            	   inline-block px-2 py-2.5 text-white
                            	   bg-gradient-to-r from-green-400
                            	   via-green-500 to-green-600 hover:bg-gradient-to-br
                            	   focus:ring-4 focus:outline-none focus:ring-green-300
                            	   dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg
                            	   ark:shadow-green-800/80 font-medium rounded-lg text-sm
                            	   ext-center mr-2 mb-2"
                            @click="openAddProductModal = !openAddProductModal">Add Product
                    </button>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-green-500">THE PRODUCTS TABLE</h3>
                    </div>

                    <div class="p-3">
                        <div class="overflow-x-auto">
                            <div v-if="Object.values(products).length">
                                <table class="table-auto w-full">
                                    <thead class="font-bold text-sm uppercase  bg-gray-50 text-gray-400">
                                    <tr>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center font-semibold">Name</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center">Price</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center">Status</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center">Category</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center">Created Date</div>
                                        </th>
                                        <th class="border p-2 whitespace-nowrap">
                                            <div class=" text-center">Actions</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product in products.data">
                                        <td class="border py-3 px-6 text-center">{{ product.name }}</td>
                                        <td class="border py-3 px-6 text-center">{{ product.price }}</td>

                                        <td class="border py-3 px-6 text-center">
                            <span
                                :class="product.status === 'pending' ? 'bg-yellow-500' : product.status === 'reject' ? 'bg-red-500' : 'bg-green-700'"
                                class="text-white py-2 px-4 rounded-full text-xs"
                            >
                            {{ product.status }}
                            </span>
                                        </td>
                                        <td class="border py-3 px-6 text-center">{{ product.category.name }}</td>
                                        <td class="border py-3 px-6 text-center">{{ product.created_at }}</td>

                                        <td class="border py-3 px-6 text-center space-x-2">
                                            <button class="btn btn-success btn-sm w-20
                                        bg-gradient-to-r from-green-500 via-green-600
                                        to-green-700 hover:bg-gradient-to-br focus:ring-4
                                        focus:outline-none focus:ring-green-400
                                        dark:focus:ring-green-800 shadow-lg shadow-green-500/50
                                        dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg"
                                                    @click=editProduct(product)>
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm w-20
                                        bg-gradient-to-r from-red-500 via-red-600
                                        to-red-700 hover:bg-gradient-to-br focus:ring-4
                                        focus:outline-none focus:ring-red-400
                                        dark:focus:ring-red-800 shadow-lg shadow-red-500/50
                                        dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg"
                                                    @click="deleteProductModal(product.id)">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div v-if="products.links.length > 3">
                                    <div class="flex flex-wrap mt-8">
                                        <template v-for="(link, key) in products.links" :key="key">
                                            <div
                                                v-if="link.url === null"
                                                class="mr-1 mb-1 text-sm leading-4 text-gray-400 border rounded"
                                                v-html="link.label"
                                            />

                                            <button
                                                v-else
                                                @click="getProducts(link.url)"
                                                class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded focus:border-primary focus:text-primary"
                                                :class="{ 'bg-green-500 text-white': link.active }"
                                                v-html="link.label"
                                            ></button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div role="status">
                                    <svg
                                        class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <AddProducts
        v-if="openAddProductModal"
        @addProduct="addProduct"
        @close="openAddProductModal = false"
        :categories="categoryList">
    </AddProducts>

    <EditProduct
        v-if="openProductEditModal"
        @close="openProductEditModal = false"
        @updateProduct="openProductEditModal = false"
        :selectedProduct="selectedProduct"
        :changesProd="changesProd"
        :categories="categoryList">
    </EditProduct>

    <DeleteProductModal
        v-if="openDeleteProductModal"
        :id="selectedProductId"
        @close="openDeleteProductModal = false"
        :current_page="products.current_page"
        @deleteProduct="deleteProduct">
    </DeleteProductModal>

</template>

<script>
import AddProducts from "../../components/user/AddProducts.vue";
import AddCategories from "../../components/user/AddCategories.vue";
import DeleteProductModal from "../../components/user/DeleteProductModal.vue";
import DeleteCategoryModal from "../../components/user/DeleteCategoryModal.vue";
import EditProduct from "../../components/user/EditProduct.vue";
import EditCategory from "../../components/user/EditCategory.vue";

export default {
    name: "UserDashboard",
    components: {
        EditCategory,
        EditProduct,
        DeleteCategoryModal,
        DeleteProductModal,
        AddCategories,
        AddProducts,
    },

    data() {
        return {
            showModal: false,
            selectedProduct: {},
            selectedCategory: {},
            selectedProductId: null,
            selectedCategoryId: null,
            changesProd: {},
            changesCat: {},
            openAddCategoryModal: false,
            openAddProductModal: false,
            openProductEditModal: false,
            openCategoryEditModal: false,
            openDeleteProductModal: false,
            openDeleteCategoryModal: false,
            categories: {},
            products: {},
            categoryList: [],
        }
    },

    methods: {
        addProduct(param) {
            if (this.products.current_page === 1) {
                this.products.data.unshift(param);

                if (this.products.data.length > 5) {
                    this.products.data.pop()
                }
            }

            this.products.total++;

            const productsPages = Math.ceil(this.products.total / 5);
            if (productsPages > (this.products.links.length - 2)) {
                const prodLink = {
                    url: window.location.origin + '/get-products?page=' + productsPages,
                    label: productsPages,
                    active: false
                };
                this.products.links.splice(this.products.links.length - 1, 0, prodLink);
            }

            this.openAddProductModal = false;
        },

        addCategory(param) {
            if (this.categories.current_page === 1) {
                this.categories.data.unshift(param)
            }

            if (this.categories.data.length > 5) {
                this.categories.data.pop()
            }

            this.categories.total++;

            const categoriesPages = Math.ceil(this.categories.total / 5);
            if (categoriesPages > (this.categories.links.length - 2)) {
                const catLink = {
                    url: window.location.origin + '/get-categories?page=' + categoriesPages,
                    label: categoriesPages,
                    active: false
                };

                this.categories.links.splice(this.categories.links.length - 1, 0, catLink);
            }

            this.openAddCategoryModal = false;
            this.getCategoryList();
        },

        editProduct(product) {
            this.openProductEditModal = true
            this.selectedProduct = product;
            this.changesProd = product;
        },

        editCategory(category) {
            this.openCategoryEditModal = true;
            this.selectedCategory = category;
            this.changesCat = category;
        },


        deleteProduct(product) {
            this.products.data.forEach((item, index) => {
                if (item.id === this.selectedProductId) {
                    this.products.data.splice(index, 1);
                }
            });

            if (this.products.data.length === 4) {
                if (product)
                    this.products.data.push(product);
            }

            this.products.total--;
            const perPage = Math.ceil(this.products.total / 5);
            if (perPage < (this.products.links.length - 2)) {
                this.products.links.splice(this.products.links.length - 2, 1);
            }

            if (this.products.data.length === 0 && this.products.current_page !== 1) {
                const pages = this.products.current_page - 1;
                this.getProducts('/get-products?page=' + pages);
            }


            this.openDeleteProductModal = false;
        },


        deleteProductModal(id) {
            this.openDeleteProductModal = true;
            this.selectedProductId = id;
        },

        deleteCategory(category) {
            this.categories.data.forEach((item, index) => {
                if (item.id === this.selectedCategoryId) {
                    this.categories.data.splice(index, 1);
                }
            });

            if (this.categories.data.length === 4) {
                if (category)
                    this.categories.data.push(category);
            }

            this.categories.total--;
            const perPage = Math.ceil(this.categories.total / 5);
            if (perPage < (this.categories.links.length - 2)) {
                this.categories.links.splice(this.categories.links.length - 2, 1);
            }

            if (this.categories.data.length === 0 && this.categories.current_page !== 1) {
                const pages = this.categories.current_page - 1;
                this.getCategories('/get-categories?page=' + pages);
            }


            this.openDeleteCategoryModal = false;
            this.getCategoryList();

            this.products.data = this.products.data.filter(item => item.category_id !== this.selectedCategoryId);
        },

        deleteCategoryModal(id) {
            this.openDeleteCategoryModal = true;
            this.selectedCategoryId = id;
        },

        getCategories(link = null) {
            axios.get(link ?? '/get-categories').then(res => {
                this.categories = res.data.categories;

            });
        },

        getProducts(link = null) {
            axios.get(link ?? '/get-products').then(res => {
                this.products = res.data.products;

            });
        },

        getCategoryList() {
            axios.get('/get-category-list').then(res => {
                this.categoryList = res.data.category_list;
            });
        }
    },

    created() {
        this.getCategories();
        this.getProducts();
        this.getCategoryList();
    }
}
</script>
