<script setup lang="ts">
import Layout from "@/layouts/AdminLayout.vue";
import Card from "@/components/Card.vue";
import { ElButton, ElDialog, ElNotification } from "element-plus";
import {
    DxDataGrid,
    DxColumn,
    DxPaging,
    DxPager,
    DxToolbar,
    DxItem,
} from "devextreme-vue/data-grid";
import { DxButton } from "devextreme-vue/button";
import CustomStore from "devextreme/data/custom_store";
import { ref, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import route from "ziggy-js";
import type { FormInstance, FormRules } from "element-plus";
export type FormDataKelas = {
    id?: number;
    nama_kelas: string;
};
const dx = ref<DxDataGrid>();
const dialogVisible = ref<boolean>();
const formEl = ref<FormInstance>();
const ruleForm = reactive<FormRules<FormDataKelas>>({
    nama_kelas: {
        required: true,
        message: "Tolong isi nama kelas",
        trigger: "blur",
    },
});
const form = reactive<FormDataKelas>({
    id: null,
    nama_kelas: "",
});
function isNotEmpty(value) {
    return value !== undefined && value !== null && value !== "";
}
const props = defineProps<{ builder: string }>();
defineOptions({
    layout: Layout,
});
const store = new CustomStore({
    key: "id",
    load(loadOptions) {
        let params = "?";
        [
            "skip",
            "take",
            "requireTotalCount",
            "requireGroupCount",
            "sort",
            "filter",
            "totalSummary",
            "group",
            "groupSummary",
        ].forEach((i) => {
            if (i in loadOptions && isNotEmpty(loadOptions[i])) {
                params += `${i}=${JSON.stringify(loadOptions[i])}&`;
            }
        });
        params = params.slice(0, -1);
        return fetch(props.builder + params)
            .then((response) => response.json())
            .then((data) => ({
                data: data.data,
                totalCount: data.totalCount,
            }))
            .catch(() => {
                throw new Error("Data Loading Error");
            });
    },
});
function refreshDataGrid() {
    dx.value.instance.refresh();
}
async function submit() {
    if (!formEl) return;
    await formEl.value.validate((valid: boolean) => {
        if (valid) {
            router.post(
                form.id
                    ? route("kelas.update", { id: form.id })
                    : route("kelas.store"),
                form,
                {
                    onSuccess: (page) => {
                        ElNotification({
                            title: "Sukses",
                            message: page.props.flash.message,
                            type: "success",
                        });
                        refreshDataGrid();
                        formEl.value.resetFields();
                        dialogVisible.value = false;
                    },
                    onError: (err) =>
                        ElNotification({
                            title: "Error",
                            message: err.error,
                            type: "error",
                        }),
                }
            );
        }
    });
}
</script>
<template>
    <card header-title="Data Kelas">
        <DxDataGrid
            :data-source="store"
            :show-borders="true"
            :remote-operations="true"
            ref="dx"
        >
            <DxColumn data-field="nama_kelas" data-type="string" />
            <DxColumn
                data-field="id"
                data-type="number"
                caption="Aksi"
                cell-template="action"
            />
            <template #action="{ data }">
                <ElButton color="#626aef">Edit</ElButton>
                <ElButton type="danger">Hapus</ElButton>
            </template>
            <DxPaging :page-size="10" />
            <DxPager
                :show-page-size-selector="true"
                :allowed-page-sizes="[5, 10, 20]"
                :show-info="true"
                :show-navigation-buttons="true"
                :visible="true"
            />
            <DxToolbar>
                <DxItem location="before" template="addButton" />
                <DxItem location="after" template="refreshTemplate" />
            </DxToolbar>
            <template #addButton>
                <ElButton type="primary" @click="() => (dialogVisible = true)"
                    ><awesome icon="fa-solid fa-plus" />&nbsp;Tambah</ElButton
                >
            </template>
            <template #refreshTemplate>
                <DxButton icon="refresh" @click="refreshDataGrid" />
            </template>
        </DxDataGrid>
    </card>
    <el-dialog v-model="dialogVisible" title="Form Data Kelas">
        <el-form
            label-position="top"
            label-width="100px"
            :model="form"
            ref="formEl"
            :rules="ruleForm"
        >
            <el-form-item label="Nama Kelas" prop="nama_kelas">
                <el-input v-model="form.nama_kelas" />
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="submit"> Simpan </el-button>
            </span>
        </template>
    </el-dialog>
</template>
