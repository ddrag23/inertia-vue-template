<script setup lang="ts">
import Layout from "@/layouts/AdminLayout.vue";
import Card from "@/components/Card.vue";
import {
    ElButton,
    ElDialog,
    ElNotification,
    ElMessage,
    ElMessageBox,
    ElSwitch,
} from "element-plus";
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
import { resetForm } from "@/utils/helper";
export type FormDataTahunAjaran = {
    id?: number;
    tahun_ajaran: string;
    is_aktif: boolean;
};
const dx = ref<DxDataGrid>();
const dialogVisible = ref<boolean>();
const formEl = ref<FormInstance>();
const ruleForm = reactive<FormRules<FormDataTahunAjaran>>({
    tahun_ajaran: {
        required: true,
        message: "Tolong isi tahun ajaran",
        trigger: "blur",
    },
});
const form = reactive<FormDataTahunAjaran>({
    id: null,
    tahun_ajaran: "",
    is_aktif: false,
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
function showDialog() {
    resetForm<FormDataTahunAjaran>(form);
    dialogVisible.value = true;
}
function editData(data: FormDataTahunAjaran) {
    console.log(data);
    form.id = data.id;
    form.tahun_ajaran = data.tahun_ajaran;
    form.is_aktif = data.is_aktif ? true : false;
    dialogVisible.value = true;
}

function deleteData(id: number) {
    ElMessageBox.confirm(
        "Apakah anda yakin menghapus data ini. Lanjutkan?",
        "Warning",
        {
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            type: "warning",
        }
    )
        .then(() => {
            router.delete(route("tahun-ajaran.delete", { id }), {
                onSuccess: (page: any) => {
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
            });
        })
        .catch(() => {
            ElMessage({
                type: "info",
                message: "Delete canceled",
            });
        });
}
async function submit() {
    if (!formEl) return;
    await formEl.value.validate((valid: boolean) => {
        if (valid) {
            const options = {
                onSuccess: (page: any) => {
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
            };
            if (form.id) {
                router.put(
                    route("tahun-ajaran.update", { id: form.id }),
                    form,
                    options
                );
            } else {
                router.post(route("tahun-ajaran.store"), form, options);
            }
        }
    });
}
</script>
<template>
    <card header-title="Data Kelas">
        <div class="w-screen md:w-full">
            <DxDataGrid
                :data-source="store"
                :show-borders="true"
                :remote-operations="true"
                ref="dx"
            >
                <DxColumn data-field="tahun_ajaran" data-type="string" />
                <DxColumn data-field="is_aktif" data-type="boolean" />
                <DxColumn
                    data-field="id"
                    data-type="number"
                    caption="Aksi"
                    cell-template="action"
                />
                <template #action="{ data }">
                    <ElButton
                        color="#626aef"
                        size="small"
                        @click="editData(data.data)"
                    >
                        <span class="mr-1"
                            ><awesome icon="fa-solid fa-edit"
                        /></span>
                        Edit
                    </ElButton>
                    <ElButton
                        type="danger"
                        size="small"
                        @click="deleteData(data.data.id)"
                    >
                        <span class="mr-1"
                            ><awesome icon="fa-solid fa-trash"
                        /></span>
                        Hapus
                    </ElButton>
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
                    <ElButton type="primary" @click="showDialog"
                        ><awesome
                            icon="fa-solid fa-plus"
                        />&nbsp;Tambah</ElButton
                    >
                </template>
                <template #refreshTemplate>
                    <DxButton icon="refresh" @click="refreshDataGrid" />
                </template>
            </DxDataGrid>
        </div>
    </card>
    <el-dialog v-model="dialogVisible" title="Form Data Tahun Ajaran">
        <el-form
            label-position="top"
            label-width="100px"
            :model="form"
            ref="formEl"
            :rules="ruleForm"
        >
            <el-form-item label="Tahun Ajaran" prop="tahun_ajaran">
                <el-input
                    v-model="form.tahun_ajaran"
                    placeholder="ex: 2022/2023"
                />
            </el-form-item>
            <el-form-item label="Is Aktif" prop="is_aktif">
                <el-switch
                    v-model="form.is_aktif"
                    active-text="Aktif"
                    inactive-text="Non-Aktif"
                />
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
