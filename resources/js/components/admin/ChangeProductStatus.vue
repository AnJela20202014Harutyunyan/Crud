<template>
    <div
        class="w-7/12 m-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex w-full">
        <div class="absolute bg-gray-500 opacity-80 inset-0 z-0"/>
        <div class="relative w-auto my-6 mx-auto max-w-6xl">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div
                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                    <button
                        class="btn-close  absolute top-3 right-2 h-16 w-16"
                        @click="$emit('close')">
                    </button>
                    <h3 class="text-3xl">
                        Are you sure to {{ status }} this product?
                    </h3>
                </div>
                <!--footer-->
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button
                        class="text-green-500 bg-transparent border border-solid border-green-500 hover:bg-green-500  active:bg-green-600 font-bold uppercase text-sm px-4 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" @click="changeProductStatus">
                        Yes
                    </button>
                    <button
                        class="text-green-500 bg-transparent border border-solid border-green-500 hover:bg-green-500  active:bg-green-600 font-bold uppercase text-sm px-4 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" @click="$emit('close')">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChangeProductStatus.vue",

    props: [
        'status',
        'changesProductId'
    ],

    data() {
        return {
            allProducts: [],
            product: []
        }
    },

    methods: {
        changeProductStatus() {
            axios.post('/change-status', {id: this.changesProductId, status: this.status})
                .then(() => {
                    this.$emit('changedStatusProduct');
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
 }
</script>

