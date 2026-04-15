<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
   <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        :class="className"
        v-bind="$attrs"
        fill="currentColor"
    >
        <!-- shop bag -->
        <path d="M6 7V6a6 6 0 0 1 12 0v1h2a1 1 0 0 1 1 1v11a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8a1 1 0 0 1 1-1h2Zm2 0h8V6a4 4 0 0 0-8 0v1Z"/>
    </svg>
</template>
