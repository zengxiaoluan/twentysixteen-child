"use strict";
window.addEventListener('load', loadHandler, false);
function loadHandler() {
    var svgFile = document.querySelector('#svg-file');
    var main = document.querySelector('#main');
    svgFile.addEventListener('change', function () {
        var files = this.files;
        svg2png(files);
    });
    dropHandler();
}
function svg2png(files) {
    var main = document.querySelector('#main');
    var fReader = new FileReader();
    loadImageFile(files[0]);
    console.log(files);
    fReader.onload = function (oFREvent) {
        var image = new Image();
        if (oFREvent.target) {
            image.src = oFREvent.target.result;
            image.onload = function () {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                console.log(image.width, image.height);
                canvas.width = image.width;
                canvas.height = image.height;
                ctx.drawImage(image, 0, 0, image.width, image.height);
                // Now is done
                var png = canvas.toDataURL('image/png');
                var a = document.createElement('a');
                main.appendChild(a);
                a.href = png;
                a.download = files[0].name + '.png';
                a.click();
                main.removeChild(a);
            };
        }
        main.appendChild(image);
    };
    function loadImageFile(file) {
        fReader.readAsDataURL(file);
    }
}
function dropHandler() {
    var dropRegion = document.querySelector('#drag-svg-file');
    dropRegion.addEventListener('click', function () {
        var svgFile = document.querySelector('#svg-file');
        svgFile.click();
    });
    document.addEventListener('drop', function (e) {
        e.preventDefault();
        var target = e.target;
        if (target !== dropRegion)
            return;
        var files = e.dataTransfer.files;
        svg2png(files);
    });
}
window.addEventListener('dragover', function (e) {
    e.preventDefault();
});
