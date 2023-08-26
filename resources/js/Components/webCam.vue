<template>
    <div>
        <button @click="toggleWebcam">{{ webcamActive ? 'Turn Off Webcam' : 'Turn On Webcam' }}</button>
        <video ref="webcam" autoplay></video>
    </div>
</template>

<script>
export default {
    name:'webCam',
    data() {
        return {
            webcamActive: false,
            stream: null
        };
    },
    methods: {
        async startWebcam() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
                this.$refs.webcam.srcObject = this.stream;
                this.webcamActive = true;
            } catch (error) {
                console.error('Error accessing webcam:', error);
            }
        },
        stopWebcam() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.$refs.webcam.srcObject = null;
                this.webcamActive = false;
            }
        },
        toggleWebcam() {
            if (this.webcamActive) {
                this.stopWebcam();
            } else {
                this.startWebcam();
            }
        }
    }
};
</script>

<style>
/* Add some styling if needed */
</style>
