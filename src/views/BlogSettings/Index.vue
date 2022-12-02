<script setup>
import AppLayout from '@themes/settings/Layouts/AppLayout.vue';
import { CalendarIcon , UsersIcon } from '@heroicons/vue/solid'

defineProps({
    blogs: Object
});

const positions = [
    {
        id: 1,
        title: 'Back End Developer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
    },
    {
        id: 2,
        title: 'Front End Developer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Engineering',
        closeDate: '2020-01-07',
        closeDateFull: 'January 7, 2020',
    },
    {
        id: 3,
        title: 'User Interface Designer',
        type: 'Full-time',
        location: 'Remote',
        department: 'Design',
        closeDate: '2020-01-14',
        closeDateFull: 'January 14, 2020',
    },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-16" v-if="blogs.length < 1">
            <div class="text-center">
                <p class="text-base font-semibold text-indigo-600">Not Found</p>
                <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">비어있어요 :(</h1>
                <p class="mt-2 text-base text-gray-500">아직 아무것도 생성되지 않았네요.</p>
                <div class="mt-6">
                    <a :href="route('settings.blog.create')" class="text-base font-medium text-indigo-600 hover:text-indigo-500">
                        새 게시판 만들기
                        <span aria-hidden="true"> &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="overflow-hidden bg-white shadow sm:rounded-md" v-else>
                <ul role="list" class="divide-y divide-gray-200">
                    <li v-for="blog in blogs" :key="blog.id">
                        <a :href="route('settings.blog.edit',{'blogId' : blog.id})" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="truncate text-sm font-medium text-indigo-600">{{ blog.title[$page.props.locale] }}</p>
                                    <div class="ml-2 flex flex-shrink-0">
                                        <p class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ blog.instance_id }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <UsersIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            {{ blog.tenant_id }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            <MapPinIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                            {{ blog.title[$page.props.locale] }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                        <p>
                                            Closing on
                                            {{ ' ' }}
                                            <time :datetime="blog.created_at">{{ blog.created_at }}</time>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
        </div>
    </AppLayout>
</template>
