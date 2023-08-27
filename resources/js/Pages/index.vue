<template>
    <div class="font-bold underline text-3xl">
        <p class="font-bold underline text-blue-900 my-4 ml-2">Educate Whiteboard</p>
    </div>
    <pingTest></pingTest>
    <div class="grid-cols-3 grid">
        <div class="w-full col-span-2 canvasContainer" ref="canvasContainer">
          <canvas ref="canvasRef" class="border-2 border-black"></canvas>
        </div>
      <div>
        <div class="border-y-2 border-r-2 border-black w-full" style="height: 300px;">
            <div class="border-l-2 border-b-2 border-black w-1/3 float-right" style="height: 100px;">
                <webCam></webCam>
                <audioTest></audioTest>
            </div>
          </div>
          <div class="flex justify-center mt-4">
            <button class="rounded-full w-12 h-12 border-2 border-black" @click="togglePencil" :class="pencil && pencilBlack ? 'bg-gray-800 text-white' : pencil && pencilGreen ? 'bg-green-400' : pencil && pencilRed ? 'bg-red-400' : pencil && pencilBlue ? 'bg-blue-400' : ''">
                <p><font-awesome-icon :icon="['fas', 'pencil']" /></p>
            </button>
            <!-- <button class="rounded-full border-2 border-black w-12 h-12 h-20 mx-4" @click="toggleEraser" :class="eraser ? 'bg-yellow-400' : ''">
                <p><font-awesome-icon :icon="['fas', 'eraser']" /></p>
            </button> -->
            <button class="rounded-full w-12 h-12 border-2 border-black mx-4" @click="toggleSquare" :class="square ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'square']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black" @click="toggleCircle" :class="circle ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'circle']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black mx-4" @click="toggleImage" :class="image ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'image']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black" @click="toggleText" :class="text ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'font']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black mx-4" @click="togglePolygon" :class="polygon ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'draw-polygon']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black" @click="toggleLine" :class="line ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'lines-leaning']" /></p>
            </button>
          </div>
          <div class="flex justify-center mt-4">
            <button class="rounded-full w-12 h-12 border-2 border-black mx-4" @click="toggleHighlight" :class="highlight ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'paintbrush']" /></p>
            </button>
            <button class="rounded-full w-12 h-12 border-2 border-black mx-4" @click="toggleBin" :class="bin ? 'bg-gray-800 text-white' : ''">
                <p><font-awesome-icon :icon="['fas', 'trash']" /></p>
            </button>
          </div>
          <div class="flex mt-8 justify-center">
            <button class="bg-gray-800 h-4 w-4 border-2 border-black" @click="textBlack"></button>
            <button class="bg-blue-300 h-4 w-4 border-2 border-black mx-4" @click="textBlue"></button>
            <button class="bg-red-300 h-4 w-4 border-2 border-black" @click="textRed"></button>
            <button class="bg-green-300 h-4 w-4 border-2 border-black mx-4" @click="textGreen"></button>
          </div>
        </div>
    </div>
</template>

<script>
import { fabric } from 'fabric';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import webCam from '@/Components/webCam.vue';
import audioTest from '@/Components/audioTest.vue';
import pingTest from '@/Components/pingTest.vue';

// Add the solid (fas) icons to the library
library.add(fas);
var canvas = null;

