<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <Posts />
            </div>
        </div>
    </div>
</template>

<script>
import Posts from "./partials/Posts.vue";
export default {
    name: "App",
    components: { Posts },
};
</script>
