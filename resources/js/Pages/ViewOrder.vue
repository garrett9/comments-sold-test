<template>
    <app-layout>
        <template #header>
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link class="text-blue-500" href="/orders"
                    >Orders</inertia-link
                >
                / {{ order.id }}
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section>
                    <template #title>Order Details</template>
                    <template #description
                        >Basic details associated to the order.</template
                    >
                    <template #form>
                        <form-group label="Order ID">
                            <jet-read-only-input name="id" :value="order.id" />
                        </form-group>

                        <form-group class="mt-4" label="Customer Name">
                            <jet-read-only-input
                                name="name"
                                :value="order.name"
                            />
                        </form-group>

                        <form-group class="mt-4" label="Customer Email">
                            <jet-read-only-input
                                name="email"
                                :value="order.email"
                            />
                        </form-group>

                        <form-group class="mt-4" label="Status">
                            <jet-read-only-input
                                name="order_status"
                                :value="order.order_status"
                            />
                        </form-group>

                        <form-group class="mt-4" label="Total">
                            <jet-read-only-input
                                name="total"
                                :value="`$${order.total_cents / 100}`"
                            />
                        </form-group>

                        <form-group
                            class="mt-4"
                            v-if="order.transaction_id"
                            label="Transaction ID"
                        >
                            <jet-read-only-input
                                name="transaction_id"
                                :value="order.transaction_id"
                            />
                        </form-group>

                        <form-group class="mt-4" label="Shipper">
                            <jet-read-only-input
                                name="shipper_name"
                                :value="order.shipper_name"
                            />
                        </form-group>

                        <form-group class="mt-4" label="Tracking Number">
                            <jet-read-only-input
                                name="tracking_number"
                                :value="order.tracking_number"
                            />
                        </form-group>
                    </template>
                </jet-form-section>

                <jet-section-border />

                <jet-form-section>
                    <template #title>Product Details</template>
                    <template #description
                        >Basic details for the order's associated
                        product.</template
                    >
                    <template #form>
                        <form-group label="Name">
                            <jet-read-only-input
                                name="product_name"
                                :value="order.product.product_name"
                            />
                        </form-group>
                        <form-group class="mt-4" label="Type">
                            <jet-read-only-input
                                name="product_type"
                                :value="order.product.product_type"
                            />
                        </form-group>
                    </template>
                </jet-form-section>

                <jet-section-border />

                <jet-form-section>
                    <template #title>Inventory Details</template>
                    <template #description
                        >Basic details for the order's associated inventory
                        record.</template
                    >
                    <template #form>
                        <form-group label="Color">
                            <jet-read-only-input
                                name="color"
                                :value="order.inventory.color"
                            />
                        </form-group>
                        <form-group class="mt-4" label="Size">
                            <jet-read-only-input
                                name="size"
                                :value="order.inventory.size"
                            />
                        </form-group>
                        <form-group class="mt-4" label="SKU">
                            <jet-read-only-input
                                name="sku"
                                :value="order.inventory.sku"
                            />
                        </form-group>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import FormGroup from "../Components/FormGroup";
import JetButton from "../Jetstream/Button";
import JetFormSection from "../Jetstream/FormSection";
import JetInput from "../Jetstream/Input";
import JetReadOnlyInput from "../Jetstream/ReadOnlyInput";
import JetSectionBorder from "../Jetstream/SectionBorder";

export default {
    components: {
        AppLayout,
        FormGroup,
        JetInput,
        JetButton,
        JetFormSection,
        JetReadOnlyInput,
        JetSectionBorder
    },

    props: {
        order: {
            type: Object
        }
    }
};
</script>
