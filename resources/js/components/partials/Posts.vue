<template>
    <div>
        <Spinner v-if="isLoading == true" />

        <div v-if="posts.length">
            <div class="d-flex flex-wrap mt-5 justify-content-between">
                <div
                    class="card mb-5"
                    style="width: 18rem"
                    v-for="post in posts"
                >
                    <img
                        v-if="post.image"
                        class="card-img-top"
                        :src="post.image"
                        :alt="`${post.title} image`"
                        width="286"
                    />
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            {{ post.title }}
                        </h5>
                        <p class="card-text">
                            {{ post.content }}
                        </p>
                        <a
                            :href="`/user/posts/${post.id}`"
                            class="btn btn-primary"
                            >Vai al post</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from "axios";
import Spinner from "../Spinner.vue";

export default {
    name: "Posts",
    components: { Spinner },
    props: {},
    data() {
        return {
            posts: [],
            isLoading: true,
        };
    },
    methods: {
        getPosts() {
            Axios.get("http://127.0.0.1:8000/api/posts")
                .then((res) => {
                    this.posts = res.data.posts;
                })
                .then(() => {
                    this.isLoading = false;
                });
        },
    },

    mounted() {
        this.getPosts();
    },
};
</script>

<style scoped lang="scss"></style>
