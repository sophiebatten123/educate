<template>
    <div class="flex">
        <div>
            <button @click="toggleAudioTest">audio&nbsp;test</button>
        </div>
        <div class="flex justify-between w-full h-30">
            <div v-for="(barHeight, index) in visualBars" :key="index" class="bar"
                 :style="{ height: barHeight + 'px' }"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                audioContext: null,
                analyserNode: null,
                visualBars: [],
                numBars: 20,
                maxBarHeight: 40,
                audioTest: false,
            };
        },
        methods: {
            async startAudioTest() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const source = this.audioContext.createMediaStreamSource(stream);
                    this.analyserNode = this.audioContext.createAnalyser();
                    source.connect(this.analyserNode);
                    this.analyserNode.connect(this.audioContext.destination);
                    this.analyserNode.fftSize = 256;
                    const bufferLength = this.analyserNode.frequencyBinCount;
                    this.visualBars = Array.from({ length: this.numBars }, () => 0);

                    this.animateVisualizer(bufferLength);
                    this.audioTest = true;
                } catch (error) {
                    console.error('Error accessing microphone:', error);
                }
            },
            stopAudioTest() {
                if (this.audioContext) {
                    this.audioTest = false
                    this.audioContext.close().then(() => {
                        this.audioContext = null;
                        this.analyserNode = null;
                        this.visualBars = [];
                    });
                }
            },
            toggleAudioTest() {
                if (this.audioTest) {
                    this.stopAudioTest()
                } else {
                    this.startAudioTest()
                }
            },
            animateVisualizer(bufferLength) {
                if (!this.audioContext) return;

                const dataArray = new Uint8Array(bufferLength);
                this.analyserNode.getByteFrequencyData(dataArray);

                for (let i = 0; i < this.numBars; i++) {
                    const barHeight = Math.min(dataArray[Math.floor((i / this.numBars) * bufferLength)], this.maxBarHeight);
                    this.visualBars[i] = barHeight;
                }

                requestAnimationFrame(() => this.animateVisualizer(bufferLength));
            },
        },
    };
</script>

<style scoped>
    .bar {
        width: 2px;
        background-color: blue;
        margin: 0 1px;
    }
</style>