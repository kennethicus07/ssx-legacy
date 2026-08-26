export default function useEventDateRestriction() {
    const allowedDates = ["2026-05-21", "2026-05-22", "2026-05-23"];

    const isAllowedDate = (date) => {
        return allowedDates.includes(date);
    };

    const getMinDate = () => {
        return allowedDates[0];
    };

    const getMaxDate = () => {
        return allowedDates[allowedDates.length - 1];
    };

    return {
        allowedDates,
        isAllowedDate,
        getMinDate,
        getMaxDate,
    };
}