export default {
  data() {
    return {
      pencil: true,
      pencilBlack: true,
      pencilRed: false,
      pencilGreen: false,
      pencilBlue: false,
      eraser: false,
      square: false,
      circle: false,
      image: false,
      line: false,
      text: false,
      bin: false,
      highlight: false,
      polygon: false,
      canvasWidth: 0,
      canvasHeight: 0,
      // canvas: null,
      myImage: "https://cdn-icons-png.flaticon.com/256/5264/5264272.png"
    }
  },
  components: {
    FontAwesomeIcon,
    webCam,
    audioTest,
    pingTest
  },
  mounted() {
    this.initializeCanvas();
  },
  methods: {
    initializeCanvas() {
      // Get the width of the col-span-2 element
      const colSpan2Width = this.$refs.canvasContainer.offsetWidth; // Assumes "canvasContainer" is the class of the parent div

      // Set the canvas dimensions
      this.canvasWidth = colSpan2Width;
      this.canvasHeight = 600; // Set your desired canvas height here

      canvas = new fabric.Canvas(this.$refs.canvasRef, {
        isDrawingMode: true,
        width: this.canvasWidth,
        height: this.canvasHeight
      });
      // window.addEventListener('keydown', this.handleKeyDown);
    },
    togglePencil() {
      this.pencil = !this.pencil;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = this.pencil;
    },
    toggleHighlight() {
      class HighlighterBrush extends fabric.PencilBrush {
        onMouseDown(pointer) {
          this.canvas.freeDrawingBrush.color = 'rgba(255, 255, 0, 0.3)';
          super.onMouseDown(pointer);
        }
      }
      const highlighterBrush = new HighlighterBrush(canvas);

      canvas.freeDrawingBrush = highlighterBrush;
      this.highlight = !this.highlight;
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = this.pencil;
    },
    textBlack() {
      if (canvas) {
        canvas.freeDrawingBrush.color = 'black';
        this.pencilBlack = !this.pencilBlack;
        this.pencilBlue = false;
        this.pencilGreen = false;
        this.pencilRed = false;
      }
    },
    textBlue() {
      if (canvas) {
        canvas.freeDrawingBrush.color = 'blue';
        this.pencilBlue = !this.pencilBlue
        this.pencilBlack = false;
        this.pencilGreen = false;
        this.pencilRed = false;
      }
    },
    textRed() {
      if (canvas) {
        canvas.freeDrawingBrush.color = 'red';
        this.pencilRed = !this.pencilRed
        this.pencilBlue = false;
        this.pencilGreen = false;
        this.pencilBlack = false;
      }
    },
    textGreen() {
      if (canvas) {
        canvas.freeDrawingBrush.color = 'green';
        this.pencilGreen = !this.pencilGreen
        this.pencilBlue = false;
        this.pencilBlack = false;
        this.pencilRed = false;
      }
    },
    toggleText() {
      if (!this.text) {
        const textBox = this.createText();
        canvas.setActiveObject(textBox); // Activate the text box
        canvas.renderAll(); // Render the canvas to reflect changes
        this.text = true;

        setTimeout(() => {
          this.text = false;
            }, 500); // Toggle back after 1 second
          }
          this.pencil = false;
          this.eraser = false;
          this.square = false;
          canvas.isDrawingMode = false;
    },
    togglePolygon() {
      if (!this.polygon) {
        this.createPolygon();
        this.polygon = true;

        setTimeout(() => {
          this.polygon = false;
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = false;
    },
    createPolygon() {
      const centerX = 150;
      const centerY = 150;
      const radius = 100;
      const sides = 5;

      const points = [];

      for (let i = 0; i < sides; i++) {
        const angle = (i * 2 * Math.PI) / sides;
        const x = centerX + radius * Math.cos(angle);
        const y = centerY + radius * Math.sin(angle);
        points.push({ x, y });
      }

      const pentagon = new fabric.Polygon(points, {
        left: 0,
        top: 0,
        fill: "yellow",
        stroke: "black",
        strokeWidth: 2
      });

      canvas.add(pentagon);
    },
    toggleBin() {
      if (!this.bin) {
        this.clearCanvas();
        this.bin = true;

        setTimeout(() => {
          this.bin = false;
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = false;
    },
    clearCanvas() {
      canvas.clear()
    },
    createText() {
      const textBox = new fabric.Textbox("Enter Text Here", {
        left: 20,
        top: 20,
        fill: "black",
        stroke: "black",
        strokeWidth: 2,
        width: 400, // Set the width to a specific value
        breakWords: false,
        fontFamily: "Poppins", // Set the desired font family
        fontSize: 28,
      });
      canvas.add(textBox);
      return textBox; // Return the created text box
    },
    toggleLine() {
      if (!this.line) {
        this.createLine();
        this.line = true;

        setTimeout(() => {
          this.line = false;
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = false;
    },
    createLine() {
      const line = new fabric.Line([50, 50, 200, 200], {
        fill: "black", // Fill color of the line (not applicable for lines)
        stroke: "blue", // Stroke color of the line
        strokeWidth: 2 // Stroke width of the line
      });

      canvas.add(line);
    },
    toggleImage() {
      if (!this.image) {
        this.createImage();
        this.image = true;

        setTimeout(() => {
          this.image = false;
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
      canvas.isDrawingMode = false;
    },
    createImage() {
      new fabric.Image.fromURL(this.myImage, (_img)=>{
        const _daisy = _img.set({left:0, top:0, width: _img.width, height: _img.height})
        canvas.add(_daisy)
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
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.circle = false;
    },
    createSquare() {
      canvas.isDrawingMode = false;

      const rect = new fabric.Rect({
        top: 50,
        left: 50,
        height: 100,
        width: 100,
        selectable: true,
        fill: "blue", // Make the rectangle selectable
      });

      canvas.add(rect);
      canvas.setActiveObject(rect);
    },
    toggleCircle() {
      if (!this.circle) {
        this.createCircle();
        this.circle = true;

        setTimeout(() => {
          this.circle = false;
        }, 500); // Toggle back after 1 second
      }
      this.pencil = false;
      this.eraser = false;
      this.square = false;
    },
    createCircle() {
      canvas.isDrawingMode = false;

      const circle = new fabric.Circle({
        top: 50,
        left: 50,
        radius: 40,
        fill: "green",
        selectable: true, // Make the circle selectable
      });

      canvas.add(circle);
      canvas.setActiveObject(circle);
    },
    // handleKeyDown(event) {
    //   if (event.keyCode === 8) { // Backspace key
    //     const activeObject = canvas.getActiveObject();
    //     if (activeObject) {
    //       canvas.remove(activeObject);
    //       canvas.discardActiveObject();
    //       canvas.renderAll();
    //     }
    //   }
    // },
  },
  // beforeDestroy() {
  //   // Clean up the keydown event listener when the component is destroyed
  //   window.removeEventListener('keydown', this.handleKeyDown);
  // },
};
</script>