<template>
  <div>
    <Head title="Nyt Bestsellers" />

    <Heading class="mb-6">New York Times Bestsellers</Heading>

    <Card
        v-for="category in data.items"
        class="mb-6 px-2 md:px-4 py-2"
    >
        <h2 class="text-xl font-bold mb-6">{{ category.display_name }}</h2>

        <ul class="flex space-x-4">
            <li v-for="book in category.books">
                <img :src="book.book_image" alt="" class="w-32 aspect-[1/1.5]">
                <h3 class="mt-2 font-bold truncate w-32">{{ book.title }}</h3>
                <span class="block w-32 truncate">{{ book.author }}</span>
                <div class="mt-2">
                    <DefaultButton component="a" :href="book.buy_links[0]?.url">Buy</DefaultButton>
                </div>
            </li>
        </ul>
    </Card>
  </div>
</template>

<script setup>
import {onMounted, reactive} from "vue";

const data = reactive({
    items: [],
});

onMounted(() => {
    Nova.request().get('/nova-vendor/nyt-bestsellers/')
        .then(response => {
            data.items = response.data;
        });
});
</script>

<style>
/* Scoped Styles */
</style>
