<template>
    <div>
        this is index page SOPHIE WAS HERE
    </div>
    <div>{{message}}</div>
</template>

<script setup>
defineProps({
    //message is writen in backend indexController
    message: String,
})
</script>