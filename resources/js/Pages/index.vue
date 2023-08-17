<template>
    <div class="font-bold underline text-3xl bg-blue-200">
        <p class="font-bold underline text-blue-900 mb-4">Educate Whiteboard</p>
    </div>
    <div class="flex">
        <button class="bg-orange-200 h-20">
            <p>Pencil</p>
        </button>
        <button class="bg-purple-200 h-20">
            <p>Rubber</p>
        </button>
    </div>
    <div class="flex">
        <div class="flex-grow">
             <div class="bg-red-200" style="height: 300px;">Tutor Camera</div>
             <div class="bg-green-200" style="height: 300px;">Student Camera</div>
        </div>
        <canvas ref="canvas" class="bg-white border-2 border-black"></canvas>
    </div>
</template>

<script>
import { fabric } from 'fabric';

export default {
  mounted() {
    this.initializeCanvas();
  },
  methods: {
    initializeCanvas() {
      this.canvas = new fabric.Canvas(this.$refs.canvas, {
        width: 1150,
        height: 600
      });

      // Set up drawing functionality
      this.canvas.isDrawingMode = true;
      this.canvas.freeDrawingBrush.width = 5;

      // Register the path:created event
      this.canvas.on('path:created', (event) => {
        console.log(event.path);
        const path = event.path;
        this.canvas.add(path);
        this.canvas.renderAll();
      });
      
    },
  },
};
</script>