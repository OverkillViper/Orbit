<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from 'primevue/checkbox';
import Button from '@/Components/OrbitComponents/Button.vue';
import ProgressSpinner from 'primevue/progressspinner';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="flex justify-center items-center h-52" v-if="form.processing">
            <ProgressSpinner style="width: 70px; height: 70px" strokeWidth="2" fill="transparent" animationDuration="1s" />
        </div>

        <form @submit.prevent="submit" v-else>
            <div class="text-lg font-medium">
                Sign In
            </div>
            <div class="text-gray-400 font-light text-sm">Log into your account</div>

            <div class="mt-10 flex flex-col gap-y-4">
                <TextInput v-model="form.email"     icon="envelope" placeholder="Email"/>
                <TextInput v-model="form.password"  icon="key"      placeholder="Password" password />
                <div class="flex items-center text-sm">
                    <Checkbox v-model="form.remember" :binary="true" inputId="remember"/>
                    <div class="flex-grow">
                        <label class="text-gray-400 ms-2 select-none" for="remember">Keep me logged in</label>
                    </div>
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-gray-400 hover:text-gray-200 transition underline">
                        Forgot Password?
                    </Link>
                </div>
                <div class="flex justify-center">
                    <Button type="submit" label="Sign in" icon="sign-in" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"/>
                </div>
            </div>

            <hr class="border-neutral-700 my-6">

            <div class="flex flex-col items-center">
                <div>Don't have account?</div>
                <Link :href="route('register')" class="my-4">
                    <Button label="Register" icon="user-plus" />
                </Link>
            </div>
        </form>

        <!-- <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form> -->
    </GuestLayout>
</template>
