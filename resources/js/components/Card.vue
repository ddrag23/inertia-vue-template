<script setup lang="ts">
import { ElButton } from "element-plus";
type CardProps = {
    headerTitle?: string;
    isHeader?: boolean;
    isToolbar?: boolean;
    class?: string;
};
const props = withDefaults(defineProps<CardProps>(), {
    headerTitle: "Card Title",
    isHeader: true,
    isToolbar: false,
    class: "",
});
</script>
<template>
    <div class="bg-white shadow-black rounded-lg w-full" :class="class">
        <div
            class="flex justify-between w-full items-center px-5 h-12"
            v-if="props.isHeader"
        >
            <h1 class="text-lg">{{ props.headerTitle }}</h1>
            <div class="flex gap-3" v-if="isToolbar">
                <el-button type="primary">Default</el-button>
                <slot name="toolbar" />
            </div>
        </div>
        <hr />
        <div class="p-5 overflow-x-scroll">
            <slot />
        </div>
    </div>
</template>
