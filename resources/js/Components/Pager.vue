<template>
    <div>
        <div class="mb-4 text-center">
            Showing {{ pager.data.length }} of {{ pager.meta.total }} result{{
                pager.total !== 1 ? "s" : ""
            }}.
        </div>
        <ul
            class="flex justify-center"
            v-if="pager.meta.total > pager.meta.per_page"
        >
            <li
                class="mr-3 inline-block"
                v-for="(link, index) in pager.meta.links"
                :key="index"
            >
                <inertia-link
                    v-if="link.label !== '...'"
                    preserve-scroll
                    :href="link.url ? link.url : '#'"
                    :class="{
                        'opacity-50 pointer-events-none':
                            !link.url || pager.meta.current_page == link.label
                    }"
                    ><jet-button type="button">{{
                        link.label
                    }}</jet-button></inertia-link
                >
                <div v-else>
                    ...
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import JetButton from "../Jetstream/Button";

export default {
    components: {
        JetButton
    },
    props: {
        pager: {
            type: Object,
            required: true
        }
    }
};
</script>
