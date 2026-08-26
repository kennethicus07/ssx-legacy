export default function useNumberFormat() {
    function format(value) {
        if (value === null || value === undefined || value === "") return "";

        let str = String(value).replace(/,/g, "");

        if (isNaN(str)) return "";

        let [intPart, decimalPart] = str.split(".");

        intPart = Number(intPart).toLocaleString();

        if (decimalPart !== undefined) {
            return `${intPart}.${decimalPart}`;
        }

        return intPart;
    }

    function unformat(value) {
        if (!value) return "";
        return String(value).replace(/,/g, "");
    }

    function onlyNumberWithFormat(value) {
        return format(unformat(value));
    }

    return {
        format,
        unformat,
        onlyNumberWithFormat,
    };
}
