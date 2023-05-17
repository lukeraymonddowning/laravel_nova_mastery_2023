<template>
    <div id="location" class="relative isolate bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
            <div class="relative px-6 pb-20 pt-24 sm:pt-32 lg:static lg:px-8 lg:py-48">
                <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Where to Find Us</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">We're located in Covent Garden, London on a cozy little street corner. You can't miss us.</p>
                    <dl class="mt-10 space-y-4 text-base leading-7 text-gray-600">
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Address</span>
                                <BuildingOffice2Icon class="h-7 w-6 text-gray-400" aria-hidden="true" />
                            </dt>
                            <dd>172 James Street<br />Convent Garden, London</dd>
                        </div>
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Telephone</span>
                                <PhoneIcon class="h-7 w-6 text-gray-400" aria-hidden="true" />
                            </dt>
                            <dd><a class="hover:text-gray-900" href="tel:+1 (555) 234-5678">+44 7098 654321</a></dd>
                        </div>
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Email</span>
                                <EnvelopeIcon class="h-7 w-6 text-gray-400" aria-hidden="true" />
                            </dt>
                            <dd><a class="hover:text-gray-900" href="mailto:hello@read.it">info@read.it</a></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48">
                <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-0.14578342437744143%2C51.49912573429843%2C-0.10106563568115234%2C51.52529983831504&amp;layer=mapnik&amp;marker=51.51221466612502%2C-0.12342453002929688"
                        class="w-full h-full"
                ></iframe>
            </div>
        </div>
    </div>
</template>

<script setup>
import { BuildingOffice2Icon, EnvelopeIcon, PhoneIcon } from '@heroicons/vue/24/outline'
</script>
