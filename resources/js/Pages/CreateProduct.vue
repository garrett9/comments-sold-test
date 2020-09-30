<template>
    <app-layout>
        <template #header>
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link class="text-blue-500" href="/products"
                    >Products</inertia-link
                >
                / Create a Product
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="save()">
                    <template #title>Product Details</template>
                    <template #description
                        >Please enter the details of your new product.</template
                    >
                    <template #form>
                        <form-group
                            label="Product Name"
                            :errors="form.errors('product_name')"
                        >
                            <jet-input
                                autofocus
                                required
                                name="product_name"
                                type="text"
                                v-model="form.product_name"
                                placeholder="Product Name"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Description"
                            :errors="form.errors('description')"
                        >
                            <app-textarea
                                name="description"
                                v-model="form.description"
                                placeholder="Product Description"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Style"
                            :errors="form.errors('style')"
                        >
                            <jet-input
                                name="style"
                                v-model="form.style"
                                placeholder="Product Style"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Brand"
                            :errors="form.errors('brand')"
                        >
                            <jet-input
                                name="brand"
                                v-model="form.brand"
                                placeholder="Product Brand"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Type"
                            :errors="form.errors('product_type')"
                        >
                            <jet-input
                                name="product_type"
                                v-model="form.product_type"
                                placeholder="Product Type"
                            />
                        </form-group>
                    </template>
                    <template #actions
                        ><a href="/products">
                            <jet-secondary-button class="mr-2"
                                >Cancel
                            </jet-secondary-button></a
                        >
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            >Create</jet-button
                        >
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import AppTextarea from "../Components/Textarea";
import FormGroup from "../Components/FormGroup";
import JetButton from "../Jetstream/Button";
import JetFormSection from "../Jetstream/FormSection";
import JetInput from "../Jetstream/Input";
import JetSecondaryButton from "../Jetstream/SecondaryButton";

export default {
    components: {
        AppLayout,
        AppTextarea,
        FormGroup,
        JetInput,
        JetButton,
        JetFormSection,
        JetSecondaryButton
    },

    data() {
        return {
            form: this.$inertia.form({
                product_name: "",
                description: "",
                style: "",
                brand: "",
                product_type: ""
            })
        };
    },

    methods: {
        async save() {
            await this.form.post("/products", this.form);
        }
    }
};
</script>
