<main>

<a class="page-header d-block text-decoration-none p-3 fs-4 d-flex justify-content-between align-items-center mb-3" href="<?=base_url();?>">
    <i class="bx bx-arrow-back"></i>
    <span class="mx-auto"><?=$secTitle;?></span>
</a>

<div class="container">

    <section class="wrap-fortuneWheel">
        <div class="py-xl-5 py-lg-5 py-md-5 py-3">
            <div class="card bg-transparent border-0">
                
                <dl class="row m-0 g-2">
                    <dd class="col-xl-5 col-lg-5 col-md-5 col-12 mx-auto position-relative">
                        <div class="text-center fortuneWheel-button">
                            <a href="javascript:void(0);" class="btn-spin shadow" id="btn-spin" onClick="calculatePrize();"></a>
                        </div>
                        <firgure class="d-block m-0 p-0 innerWheel position-relative">
                            <canvas id="fortuneWheel" width="460" height="460" data-responsiveMinWidth="180" data-responsiveScaleHeight="true" data-responsiveMargin="50">
                                <p class="text-white text-center">Sorry, your browser doesn't support canvas. Please try another.</p>
                            </canvas>
                        </firgure>
                    </dd>
                    <dd class="col-xl-4 col-lg-4 col-md-4 col-12">
                        <article class="topList">
                            <table class="table table-hover bg-light">
                            <thead class="text-center bg-55vp"><tr><td><?=lang('Label.player');?></td><td><?=lang('Label.prize');?></td></tr></thead>
                            <tbody class="text-center" id="topList"></tbody>
                            </table>
                        </article>

                        <!-- <article class="agenda">
                            <iframe id="inlineFrameExample" title="Inline Frame Example" width="100%" height="420" src="https://spg20.vvip55.com/prizelist.html"></iframe>
                        </article> -->
                    </dd>
                </dl>
            
            </div>
        </div>
    </section>

</div>
</main>

<script src="<?=base_url('../assets/vendors/fortunewheel/Winwheel.min.js');?>"></script>
<script src="<?=base_url('../assets/vendors/fortunewheel/TweenMax.min.js');?>"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    topList();
});

function topList()
{
    $.get('/fortune-wheel/top-20', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            let list = obj.data;
            list.forEach(function(item, index) {
                var node = document.createElement("tr");
                var nodeName = document.createElement("td");
                var nodePrize = document.createElement("td");

                var nodeNameText = document.createTextNode(item.loginId);
                
                if( item.rewardsAmount==0 ) {
                    var nodePrizeText = document.createTextNode(item.displayName);
                } else {
                    var nodePrizeText = document.createTextNode(item.rewardsAmount);
                }

                nodeName.appendChild(nodeNameText);
                nodePrize.appendChild(nodePrizeText);
                node.appendChild(nodeName);
                node.appendChild(nodePrize);
                document.getElementById('topList').appendChild(node);
            });
        } else {
            swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    });
}

let segment, theWheel, ctx;
$.get('/fortune-wheel/get', function(data, status) {
    const obj = JSON.parse(data);
    if( obj.code==1 && obj.data!='' ) {
        segment = obj.data.length;
        var wheel = obj.data;
        var arr = [];

        let canvas = document.getElementById('fortuneWheel');
        let ctx = canvas.getContext('2d');
        let canvasCenter = canvas.height / 2;
        let yellowGradient = ctx.createRadialGradient(canvasCenter, canvasCenter, 50, canvasCenter, canvasCenter, 250);
        yellowGradient.addColorStop(0, "#FCF6C4");
        yellowGradient.addColorStop(0.5, "#FCF6C4");
        yellowGradient.addColorStop(1, "#FCF6C4");

        let redGradient = ctx.createRadialGradient(canvasCenter, canvasCenter, 50, canvasCenter, canvasCenter, 250);
        redGradient.addColorStop(0, "#E54439");
        redGradient.addColorStop(0.5, "#E2382F");
        redGradient.addColorStop(1, "#FF0000");

        let purpleGradient = ctx.createRadialGradient(canvasCenter, canvasCenter, 50, canvasCenter, canvasCenter, 250);
        purpleGradient.addColorStop(0, "#cb60b3");
        purpleGradient.addColorStop(0.5, "#ad1283");
        purpleGradient.addColorStop(1, "#de47ac");

        var bgColor = [
            '<?=base_url('../assets/img/fortunewheel/red.png');?>', 
            '<?=base_url('../assets/img/fortunewheel/brown.png');?>', 
            '<?=base_url('../assets/img/fortunewheel/red.png');?>',
            '<?=base_url('../assets/img/fortunewheel/brown.png');?>',
            '<?=base_url('../assets/img/fortunewheel/red.png');?>',
            '<?=base_url('../assets/img/fortunewheel/brown.png');?>',
            '<?=base_url('../assets/img/fortunewheel/red.png');?>',
            '<?=base_url('../assets/img/fortunewheel/brown.png');?>'
        ];
        var textColor = ['#FDEF9A','#690101','#FDEF9A','#690101','#FDEF9A','#690101','#FDEF9A','#690101'];
        wheel.forEach(function(item, index) {
            var oj = {};
            // oj['image'] = '<?//=base_url('../assets/img/fortunewheel/red.png');?>';
            // oj['fillStyle'] = bgColor[index];
            oj['textFillStyle'] = textColor[index];
            oj['image'] = bgColor[index];
            oj['text'] = item.name;
            arr.push(oj);
        });

        theWheel = new Winwheel({
            'canvasId': 'fortuneWheel',
            'numSegments': 8,
            'outerRadius': 200,
            'responsive' : true,
            'drawText': true,
            'textFontSize': 16,
            'textFontWeight': 'normal',
            'textOrientation': 'horizontal',
            'textAlignment': 'center',
            'textDirection': 'reversed',
            'textMargin': 15,
            'textFontFamily': 'Arial',
            'text' : 'Arial',
            'drawMode': 'segmentImage',
            'segments': arr,
            'animation':
            {
                'type': 'spinToStop',
                'duration': 5,
                'spins': 8,
                // 'callbackAfter': 'drawTriangle()',
                'callbackFinished': alertPrize,
                'callbackSound': playSoundFW,
                'soundTrigger': 'pin'
            },
            'pins':
            {
                'responsive' : true,
                'number': 16,
                'outerRadius': 3,
                'margin' : 10,
                'fillStyle': '#FDEF9A',
                'strokeStyle' : '#e73827'
            }
        });
    } else if( obj.code==1 && obj.data=='' ) {
        swal.fire({
            title: 'Nothing to Spin Now',
            icon: 'info',
        }).then((result) => {
            // $('.btn-spin').hide();
            document.getElementById("btn-spin").disabled = true;
            document.getElementById("btn-spin").removeAttribute("onclick");
        });
    } else {
        swal.fire("Error!", obj.message + " (Code: "+obj.code+")", "error");
    }
})
.done(function() {
})
.fail(function() {
    swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
});

