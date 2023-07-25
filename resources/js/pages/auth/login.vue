<script setup lang="ts">
import Card from "@/components/Card.vue";
import { reactive } from "vue";
import {
    ElInput,
    ElForm,
    ElFormItem,
    ElButton,
    ElNotification,
} from "element-plus";
import { router } from "@inertiajs/vue3";
import route from "ziggy-js";

defineProps<{ errors: Object }>();
const formData = reactive({
    email: "",
    password: "",
});
function submit() {
    router.post(route("auth.login.post"), formData, {
        onError: (err) =>
            ElNotification({
                title: "Error",
                message: err.error,
                type: "error",
            }),
    });
}
router.on("error", (err) => console.error(err));
</script>
<template>
    <div class="flex justify-center items-center w-full h-screen bg-gray-400">
        <Card :is-header="false" class="md:w-[26em] mx-5">
            <p class="text-xl">Welcome To MyAdmin</p>
            <hr class="my-3" />
            <el-form
                label-position="top"
                label-width="100px"
                :model="formData"
                style="max-width: 460px"
            >
                <el-form-item label="Email">
                    <el-input
                        v-model="formData.email"
                        placeholder="Ex : jon@mail.com"
                        size="large"
                    />
                </el-form-item>
                <el-form-item label="Password">
                    <el-input
                        v-model="formData.password"
                        size="large"
                        type="password"
                        show-password
                    />
                </el-form-item>
                <el-form-item>
                    <el-button
                        @click="submit"
                        type="primary"
                        class="w-full"
                        size="large"
                        >Login</el-button
                    >
                </el-form-item>
            </el-form>
        </Card>
    </div>
</template>
