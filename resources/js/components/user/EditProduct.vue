<template>
    <div
        class="w-7/12 m-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex w-full">
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
                        Edit the product
                    </h3>
                    <button
                        class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                        @click="$emit('close')">
                    </button>
                </div>
                <!--body-->
                <Form :validation-schema="schema" v-slot="{ errors }" @submit="changeProduct">
                    <div class="relative p-6 flex-auto">
                        <Field placeholder="Name"
                               id="name"
                               type="text"
                               v-model="selectedProduct.name"
                               name="name"
                               class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                               :class="{ 'is-invalid': errors.name }">
                        </Field>
                        <div class="invalid-feedback ">{{ errors.name }}</div>

                        <Field placeholder="Price"
                               id="price"
                               name="price"
                               type="text"
                               v-model="selectedProduct.price"
                               class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                               :class="{ 'is-invalid': errors.price}">
                        </Field>
                        <div class="invalid-feedback ">{{ errors.price }}</div>
                        <Field id="categories"
                               name="category"
                               as="select"
                               v-model="selectedProduct.category_id"
                               :class="{ 'is-invalid': errors.category}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option disabled value="">Please Select</option>
                            <option v-for="category in categories" :value="category.id">
                                {{ category.name }}
                            </option>
                        </Field>
                        <div class="invalid-feedback">{{ errors.category }}</div>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                        <button
                            class="text-green-500 bg-transparent border border-solid border-green-500 hover:bg-green-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="submit">
                            Edit
                        </button>
                        <button
                            class="text-gray-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" @click="$emit('close')">
                            Cancel
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>

<script>
import * as yup from 'yup';
import {Form, Field} from 'vee-validate';

export default {
    name: "EditProduct",
    components: {
        Form,
        Field,
    },
    props: [
        'selectedProduct',
        'changesProd',
        'categories'
    ],
    data() {
        return {
        }
    },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .min(2, "Please enter a name more than 2 character")
                    .max(25, "Name should not exceed 25 characters")
                    .required("The name is required"),
                price: yup.string()
                    .required("The price is required")
                    .matches(/^[0-9](\.[0-9][0-9][0-9])$/, "Only number are allowed for this field example 7.777"),
                category: yup.string()
                    .required("the category name is required")
            });
        }
    },

    methods: {
        changeProduct() {
            axios.post('/edit-product/', this.selectedProduct)
                .then(res => {
                    if (res.data.product) {
                        this.$emit('updateProduct', res.data.product);
                    }
                })
        }
    }
}

</script>

