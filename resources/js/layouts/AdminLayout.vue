<script setup lang="ts">
import Sidebar from "@/components/Sidebar.vue";
import Navbar from "@/components/Navbar.vue";
import { ref } from "vue";
const isSidebar = ref<boolean>(true);
function toggleSidebar(value: boolean) {
    isSidebar.value = value;
}
function closeSidebar(value: boolean) {
    isSidebar.value = value;
}
</script>
<template>
    <div class="flex w-full">
        <Sidebar
            class="md:block"
            :class="{ hidden: !isSidebar }"
            v-show="isSidebar"
            @closeSidebar="closeSidebar"
        />
        <div class="w-full">
            <Navbar @toggleSidebar="toggleSidebar" />
            <div class="px-5 md:px-8 pt-5 w-full bg-[#B5C2CA] h-screen">
                <slot />
            </div>
        </div>
    </div>
</template>
