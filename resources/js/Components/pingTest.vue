<template>
    <div>
      <button v-if="!isTesting" @click="startTesting" class="bg-green-300">Start Internet connection Test</button>
      <button v-if="isTesting" @click="stopTesting" class="bg-red-300">Stop Internet connection Test</button>
      <div class="flex">
          <p v-if="pingResult !== null">Ping Result: {{ pingResult }} ms </p>
          <div class="w-5 h-5" :class="getColorClass"></div>
        </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isTesting: false,
        pingResult: null,
        localServerUrl: 'http://127.0.0.1:8000', // Adjust the port as needed
        intervalId: null,
      };
    },
    computed: {
    getColorClass() {
      if (this.pingResult === null) {
        return '';
      } else if (this.pingResult <= 30) {
        return 'bg-green-500';
      } else if (this.pingResult <= 60) {
        return 'bg-yellow-500';
      } else {
        return 'bg-red-500';
      }
    },
  },
    methods: {
      startTesting() {
        this.isTesting = true;
        this.pingLocalServer(); // Test immediately on start
        this.intervalId = setInterval(() => {
          this.pingLocalServer();
        }, 1000); // Test every second
      },
      stopTesting() {
        this.isTesting = false;
        clearInterval(this.intervalId);
        this.intervalId = null;
        this.pingResult = null
      },
      async pingLocalServer() {
        try {
          const startTime = performance.now();
          await fetch(this.localServerUrl);
          const endTime = performance.now();
          this.pingResult = Math.round(endTime - startTime);
        } catch (error) {
          console.error('Local server test error:', error);
        }
      },
    },
    beforeDestroy() {
      if (this.intervalId) {
        clearInterval(this.intervalId);
      }
    },
  };
  </script>
  
  <style scoped>
  /* Your styles here */
  </style>
  