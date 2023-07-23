<script setup lang="ts">
import Card from "@/components/Card.vue";
import { reactive } from "vue";
import { ElInput, ElForm, ElFormItem } from "element-plus";
const formData = reactive({
    email: "",
    password: "",
});
</script>
<template>
    <div class="flex justify-center items-center w-full h-screen bg-gray-400">
        <Card :is-header="false" class="w-[26rem]">
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
                    <el-button type="primary" class="w-full" size="large"
                        >Login</el-button
                    >
                </el-form-item>
            </el-form>
        </Card>
    </div>
</template>
