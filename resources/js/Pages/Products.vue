<template>
    <app-layout>
        <template #header>
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 border-b">
                        <div>
                            <span class="text-xl">Products</span>
                            <inertia-link href="/products/create">
                                <jet-secondary-button
                                    class="float-right"
                                    type="button"
                                    >Create Product</jet-secondary-button
                                >
                            </inertia-link>
                        </div>
                        <div class="text-sm">
                            Below is a list of all products associated to your
                            account.
                        </div>
                    </div>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="w-1/4 text-left p-4">Name</th>
                                <th class="w-1/4 text-left p-4">Style</th>
                                <th class="w-1/4 text-left p-4">Brand</th>
                                <th class="w-1/4 text-left p-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b"
                                v-for="product in products.data"
                                :key="product.id"
                            >
                                <td class="p-4 truncate" :title="product.name">
                                    {{ product.name }}
                                </td>
                                <td class="p-4 truncate" :title="product.style">
                                    {{ product.style }}
                                </td>
                                <td class="p-4 truncate" :title="product.brand">
                                    {{ product.brand }}
                                </td>
                                <td>
                                    <inertia-link
                                        :href="`/products/${product.id}`"
                                        ><jet-secondary-button type="button"
                                            >Edit</jet-secondary-button
                                        ></inertia-link
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="px-4 py-4">
                        <pager :pager="products" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButton from "../Jetstream/Button";
import JetSecondaryButton from "../Jetstream/SecondaryButton";
import JetDangerButton from "../Jetstream/DangerButton";

import AppLayout from "./../Layouts/AppLayout";
import Pager from "./../Components/Pager";

export default {
    components: {
        AppLayout,
        JetButton,
        JetDangerButton,
        JetSecondaryButton,
        Pager
    },
    props: {
        products: {
            type: Object
        }
    }
};
</script>
