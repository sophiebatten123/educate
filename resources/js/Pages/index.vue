<template>
    <div>
        this is index page
    </div>
    <div>{{message}}</div>
</template>

<script setup>
defineProps({
    //message is writen in backend indexController
    message: String,
})
</script>