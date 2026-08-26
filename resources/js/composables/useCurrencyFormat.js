export function useCurrencyFormat(value) {
    if (value === null || value === undefined || value === "") {
        return "0.00";
    }

    return Number(value).toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}
