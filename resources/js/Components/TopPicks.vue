<script setup>
import {formatRelative, parseISO} from "date-fns";
import Stars from "./Stars.vue";

const props = defineProps({
    reviews: {
        type: Object,
        required: true,
    },
});

const posts = [
    {
        id: 1,
        title: 'Boost your conversion rate',
        href: '#',
        description:
            'Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel iusto corrupti dicta laboris incididunt.',
        imageUrl:
            'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80',
        date: 'Mar 16, 2020',
        datetime: '2020-03-16',
        category: { title: 'Marketing', href: '#' },
        author: {
            name: 'Michael Foster',
            role: 'Co-Founder / CTO',
            href: '#',
            imageUrl:
                'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
    },
    // More posts...
]
</script>

<template>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-4xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">What We're Reading</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Need inspiration for your next read? Here's what we've enjoyed recently…</p>
                <div class="mt-16 space-y-20 lg:mt-20 lg:space-y-20">
                    <article v-for="review in props.reviews.data" :key="review.id" class="relative isolate flex gap-8 flex-row">
                        <div class="relative aspect-[16/9] w-64 shrink-0">
                            <img :src="review.reviewable.cover" alt="" class="absolute inset-0 h-full w-full rounded-2xl bg-gray-50 object-cover" />
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10" />
                        </div>
                        <div>
                            <div class="flex items-center gap-x-4 text-xs">
                                <time :datetime="review.created_at" class="text-gray-500 first-letter:uppercase">{{ formatRelative(parseISO(review.created_at), new Date()) }}</time>
                                <span class="relative z-10 rounded-full bg-emerald-900 px-3 py-1.5 font-medium text-gray-50">{{ review.reviewable.genre }}</span>
                            </div>
                            <div class="group relative max-w-xl">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900">
                                    <span>
                                        <span class="absolute inset-0" />
                                        {{ review.reviewable.title }} by {{ review.reviewable.author.name }}
                                    </span>
                                </h3>
                                <Stars :model-value="review.stars" readonly class="mt-2" />
                                <h3 class="mt-3 font-semibold leading-6 text-gray-600">
                                    <span>
                                        <span class="absolute inset-0" />
                                        {{ review.title }}
                                    </span>
                                </h3>
                                <p class="mt-3 text-sm leading-6 text-gray-600 line-clamp-6">{{ review.body }}</p>
                            </div>
                            <div class="mt-6 flex border-t border-gray-900/5 pt-6">
                                <div class="relative flex items-center gap-x-4">
                                    <div class="text-sm leading-6">
                                        <p class="font-semibold text-gray-900">
                                            <a href="#">
                                                <span class="absolute inset-0" />
                                                Review by {{ review.reviewer.name }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</template>
