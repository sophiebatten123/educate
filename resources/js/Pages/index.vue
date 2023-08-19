<template>
    <div class="font-bold underline text-3xl bg-blue-200">
        <p class="font-bold underline text-blue-900 mb-4">Educate Whiteboard</p>
    </div>
    <div class="flex">
        <button class="rounded-full w-12 h-12 border-2 border-black h-20" @click="togglePencil" :class="pencil ? 'bg-yellow-400' : ''">
            <p><font-awesome-icon :icon="['fas', 'pencil']" /></p>
        </button>
        <!-- <button class="rounded-full border-2 border-black w-12 h-12 h-20 mx-4" @click="toggleEraser" :class="eraser ? 'bg-yellow-400' : ''">
            <p><font-awesome-icon :icon="['fas', 'eraser']" /></p>
        </button> -->
        <button class="rounded-full w-12 h-12 border-2 border-black h-20 mx-4" @click="toggleSquare" :class="square ? 'bg-yellow-400' : ''">
            <p><font-awesome-icon :icon="['fas', 'square']" /></p>
        </button>
        <button class="rounded-full w-12 h-12 border-2 border-black h-20" @click="toggleCircle" :class="circle ? 'bg-yellow-400' : ''">
            <p><font-awesome-icon :icon="['fas', 'circle']" /></p>
        </button>
        <button class="rounded-full w-12 h-12 border-2 border-black h-20 mx-4" @click="toggleImage" :class="image ? 'bg-yellow-400' : ''">
            <p><font-awesome-icon :icon="['fas', 'image']" /></p>
        </button>
    </div>
    <div class="flex">
        <div class="flex-grow">
             <div class="bg-red-200" style="height: 300px;">Tutor Camera</div>
             <div class="bg-green-200" style="height: 300px;">Student Camera</div>
        </div>
        <canvas ref="canvasRef" :width="canvasWidth" :height="canvasHeight" class="border-2 border-black"></canvas>
    </div>
</template>

<script>
import { fabric } from 'fabric';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';

// Add the solid (fas) icons to the library
library.add(fas);

export default {
  data() {
    return {
      pencil: true,
      eraser: false,
      square: false,
      circle: false,
      image: false,
      canvasWidth: 1000,
      canvasHeight: 1000,
      canvas: null,
      myImage: "https://cdn-icons-png.flaticon.com/256/5264/5264272.png"
    }
  },
  components: {
    FontAwesomeIcon
  },
  mounted() {
    this.initializeCanvas();
  },
  methods: {
    initializeCanvas() {
      this.canvas = new fabric.Canvas(this.$refs.canvasRef, {
        isDrawingMode: true,
      });
      window.addEventListener('keydown', this.handleKeyDown);
    },
    togglePencil() {
      this.pencil = !this.pencil;
      this.eraser = false;
      this.square = false;
      this.canvas.isDrawingMode = this.pencil;
    },
    toggleImage() {
      this.image = !this.image;
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      this.canvas.isDrawingMode = false;
      new fabric.Image.fromURL(this.myImage, (_img)=>{
        const _daisy = _img.set({left:0, top:0, width: _img.width, height: _img.height})
        this.canvas.add(_daisy)
      })
    },
    // toggleEraser() {
    //   this.eraser = !this.eraser;
    //   this.pencil = false;
    //   this.square = false;
    //   this.canvas.isDrawingMode = false;
    // },
    toggleSquare() {
      if (!this.square) {
        this.createSquare();
        this.square = true;

        setTimeout(() => {
          this.square = false;
        }, 1000); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.circle = false;
    },
    createSquare() {
      this.canvas.isDrawingMode = false;

      const rect = new fabric.Rect({
        top: 50,
        left: 50,
        height: 100,
        width: 100,
        selectable: true, // Make the rectangle selectable
      });

      this.canvas.add(rect);
      this.canvas.setActiveObject(rect);
    },
    toggleCircle() {
      if (!this.circle) {
        this.createCircle();
        this.circle = true;

        setTimeout(() => {
          this.circle = false;
        }, 1000); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
    },
    createCircle() {
      this.canvas.isDrawingMode = false;

      const circle = new fabric.Circle({
        top: 50,
        left: 50,
        radius: 40,
        fill: "green",
        selectable: true, // Make the circle selectable
      });

      this.canvas.add(circle);
      this.canvas.setActiveObject(circle);
    },
    handleKeyDown(event) {
      if (event.keyCode === 8) { // Backspace key
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
          this.canvas.remove(activeObject);
          this.canvas.discardActiveObject();
          this.canvas.renderAll();
        }
      }
    },
  },
  beforeDestroy() {
    // Clean up the keydown event listener when the component is destroyed
    window.removeEventListener('keydown', this.handleKeyDown);
  },
};
</script>