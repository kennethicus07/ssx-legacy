export default function useNumericInput() {
    const onlyNumeric = (value) => {
        if (value === null || value === undefined) return "";
        return String(value).replace(/[^0-9.]/g, "");
    };

    const bindNumeric = (obj, key) => {
        return {
            get: () => obj[key],
            set: (val) => {
                obj[key] = onlyNumeric(val);
            },
        };
    };

    return {
        onlyNumeric,
        bindNumeric,
    };
}
