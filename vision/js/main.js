window.addEventListener('load', init);

//GLOBAL
var video;
var canvas;
var context;
var tracker;
var greenX;
var greenY;

/**
 * main function:
 * Send http request if the color green is detected inside the color box of yellow, cyan and magenta
 */
function init(){
    //Cam connection
    getCamConnection();

    var cam = document.getElementById('cam');
    canvas = document.getElementById('canvas');
    context = canvas.getContext('2d');

    //register Color
    registerColors();

    //create colortracker, tracks Yellow, cyan, magneta (tracking.js) and green
    tracker = new tracking.ColorTracker(['yellow', 'cyan', 'magenta', 'green']);

    //track color
    trackColor();

}

/**
 * Search and get camera
 */
function getCamConnection(){
    video = document.querySelector("#cam");

    //search for camera in different browsers
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    //if camera found -> handleVideo else videoError
    if (navigator.getUserMedia) {
        navigator.getUserMedia({video: true, audio: false}, handleVideo, videoError);
    }
}

/**
 * streams camera
 * @param stream
 */
function handleVideo(stream){
    video.src = window.URL.createObjectURL(stream);
}

/**
 * handle video erro if getCamConnection() fails
 * @param e
 */
function videoError(e) {
    // do something
}

/**
 * register colors to be tracked
 */
function registerColors() {
    tracking.ColorTracker.registerColor('green', function (r, g, b) {
        if (r < 60 && g > 110 && b < 60) {
            return true;
        }
        return false;
    });
}

/**
 * Tracks color of camera and plot on canvas
 */
function trackColor(){

    tracking.track('#cam', tracker, {camera: true});

    tracker.on('track', function(event) {
        //reset
        context.clearRect(0, 0, canvas.width, canvas.height);

        //for each color draw rectangle
        event.data.forEach(function (rect) {

            //if green detected, save the coordinates
            if (rect.color === "green"){
                greenX = rect.x;
                greenY = rect.y;
            }

            //get color
            context.strokeStyle = rect.color;

            //draw rectangle
            context.strokeRect(rect.x, rect.y, rect.width, rect.height);

            //data of rect
            context.font = '11px Helvetica';
            context.fillStyle = "#fff";
            context.fillText('x: ' + rect.x + 'px', rect.x + rect.width + 5, rect.y + 11);
            context.fillText('y: ' + rect.y + 'px', rect.x + rect.width + 5, rect.y + 22);

            //if coordinates of green are inside coordinates of rect
                //send ping
            var greenXtrue = greenX > rect.x && greenX < (rect.x +rect.width);
            var greenYtrue = greenY > rect.y && greenY < (rect.y +rect.height);

            if (greenXtrue && greenYtrue){
                sendPing();
                greenY = '';
                greenX = '';
            }
        });
    });
}

/**
 * Send HTTP request
 */
function sendPing(){
    console.log('send ping');
}