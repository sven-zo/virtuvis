window.addEventListener('load', init);

//GLOBAL
var video;
var canvas;
var context;
var tracker;
var cXtemp;
var cYtemp;
var setTimeOut = false;

/**
 * main function:
 * Send http request if the color green is detected inside the color box of yellow, cyan and magenta
 */
function init(){
    //Handles webcam connection
    getCamConnection();

    var cam = document.getElementById('cam');
    canvas = document.getElementById('canvas');
    context = canvas.getContext('2d');

    //register additional colors to be tracked
    registerColors();

    //create colortracker, tracks Yellow, cyan, magneta (tracking.js) and green
    tracker = new tracking.ColorTracker(['yellow', 'magenta', 'green']);

    //start tracking colour of connected webcam
    trackColor();

}

/**
 * Search and get camera in different browsers
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
 * handle video error if getCamConnection() fails
 * @param e
 */
function videoError(e) {
    console.log("could not find camera, check cam source ");
    console.log(e);
}

/**
 * register additional colors to be tracked
 */
function registerColors() {
    tracking.ColorTracker.registerColor('green', function (r, g, b) {
        //green values on RGB color model, pure green (0,255,0)
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

    //connect tracker with video footage
    tracking.track('#cam', tracker, {camera: true});

    //start event track, tracks the colors
    tracker.on('track', function(event) {
        //reset rect
        context.clearRect(0, 0, canvas.width, canvas.height);

        //for each event draw rectangle
        event.data.forEach(function (rect) {

            //if yellow detected, save the coordinates
            if (rect.color === "yellow"){
                cXtemp = rect.x;
                cYtemp = rect.y;
            }

            //get color of event
            context.strokeStyle = rect.color;

            //draw rectangle for event
            context.strokeRect(rect.x, rect.y, rect.width, rect.height);

            //data of rect: font, color, position
            context.font = '11px Helvetica';
            context.fillStyle = "#fff";
            context.fillText('x: ' + rect.x + 'px', rect.x + rect.width + 5, rect.y + 11);
            context.fillText('y: ' + rect.y + 'px', rect.x + rect.width + 5, rect.y + 22);

            //if coordinates of green are inside coordinates of rect, send ping
            var cXcondition = cXtemp > rect.x && cXtemp < (rect.x +rect.width);
            var cYcondition = cYtemp > rect.y && cYtemp < (rect.y +rect.height);

            if (cXcondition && cYcondition){
                sendPing();

                //reset coordinates
                cYtemp = '';
                cXtemp = '';
            }
        });
    });
}

/**
 * Send HTTP request
 */
function sendPing(){
    if (setTimeOut){

        //prevents sendPing function to send more than 1 ping
        setTimeout( function() {
            setTimeOut = false;
        }, 3000);
    }
    else {

        //reqwest: library for handling async http requests (https://github.com/ded/reqwest)
        reqwest ({
            url: 'http://imanidap.nl/virtuvis/api/v1/fish.php',
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'CREATE', rod: 'green'},
            success: sendPingSuccessHandler,
            error: sendPingErrorHandler
        });

        setTimeOut = true;
    }
}



/**
 * Callback after success sendPing
 * @param data
 */
function sendPingSuccessHandler(data) {
    //play audio feedback after success
    var audio = new Audio('Audio/vis1.mp3');
    audio.play();
    
    console.log('send ping');
    console.log(data);
}

/**
 * Callback after error sendPing
 * @param data
 */
function sendPingErrorHandler(data) {
    console.log('error trying to send ping, check server');
    console.log(data);
}
