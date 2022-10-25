<template>

    <div class="w-7/12 m-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex w-full">
        <div class="absolute bg-gray-500 opacity-80 inset-0 z-0"/>
        <div class="relative w-auto my-6 mx-auto max-w-6xl">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <button
                    class="btn-close  absolute top-3 right-2 h-16 w-16"
                    @click="$emit('close')">
                </button>
                <div
                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                    <h3 class="text-3xl font-semibold text-gray-500">
                        Are you sure to delete the Product?
                    </h3>
                </div>
                <!--body-->
                <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                    <button
                        class="text-red-400 bg-transparent border border-solid border-green-500 hover:bg-green-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" @click="deleteProduct()">
                        Delete
                    </button>
                    <button
                        class="text-gray-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" @click="$emit('close')">
                        Cancel
                    </button>
                </div>

                <!--footer-->

            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "DeleteProductModal",
    emits: ["close", "deleteProduct"],
    props: ['id', 'current_page'],
    methods: {

        deleteProduct() {
            axios.post(`/delete-product/`, {id:this.id, current_page:this.current_page})
                .then((res) => {
                    this.$emit('deleteProduct', res.data.product);
                });
        },
    }
}
</script>
