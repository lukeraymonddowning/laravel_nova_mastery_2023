<script setup>
import Header from "../Components/Header.vue";
import About from "../Components/About.vue";
import Footer from "../Components/Footer.vue";
import TopPicks from "../Components/TopPicks.vue";
import Location from "../Components/Location.vue";

const props = defineProps({
    reviews: {
        type: Object,
        required: true
    },
});
</script>

<template>
    <Header/>
    <About />
    <TopPicks v-if="props.reviews.data.length > 0" :reviews="props.reviews" />
    <Location />
    <Footer />
</template>
