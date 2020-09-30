<template>
    <div>
        <jet-label v-if="label" :value="label" />
        <div class="mt-2 block w-3/4">
            <slot></slot>
        </div>
        <div v-for="(error, i) in errors" :key="i">
            <jet-input-error :message="error" class="mt-2" />
        </div>
    </div>
</template>

<script>
import JetLabel from "../Jetstream/Label";
import JetInputError from "../Jetstream/InputError";

export default {
    components: {
        JetLabel,
        JetInputError
    },
    props: {
        label: {
            type: String
        },
        errors: {
            type: Array,
            default: () => []
        }
    }
};
</script>
