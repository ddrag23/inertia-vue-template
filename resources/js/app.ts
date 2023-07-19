import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import ElementPlus from "element-plus";
import { Link } from "@inertiajs/vue3";
import "element-plus/dist/index.css";
import "./bootstrap";
import fontAwesome from "./font-awesome";
import ziggy from "ziggy-js";
import "devextreme/dist/css/dx.light.css";
/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
createInertiaApp({
    resolve: (name: string): any => {
        const pages = import.meta.glob("./pages/**/*.vue", { eager: true });
        return pages[`./pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ElementPlus)
            .use(fontAwesome)
            .component("awesome", FontAwesomeIcon)
            .component("Link", Link)
            .provide("route", ziggy)
            .mount(el);
    },
});
