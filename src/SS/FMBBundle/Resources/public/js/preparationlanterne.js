function test() {
    //     jQuery('#cmptnombre').text(document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value)
}
$(document).ready(function () {
    // Bind normal buttons
    $('.ladda-button').ladda('bind');
    // Bind progress buttons and simulate loading progress
    Ladda.bind('.progress-demo .ladda-button', {
        callback: function (instance) {
            var progress = 0;
            var interval = setInterval(function () {
                progress = Math.min(progress + 0.1, document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value);
                instance.setProgress(progress);
                if (progress === document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value);
        }
    });
    var l = $('.ladda-button-demo').ladda();
    l.click(function () {
        // Start loading
        l.ladda('start');
        // Timeout example
        // Do something in backend and then stop ladda
        setTimeout(function () {
            l.ladda('stop');
        }, 12000)
    });
});