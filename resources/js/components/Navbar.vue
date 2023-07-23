<script setup lang="ts">
import { ref } from "vue";
import { vOnClickOutside } from "@vueuse/components";
import { useToggle } from "@vueuse/core";
import route from "ziggy-js";
const avatarDropdown = ref<boolean>();
function toggleAvatar(): void {
    avatarDropdown.value = !avatarDropdown.value;
    console.log(avatarDropdown.value);
}

function closeAvatar() {
    avatarDropdown.value = false;
}
const [value, toggle] = useToggle();
</script>
<template>
    <div class="w-full py-5 px-6">
        <div class="flex w-full justify-between items-center">
            <button @click="$emit('toggleSidebar', toggle())">
                <awesome icon="fa-solid fa-bars" />
            </button>
            <div
                class="flex items-center gap-2 cursor-pointer"
                @click="toggleAvatar"
            >
                <img
                    class="w-10 h-10 rounded-full"
                    src="https://w7.pngwing.com/pngs/223/244/png-transparent-computer-icons-avatar-user-profile-avatar-heroes-rectangle-black.png"
                    alt="Rounded avatar"
                />
                <p>Hallo, Admin</p>
            </div>
        </div>
        <!-- Dropdown menu -->
        <div
            v-if="avatarDropdown"
            v-on-click-outside="closeAvatar"
            class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48"
        >
            <div
                class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800"
            >
                <Link
                    class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    href="#"
                >
                    <span class="mr-1">
                        <awesome icon="fa-solid fa-user" />
                    </span>
                    Profile
                </Link>
                <Link
                    class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    :href="route('auth.logout')"
                >
                    <span class="mr-1">
                        <awesome icon="fa-solid fa-right-from-bracket" />
                    </span>
                    Logout
                </Link>
            </div>
        </div>
    </div>
</template>
