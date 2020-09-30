<template>
    <app-layout>
        <template #header>
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link class="text-blue-500" href="/products"
                    >Products</inertia-link
                >
                / {{ product.product_name }}
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="save()">
                    <template #title>Product Details</template>
                    <template #description
                        >Update your product's basic information.</template
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
                                v-model="form.description"
                                name="description"
                                placeholder="Product Description"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Style"
                            :errors="form.errors('style')"
                        >
                            <jet-input
                                v-model="form.style"
                                name="style"
                                placeholder="Product Style"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Brand"
                            :errors="form.errors('brand')"
                        >
                            <jet-input
                                v-model="form.brand"
                                name="brand"
                                placeholder="Product Brand"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            label="Product Type"
                            :errors="form.errors('product_type')"
                        >
                            <jet-input
                                v-model="form.product_type"
                                name="product_type"
                                placeholder="Product Type"
                            />
                        </form-group>
                    </template>
                    <template #actions>
                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            >Save</jet-button
                        >
                    </template>
                </jet-form-section>

                <jet-section-border />

                <jet-form-section>
                    <template #title>
                        Delete Product
                    </template>

                    <template #form>
                        Deleting this product will remove it from your store.
                        <div class="mt-4">
                            <jet-danger-button
                                type="button"
                                @click.native="showDelete = true"
                                >Delete</jet-danger-button
                            >
                        </div>
                    </template>
                </jet-form-section>
            </div>
        </div>

        <jet-confirmation-modal :show="showDelete" @close="showDelete = false">
            <template #content
                >Are you sure you want to delete the product
                <strong>{{ product.product_name }}</strong
                >? It will no longer appear in your store.</template
            >

            <template #footer>
                <form @submit.prevent="destroy()">
                    <jet-secondary-button
                        class="mr-2"
                        type="button"
                        @click.native="showDelete = false"
                        >No</jet-secondary-button
                    >
                    <jet-button
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        >Yes</jet-button
                    >
                </form>
            </template>
        </jet-confirmation-modal>
    </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import AppTextarea from "../Components/Textarea";
import FormGroup from "../Components/FormGroup";
import JetButton from "../Jetstream/Button";
import JetConfirmationModal from "../Jetstream/ConfirmationModal";
import JetDangerButton from "../Jetstream/DangerButton";
import JetFormSection from "../Jetstream/FormSection";
import JetInput from "../Jetstream/Input";
import JetSecondaryButton from "../Jetstream/SecondaryButton";
import JetSectionBorder from "../Jetstream/SectionBorder";

export default {
    components: {
        AppLayout,
        AppTextarea,
        FormGroup,
        JetInput,
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetFormSection,
        JetSecondaryButton,
        JetSectionBorder
    },

    props: {
        product: {
            type: Object
        }
    },

    data() {
        return {
            form: null,
            destroyForm: this.$inertia.form(),
            showDelete: false
        };
    },

    watch: {
        product: {
            immediate: true,
            handler(product) {
                this.form = this.$inertia.form({
                    product_name: this.product.product_name,
                    description: this.product.description,
                    style: this.product.style,
                    brand: this.product.brand,
                    product_type: this.product.product_type
                });
            }
        }
    },

    methods: {
        /**
         * Save the form.
         */
        async save() {
            await this.form.put(`/products/${this.product.id}`, this.form);
        },

        /**
         * Delete the product.
         */
        async destroy(test) {
            await this.form.delete(`/products/${this.product.id}`);
        }
    }
};
</script>
