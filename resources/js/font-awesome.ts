import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faUserSecret,
    faFireFlameCurved,
    faGauge,
    faUsers,
    faUser,
    faRightFromBracket,
    faBars,
    faCircleXmark,
    faWarehouse,
    faPlus,
} from "@fortawesome/free-solid-svg-icons";

export default () => {
    /* import specific icons */

    /* add icons to the library */
    library.add(
        faUserSecret,
        faFireFlameCurved,
        faGauge,
        faUsers,
        faUser,
        faRightFromBracket,
        faBars,
        faCircleXmark,
        faWarehouse,
        faPlus
    );
};
