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
                        Edit the Category
                    </h3>
                </div>
                <!--body-->
                <Form :validation-schema="schema" v-slot="{ errors }" @submit="changeCategory">
                    <div class="relative p-6 flex-auto">
                        <Field placeholder="Name"
                               id="name"
                               type="text"
                               v-model="selectedCategory.name"
                               name="name"
                               class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                               :class="{ 'is-invalid': errors.name }">
                        </Field>
                        <div class="invalid-feedback ">{{ errors.name }}</div>

                        <Field placeholder="Description"
                               id="description"
                               as="textarea"
                               type="text"
                               v-model="selectedCategory.description"
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
    name: "EditCategory",
    components: {
        Form,
        Field,
    },
    props: [
        'selectedCategory',
        'changesCat'
    ],
    data() {
        return {
                   }
    },

    methods: {
        changeCategory(category) {

            axios.post('/edit-category/', this.selectedCategory)
                .then(res => {
                    this.$emit('updateCategory', res.data.category);
                    if (res.data.post) {
                        this.changesCat.name = this.selectedCategory.name;
                        this.changesCat.description = this.selectedCategory.description;
                    }
                })
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
}

</script>

