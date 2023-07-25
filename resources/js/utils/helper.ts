export function resetForm<T>(form: T) {
    Object.keys(form).forEach((item) => {
        switch (form[item]) {
            case typeof Boolean:
                form[item] = false;
                break;
            case typeof String:
                form[item] = "";
                break;
            default:
            case typeof null:
                form[item] = null;
                break;
        }
    });
}
