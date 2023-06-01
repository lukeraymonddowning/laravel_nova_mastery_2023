<script setup>
const features = [
    {
        name: 'A Relaxed Layout',
        description:
            'It all starts with our open book-shelf, designed to encourage exploration and discovery. We\'re careful not to overoptimize the layout of our library so you can enjoy the thrill of the hunt and stumble across treasures, both classic and modern.',
        imageSrc: '/images/Pic 1.png',
        imageAlt: 'Open bookshelf with modern books on the bottom and classic books on the top.',
    },
    {
        name: 'Quiet Chatter',
        description:
            'There\'s nothing worse than a librarian shushing you for talking too loud. We encourage quiet chatter and discussion about books, authors and anything else you can think of. We\'re all about creating a community of book lovers. We also make some of the best coffee and cake in town; the perfect compliment to the perfect read.',
        imageSrc: '/images/Pic 2.png',
        imageAlt: 'A group of people sitting around a table talking and laughing.',
    },
    {
        name: 'When You\'re Done, Check it Out',
        description:
            'Of course, eventually you have to go back to the real world. However, with our simple subscription, you can check out as many books as you\'d like and take them home to carry on the adventure. Read. Rinse. Repeat.',
        imageSrc: '/images/Pic 5.png',
        imageAlt: 'A group of people sitting around a table talking and laughing.',
    },
]
</script>

<template>
    <div id="about" class="bg-white">
        <div class="mx-auto max-w-7xl py-24 sm:px-2 sm:py-32 lg:px-4">
            <div class="mx-auto max-w-2xl px-4 lg:max-w-none">
                <div class="max-w-3xl">
                    <h2 class="font-semibold text-gray-500">A Place to Call Home</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">About Us</p>
                    <p class="mt-4 text-gray-500">Established in 2019, our aim is to bring joy back to getting lost in a book. Libraries are cold, unattractive and strict. On the other hand, we work hard to create a cozy, warm atmosphere where you can enjoy those Sunday morning vibes any day of the week.</p>
                </div>

                <div class="mt-10 space-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16">
                    <div v-for="feature in features" :key="feature.name" class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:items-center lg:gap-x-8">
                        <div class="mt-6 lg:col-span-5 lg:mt-0 xl:col-span-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ feature.name }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ feature.description }}</p>
                        </div>
                        <div class="flex-auto lg:col-span-7 xl:col-span-8">
                            <div class="aspect-h-2 aspect-w-5 overflow-hidden rounded-lg bg-gray-100">
                                <img :src="feature.imageSrc" :alt="feature.imageAlt" class="object-cover object-center" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
