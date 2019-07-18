<!DOCTYPE html>
<body>
<div id="project" ></div>
</body>
</html>
<?php
    $this->registerJs('

    $(function(){    
        $("nav").remove(); 
        var arr = '. json_encode($data) . ';
        var  leng = arr.length;
        for (let j = 0; j < leng;j++) {
            var ctx =  `<canvas id="canvas${j}"></canvas>` ;
            project.innerHTML += ctx;
        }
        for (let i = 0; i < leng; i++) {
            var canvas = document.getElementById("canvas" + i);
            eval("var " + "arr" + i + "=canvas.getContext(`2d`)");
            canvas.width = 270;
            canvas.height = 330;
            eval("arr" + i ).rect(0, 0, canvas.width, canvas.height);
            eval("arr" + i ).fillStyle = "#fff";
            eval("arr" + i ).fill();
            var myImage = new Image();
            myImage.src = "/img/beijing.png";
            myImage.onload = function () {
                eval("arr" + i ).drawImage(myImage, 0, 0, canvas.width, canvas.height);
                var myImage2 = new Image();
                myImage2.src = arr[i].qrcode_path;
                eval("arr" + i ).font = "14px Courier New";
                eval("arr" + i ).fillText(arr[i].id, 65, 265);
                myImage2.onload = function () {
                    const width = Math.floor((canvas.width - myImage2.width) / 2);
                    const height = Math.floor((canvas.height - myImage2.height) / 2);
                    eval("arr" + i ).drawImage(myImage2, 40, 70, 180, 180 );
                };
            };
        }
    })             
    ');?>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    canvas {
        border: 2px solid #4C9ACA;
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 10px;
    }
</style>