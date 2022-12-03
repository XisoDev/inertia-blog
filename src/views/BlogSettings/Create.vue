<script setup>
import {defineProps, onMounted, ref} from 'vue';
import AppLayout from '@themes/settings/Layouts/AppLayout.vue';
import FieldLoader from '@fieldLoader/_LoaderString.vue';
import FileLoader from '@fieldLoader/_LoaderObject.vue';

import { InformationCircleIcon, PencilIcon, XCircleIcon, EllipsisHorizontalIcon } from '@heroicons/vue/20/solid';
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    errors: Object,
    forms : Object,
    blogId: String,
});
const createForm = useForm(props.forms['fields']);

function create(){
    createForm
        .transform((data) => ({
            ...data,
            id: props.blogId,
        }))
        .post(route('settings.blog.save'),{
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                console.log('success');
            }
        });
}
onMounted(() => {
    // console.log(props)
});
</script>

<template>
    <AppLayout title="게시판 생성">
        <div class="py-12">
            <form action="#" method="POST" @submit.prevent="create()">
                <div v-for="section in props.forms['sections']" :id="section.id" class="shadow sm:rounded-md sm:overflow-hidden mb-8">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ section.title }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ section.description }}</p>
                        </div>
                        <template v-for="field in section['fields']">
                            <div class="col-span-3 sm:col-span-2">
                                <template v-if="field.type === 'image' || field.type === 'file'">
                                    <FileLoader :field="field" v-model="createForm[field.id]" />
                                </template>
                                <template v-else>
                                    <FieldLoader :field="field" v-model="createForm[field.id]" />
                                </template>
                                <div v-if="createForm.errors[field.id]">
                                    <div class="rounded-md bg-red-50 p-4 mt-2">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                                            </div>
                                            <div class="ml-3">
                                                <h3 v-if="typeof createForm.errors[field.id] === 'string'" class="text-sm font-medium text-red-800">{{ createForm.errors[field.id] }}</h3>
                                                <template v-else>
                                                    <h3 class="text-sm font-medium text-red-800">{{ createForm.errors[field.id][0] }}</h3>
                                                    <div class="mt-2 text-sm text-red-700">
                                                        <ul role="list" class="list-disc space-y-1 pl-5">
                                                            <template v-for="(errorMessage,index) in createForm.errors[field.id]" :key="index">
                                                                <li v-if="index > 0">
                                                                    {{ errorMessage }}
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <template v-if="section.withButtons">
                        <progress v-if="createForm.progress" :value="createForm.progress.percentage" max="100">
                            {{ createForm.progress.percentage }} %
                        </progress>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">저장</button>
                        </div>
                    </template>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
