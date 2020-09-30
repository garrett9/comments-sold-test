<template>
    <app-layout>
        <template #header>
            <div class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="mb-8 bg-white overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div class="text-xl p-4 pb-0">
                        {{ hasFilters ? "Filtered " : "" }}Order Statuses
                    </div>
                    <div class="flex">
                        <div class="w-1/5 p-4 mr-4">
                            <div class="text-xl">Open</div>
                            <div class="text-2xl" dusk="totalOpen">
                                {{ totalOpen }}
                            </div>
                        </div>
                        <div class="w-1/5 p-4 mr-4">
                            <div class="text-xl">Paid</div>
                            <div class="text-2xl" dusk="totalPaid">
                                {{ totalPaid }}
                            </div>
                        </div>
                        <div class="w-1/5 p-4 mr-4">
                            <div class="text-xl">Pending</div>
                            <div class="text-2xl" dusk="totalPending">
                                {{ totalPending }}
                            </div>
                        </div>
                        <div class="w-1/5 p-4 mr-4">
                            <div class="text-xl">Fulfilled</div>
                            <div class="text-2xl" dusk="totalFulfilled">
                                {{ totalFulfilled }}
                            </div>
                        </div>
                        <div class="w-1/5 p-4 mr-4">
                            <div class="text-xl">Shipped</div>
                            <div class="text-2xl" dusk="totalShipped">
                                {{ totalShipped }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex mb-8">
                    <div
                        class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mr-4"
                    >
                        <div class="text-xl">
                            Total {{ hasFilters ? "Filtered " : "" }}Orders
                        </div>
                        <div class="text-2xl text-green-600" dusk="totalOrders">
                            {{ orders.meta.total }}
                        </div>
                    </div>
                    <div
                        class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mr-4"
                    >
                        <div class="text-xl">
                            Total {{ hasFilters ? "Filtered " : "" }}Revenue
                        </div>
                        <div
                            class="text-2xl text-green-600"
                            dusk="totalRevenue"
                        >
                            {{ total }}
                        </div>
                    </div>
                    <div
                        class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"
                    >
                        <div class="text-xl">
                            Average {{ hasFilters ? "Filtered " : "" }}Price of
                            Order
                        </div>
                        <div class="text-2xl text-green-600" dusk="orderAvg">
                            {{ avg }}
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 border-b">
                        <div>
                            <span class="text-xl">Orders</span>
                        </div>
                        <div class="text-sm">
                            Below is a list of all the orders for your products.
                        </div>
                        <form
                            @submit.prevent="applyFilters()"
                            class="mt-4 flex"
                        >
                            <form-group class="mr-2 w-1/3">
                                <jet-input
                                    v-model="filters.product_name"
                                    placeholder="Product Name"
                                ></jet-input>
                            </form-group>
                            <form-group class="mr-2 w-1/3">
                                <jet-input
                                    v-model="filters.sku"
                                    placeholder="SKU"
                                ></jet-input>
                            </form-group>
                            <div class="w-1/3">
                                <jet-button class="mt-2 py-3"
                                    >Apply Filters</jet-button
                                >
                            </div>
                        </form>
                    </div>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="w-1/4 text-left p-4">
                                    Customer Name
                                </th>
                                <th class="w-1/4 text-left p-4">
                                    Custom Email
                                </th>
                                <th class="w-1/8 text-left p-4">
                                    Product Name
                                </th>
                                <th class="w-1/16 text-left p-4">SKU</th>
                                <th class="w-1/8 text-left p-4">
                                    Order Status
                                </th>
                                <th class="w-1/8 text-right p-4">
                                    Order Total
                                </th>
                                <th class="w-1/18"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="order in orders.data"
                                :key="order.id"
                                class="border-b"
                            >
                                <td class="p-4 truncate" :title="order.name">
                                    {{ order.name }}
                                </td>
                                <td class="p-4 truncate" :title="order.email">
                                    {{ order.email }}
                                </td>
                                <td
                                    class="p-4 truncate"
                                    :title="order.product_name"
                                >
                                    {{ order.product_name }}
                                </td>
                                <td class="p-4 truncate" :title="order.sku">
                                    {{ order.sku }}
                                </td>
                                <td class="p-4 truncate" :title="order.status">
                                    {{ order.order_status }}
                                </td>
                                <td
                                    class="p-4 truncate text-right"
                                    :title="order.total"
                                >
                                    {{ order.total }}
                                </td>
                                <td class="p-4 text-center">
                                    <inertia-link :href="`/orders/${order.id}`"
                                        ><jet-secondary-button
                                            >View</jet-secondary-button
                                        ></inertia-link
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="px-4 py-4">
                        <pager :pager="orders" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import FormGroup from "../Components/FormGroup";
import JetButton from "../Jetstream/Button";
import JetDangerButton from "../Jetstream/DangerButton";
import JetInput from "../Jetstream/Input";
import JetSecondaryButton from "../Jetstream/SecondaryButton";

import AppLayout from "./../Layouts/AppLayout";
import Pager from "./../Components/Pager";

export default {
    components: {
        AppLayout,
        FormGroup,
        JetButton,
        JetDangerButton,
        JetInput,
        JetSecondaryButton,
        Pager
    },
    props: {
        orders: {
            type: Object
        },
        avg: {
            type: String
        },
        total: {
            type: String
        },
        totalOpen: {
            type: Number
        },
        totalPaid: {
            type: Number
        },
        totalFulfilled: {
            type: Number
        },
        totalPending: {
            type: Number
        },
        totalShipped: {
            type: Number
        }
    },
    data() {
        var search = location.search.substring(1);
        const filters = search
            ? JSON.parse(
                  '{"' +
                      decodeURIComponent(search)
                          .replace(/"/g, '\\"')
                          .replace(/&/g, '","')
                          .replace(/=/g, '":"')
                          .replace("+", " ") +
                      '"}'
              )
            : {};
        return {
            filters,
            hasFilters: filters.product_name || filters.sku
        };
    },
    methods: {
        /**
         * Apply the filters
         */
        applyFilters() {
            this.$inertia.visit("/orders", {
                data: this.filters,
                preserveScroll: true
            });
        }
    }
};
</script>
