<template>
    <footer class="text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3">
        © 2021:
        <span>Vilius Grimalauskas IFF-8/4</span>
    </div>
    <!-- Copyright -->
    </footer>
</template>

<script>
    export default {
        name: 'Footer'
    };
</script>

<style scoped>
    footer {
        position:absolute;
        bottom:0;
        width:100%;
        height:60px;   /* Height of the footer */
        background-color: var(--color-4);
        color: var(--color-0);
    }
</style>