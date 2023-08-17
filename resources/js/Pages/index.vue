<template>
    <div class="font-bold underline text-3xl">
        <p class="font-bold underline text-red-200">hello</p>
    </div>
    <div>{{message}}</div>
</template>

<script setup>
defineProps({
    //message is writen in backend indexController
    message: String,
})
</script>