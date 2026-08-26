<template>
    <div class="row">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div>
            <h1>Supplier/Exhibitor Dashboard</h1>
        </div>
    </div>
</template>