let audio = new Audio('<?=base_url('../assets/vendors/fortunewheel/tick.mp3');?>');
let winning = new Audio('<?=base_url('../assets/vendors/fortunewheel/winning.mp3');?>');

function playSoundFW()
{
    // Stop and rewind the sound if it already happens to be playing.
    audio.pause();
    audio.currentTime = 0;

    // Play the sound.
    audio.play();
    return;
}

let wheelPower = 0;
let wheelSpinning = false;

function powerSelected(powerLevel)
{
    // Ensure that power can't be changed while wheel is spinning.
    if (wheelSpinning == false) {
        // Reset all to grey incase this is not the first time the user has selected the power.
        document.getElementById('pw1').className = "";
        document.getElementById('pw2').className = "";
        document.getElementById('pw3').className = "";

        // Now light up all cells below-and-including the one selected by changing the class.
        if (powerLevel >= 1) {
            document.getElementById('pw1').className = "pw1";
        }

        if (powerLevel >= 2) {
            document.getElementById('pw2').className = "pw2";
        }

        if (powerLevel >= 3) {
            document.getElementById('pw3').className = "pw3";
        }

        // Set wheelPower var used when spin button is clicked.
        wheelPower = powerLevel;

        // Light up the spin button by changing it's source image and adding a clickable class to it.
        document.getElementById('spin_button').src = "<?=base_url('../assets/vendors/fortunewheel/img/spin_on.png');?>";
        document.getElementById('spin_button').className = "clickable";
    }
}

function startSpin()
{
    // Ensure that spinning can't be clicked again while already running.
    if (wheelSpinning == false) {
        // Based on the power level selected adjust the number of spins for the wheel, the more times is has
        // to rotate with the duration of the animation the quicker the wheel spins.
        if (wheelPower == 1) {
            theWheel.animation.spins = 3;
        } else if (wheelPower == 2) {
            theWheel.animation.spins = 8;
        } else if (wheelPower == 3) {
            theWheel.animation.spins = 15;
        }

        // Disable the spin button so can't click again while wheel is spinning.
        document.getElementById('spin_button').src = "<?=base_url('../assets/vendors/fortunewheel/img/spin_off.png');?>";
        document.getElementById('spin_button').className = "";

        // Begin the spin animation by calling startAnimation on the wheel object.
        theWheel.startAnimation();

        // Set to true so that power can't be changed and spin button re-enabled during
        // the current animation. The user will have to reset before spinning again.
        wheelSpinning = true;
        return;
    }
}

function calculatePrize()
{
    theWheel.animation.spins = 15;
    $.get('/fortune-wheel/spin', function(data, status) {
        const obj = JSON.parse(data);
        StopAtPrize(obj.data.id,obj.data.name);
    })
    .done(function() {
        refreshBalance();
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    }); 
}

function StopAtPrize(id,name)
{
    $.get('/fortune-wheel/get', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            const loopWheel = obj.data;
            loopWheel.forEach(function(item, index) {
                if( id==item.id ) {
                    var segmentNumber = index+1;
                    var stopAt = theWheel.getRandomForSegment(segmentNumber);
                    theWheel.animation.stopAngle = stopAt;
                    theWheel.startAnimation();
                    wheelSpinning = true;
                    return;
                }
            });
        } else {
            alert('something Wrong');
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("Error!", "Oopss! There are something wrong. Please try again later.", "error");
    }); 
}

function resetWheel()
{
    theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
    theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
    theWheel.draw();                // Call draw to render changes to the wheel.

    document.getElementById('pw1').className = "";  // Remove all colours from the power level indicators.
    document.getElementById('pw2').className = "";
    document.getElementById('pw3').className = "";

    wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
}

function alertPrize(indicatedSegment)
{
    // Do basic alert of the segment text. You would probably want to do something more interesting with this information.
    // alert(indicatedSegment.text + ' says Hi');
    // resetWheel();
    document.getElementById('topList').innerHTML = '';
    topList();

    winning.pause();
    winning.currentTime = 0;

    // Play the sound.
    winning.play();
    // return;

    swal.fire("Congratulation!", "You have got the prize", "success").then(() => {
        resetWheel();
        return;
    });
}

drawTriangle();

function drawTriangle()
{
    ctx = theWheel.ctx;
    ctx.strokeStyle = '#fccd4d';
    ctx.fillStyle = '#fccd4d';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(220, 5);
    ctx.lineTo(280, 5);
    ctx.lineTo(250, 40);
    ctx.lineTo(221, 5);
    ctx.stroke();
    ctx.fill();
}
</script>