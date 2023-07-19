<script setup lang="ts">
import MenuItem from "./MenuItem.vue";
import route from "ziggy-js";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import menuRoutes from "@/routes";
const curr = ref<string>();
router.on("navigate", (e: any) => {
    curr.value = e.detail.page.url;
});
</script>
<template>
    <div
        class="absolute md:static w-2/3 md:w-1/4 bg-white h-screen p-5 border-r"
    >
        <div class="flex justify-between">
            <h1 class="text-2xl">
                <awesome
                    icon="fa-solid fa-fire-flame-curved"
                    class="text-blue-500"
                />
                Willow
            </h1>
            <button
                class="text-xl md:hidden"
                @click="$emit('closeSidebar', false)"
            >
                <awesome icon="fa-solid fa-circle-xmark" />
            </button>
        </div>
        <div class="mb-10"></div>
        <div class="flex flex-col gap-2">
            <template v-for="{ title, icon, route, current } in menuRoutes">
                <MenuItem
                    :route="route"
                    :title="title"
                    :icon="icon"
                    :is-active="curr == current"
                />
            </template>
        </div>
    </div>
</template>
