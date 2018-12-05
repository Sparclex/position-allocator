<template>
    <div class="container">
        <h1 class="font-normal text-3xl mb-4 pt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
            Position Allocator
        </h1>
        <div class="rounded-lg shadow">
            <div class="bg-white rounded-t-lg p-4">
                <div class="flex mb-2 flex-col-reverse md:flex-row">
                    <portal-target name="buttons" class="flex-1"></portal-target>
                    <h3 class="text-2xl font-normal py-2 text-center flex-1">Plate {{plate}}</h3>
                    <div class="flex-1 flex justify-end">
                        <a href="/download"
                            class="flex-1 text-black no-underline p-1 bg-orange-lightest focus:outline-none rounded flex items-center justify-center mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </a>
                        <router-link
                        :to="{name: 'scanner', params: {view, plate}}"
                        class="flex-1 text-black no-underline p-1 bg-orange-lightest focus:outline-none rounded flex items-center justify-center mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        </router-link>
                        <a href="/auth/logout" title="Logout" class="text-black no-underline p-1 border border-grey-dark focus:outline-none rounded flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            <plates :view="view" :plate="plate" />
            <div class="bg-grey-lighter rounded-b-lg p-4">
                <div class="flex justify-between">
                    <component
                        :is="hasPreviousPage ? 'router-link' : 'p'"
                        class="flex items-center no-underline cursor-pointer"
                        :class="{
                            'text-black': hasPreviousPage,
                            'text-grey-dark': !hasPreviousPage
                        }"
                        :to="{name:'overview-page', params: {view, plate: plate - 1}}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="block sm:hidden h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    <span class="hidden sm:block uppercase font-bold">Previous</span>
                    </component>
                    <component
                        :is="hasNextPage ? 'router-link' : 'p'"
                        class="flex items-center no-underline cursor-pointer"
                        :class="{
                            'text-black': hasNextPage,
                            'text-grey-dark': !hasNextPage
                        }"
                        :to="{name:'overview-page', params: {view, plate: 1 + Number(plate)}}"
                    >
                    <span class="hidden sm:block uppercase font-bold">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="block sm:hidden h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        view: {
            default: 'table'
        },
        plate: {
            default: 1
        }
    },
    computed: {
        hasPreviousPage() {
            return this.plate > 1;
        },
        hasNextPage() {
            return true;
        },
    }
}
</script>
