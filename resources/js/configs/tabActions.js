export const tabActions = {
    company_info: {
        1: ["update", "view", "approve", "admin"],
        5: ["update", "supplier"],
    },
    product_info: {
        1: ["update", "approve", "export", "admin"],
        5: ["supplier"],
    },
    contact_info: {
        1: ["update", "admin"],
        5: ["update", "supplier"],
    },
    business_info: {
        1: ["update", "approve", "admin"],
        5: ["update", "supplier"],
    },
    order_info: {
        1: ["update", "view", "approve", "admin"],
        5: ["supplier"],
    },
    docs_requirements: {
        1: ["update", "export", "admin"],
        5: ["update", "supplier"],
    },
};

export function can(tab, userGroup, action) {
    if (tabActions && tabActions[tab] && tabActions[tab][userGroup]) {
        return tabActions[tab][userGroup].includes(action);
    }
    return false;
}
