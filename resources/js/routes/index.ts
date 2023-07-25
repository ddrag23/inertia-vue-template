import route from "ziggy-js";
type MenuRoutes = {
    title: string;
    route: string;
    icon: string;
    current: string;
};

const routes: MenuRoutes[] = [
    {
        title: "Dashboard",
        route: route("home"),
        icon: "fa-solid fa-gauge",
        current: "/",
    },
    {
        title: "Kelas",
        route: route("kelas.index"),
        icon: "fa-solid fa-warehouse",
        current: "/kelas",
    },
    {
        title: "User",
        route: route("user.index"),
        icon: "fa-solid fa-users",
        current: "/user",
    },
];
export default routes;
