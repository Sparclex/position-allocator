<template>
    <div class="w-full h-screen relative">
        <div class="bg-transparent-black w-full absolute pin-t flex justify-end z-10">
            <router-link
            :to="{name:'overview-page', params: {view, plate}}"
            class="px-4 py-2 text-5xl no-underline text-white"
            >&times</router-link>
        </div>
        <div class="w-full flex justify-center items-center">
            <div class="relative w-full" id="scanner"></div>
        </div>
        <transition name="fade">
            <div class="fixed pin-b w-full h-screen flex items-center justify-center text-xl bg-green text-white py-2" v-show="feedback">
                    <p>{{feedback}}</p>
            </div>
        </transition>
    </div>
</template>
<script>
    import Quagga from 'quagga';
    export default {
        props: {
            view: {
                default: 'table'
            },
            plate: {
                default: 1
            }
        },
        data() {
            return {
                samples: {},
                feedback: null,
                feedbackTimeout: null,
            }
        },
        mounted() {
            this.startQuagga();
        },
        beforeDestroy() {
            Quagga.stop();
        },
        methods: {
            startQuagga() {
                Quagga.onDetected(this.onDetected);
                Quagga.onProcessed(result => {
                    let drawingCtx = Quagga.canvas.ctx.overlay,
                        drawingCanvas = Quagga.canvas.dom.overlay;

                    if (result) {
                        if (result.boxes) {
                            drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                            result.boxes.filter(function (box) {
                                return box !== result.box;
                            }).forEach(function (box) {
                                Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                            });
                        }
                        if (result.box) {
                            Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
                        }

                        if (result.codeResult && result.codeResult.code) {
                            Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
                        }
                    }
                });
                Quagga.init({
                inputStream : {
                  name : "Live",
                  type : "LiveStream",
                  target: document.querySelector('#scanner')
                },
                decoder : {
                  readers : ["code_39_reader"]
                }
              }, function(err) {
                  if (err) {
                      console.log(err.message);
                      return
                  }
                  console.log("Initialization finished. Ready to start");
                  Quagga.start();
                  document.querySelector('canvas').style = "position:absolute; top: 0; left: 0;";
              });
            },
            onDetected(result) {
                Quagga.offDetected(this.onDetected);
                if(!this.samples[result.codeResult.code]) {
                    axios.post('/api/samples', {id: result.codeResult.code})
                    .then(({data}) => {
                        this.samples[result.codeResult.code] = data.computedPosition;
                        this.sendFeedback(result.codeResult.code, data.computedPosition);
                        Quagga.onDetected(this.onDetected);
                    });
                }
                else {
                    this.sendFeedback(result.codeResult.code, this.samples[result.codeResult.code]);
                    Quagga.onDetected(this.onDetected);
                }

            },
            sendFeedback(sampleId, position) {
                this.feedback = `Sample ${sampleId} stored in position ${position}`;
                if(this.feedbackTimeout) {
                    clearTimeout(this.feedbackTimeout);
                }

                this.feedbackTimeout = setTimeout(() => {
                     this.feedback = null;
                 }, 2000);
            }
        }
    }
</script>
<style>
    #scanner > video,
    #scanner > canvas {
        width: 100%;
        max-width: 100%;
        max-height: 100vh;
    }
</style>
