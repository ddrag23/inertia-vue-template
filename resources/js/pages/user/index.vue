<script setup lang="ts">
import Layout from "@/layouts/AdminLayout.vue";
import Card from "@/components/Card.vue";
import {
    DxDataGrid,
    DxColumn,
    DxPaging,
    DxPager,
} from "devextreme-vue/data-grid";
import CustomStore from "devextreme/data/custom_store";

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
</script>
<template>
    <card header-title="User Management">
        <DxDataGrid
            :data-source="store"
            :show-borders="true"
            :remote-operations="true"
        >
            <DxColumn data-field="name" data-type="string" />
            <DxColumn data-field="email" data-type="string" />
            <DxColumn />
            <DxPaging :page-size="10" />
            <DxPager
                :show-page-size-selector="true"
                :allowed-page-sizes="[5, 10, 20]"
                :show-info="true"
                :show-navigation-buttons="true"
                :visible="true"
            />
        </DxDataGrid>
    </card>
</template>
