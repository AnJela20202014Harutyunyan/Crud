<template>
    <div>
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
                            Add new Category
                        </h3>

                    </div>
                    <!--body-->
                    <Form :validation-schema="schema" v-slot="{ errors }" @submit="saveCategories">
                        <div class="relative p-6 flex-auto">
                            <Field placeholder="Name"
                                   id="name"
                                   type="text"
                                   v-model="category.name"
                                   name="name"
                                   class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                                   :class="{ 'is-invalid': errors.name }">
                            </Field>
                            <div class="invalid-feedback ">{{ errors.name }}</div>

                            <Field placeholder="Description"
                                   id="description"
                                   type="text"
                                   v-model="category.description"
                                   name="description"
                                   class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                                   :class="{ 'is-invalid': errors.description}">
                            </Field>
                            <div class="invalid-feedback ">{{ errors.description }}</div>
                        </div>
                        <!--footer-->
                        <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                            <button
                                class="text-green-500 bg-transparent border border-solid border-green-500 hover:bg-green-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="submit">
                                Add
                            </button>
                            <button
                                class="text-green-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" @click="$emit('close')">
                                Close
                            </button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import * as yup from 'yup';
import {Form, Field} from 'vee-validate';

export default {
    name: "AddCategories",
    emits: ['addCategory', 'close'],
    components: {
        Form,
        Field,
    },
    data() {
        return {
            category: {
                'name': '',
                'description': '',
            },
        }
    },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .min(2, "Please enter a name more than 2 character")
                    .max(25, "Name should not exceed 25 characters")
                    .required("The name is required"),
                description: yup.string()
                    .min(3, "Please enter a description more than 3 character")
                    .max(255, "Description should not exceed 255 characters")
            });
        }
    },

    methods: {
        saveCategories: function () {
            axios.post('/save-categories', this.category)
                .then(res => {
                    this.$emit('addCategory', res.data.category);
                })
                .catch(error => {
                    this.addError = error.response.data.message
                });
        }
    }
}
</script>

