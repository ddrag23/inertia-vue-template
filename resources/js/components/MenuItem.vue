<script setup lang="ts">
export type PropsMenuItem = {
    title: string;
    route: string;
    icon: string;
    isActive: boolean;
};
const props = defineProps<PropsMenuItem>();
</script>
<template>
    <Link class="w-full" :href="props.route">
        <div
            class="w-full p-2"
            :class="
                props.isActive
                    ? 'text-white bg-blue-500 rounded-lg'
                    : 'text-[#B4B8C8]'
            "
        >
            <span><awesome :icon="props.icon" /></span>
            {{ props.title }}
        </div>
    </Link>
</template>
