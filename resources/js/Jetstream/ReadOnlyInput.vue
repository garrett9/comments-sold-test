<template>
    <input
        type="text"
        class="form-input p-0 border-0 w-full"
        disabled
        :value="value"
    />
</template>

<script>
export default {
    props: ["value"]
};
</script>
