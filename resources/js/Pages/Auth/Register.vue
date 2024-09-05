<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/OrbitComponents/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Button from '@/Components/OrbitComponents/Button.vue';
import ProgressSpinner from 'primevue/progressspinner';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="flex justify-center items-center h-52" v-if="form.processing">
            <ProgressSpinner style="width: 70px; height: 70px" strokeWidth="2" fill="transparent" animationDuration="1s" />
        </div>

        <form @submit.prevent="submit" v-else>
            <div class="text-lg font-medium">
                Sign Up
            </div>
            <div class="text-gray-400 font-light text-sm">Register a new account with us</div>

            <div class="mt-10 flex flex-col gap-y-4">
                <TextInput v-model="form.name"                      icon="user"     placeholder="Full name"/>
                <TextInput v-model="form.email"                     icon="envelope" placeholder="Email"/>
                <TextInput v-model="form.password"                  icon="key"      placeholder="Password" password />
                <TextInput v-model="form.password_confirmation"     icon="key"      placeholder="Confirm Password" password />

                <div class="flex justify-center">
                    <Button type="submit" icon="user-plus" label="Register" class="w-36" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"/>
                </div>
            </div>

            <hr class="border-gray-700 my-6">

            <div class="flex flex-col items-center">
                <div>Already have account?</div>
                <Link :href="route('login')" class="mt-4">
                    <Button label="Sign In" icon="sign-in" />
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
