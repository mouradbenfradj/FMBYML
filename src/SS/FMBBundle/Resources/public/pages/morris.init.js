/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Morris Chart
 */

!function ($) {
    "use strict";

    var MorrisCharts = function () {
    };


    //creates Bar chart
    MorrisCharts.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
        Morris.Bar({
            element: element,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            hideHover: 'auto',
            resize: true, //defaulted to true
            gridLineColor: '#eeeeee',
            barColors: lineColors
        });
    },

        MorrisCharts.prototype.init = function () {

            var NH1 = 0, NH2 = 0, NH3 = 0, NH4 = 0, NH5 = 0;
            var NM1 = 0, NM2 = 0, NM3 = 0, NM4 = 0, NM5 = 0;
            var P1 = 0, P2 = 0, P3 = 0, P4 = 0, P5 = 0;
            if (document.getElementById('NH1') != null)
                NH1 = document.getElementById('NH1').getAttribute('value');
            if (document.getElementById('NH2') != null)
                NH2 = document.getElementById('NH2').getAttribute('value');
            if (document.getElementById('NH3') != null)
                NH3 = document.getElementById('NH3').getAttribute('value');
            if (document.getElementById('NH4') != null)
                NH4 = document.getElementById('NH4').getAttribute('value');
            if (document.getElementById('NH5') != null)
                NH5 = document.getElementById('NH5').getAttribute('value');
            //creating bar chart
            var $barData = [
                {y: 'NH1', a: NH1, b: 0, c: 0},
                {y: 'NH2', a: NH2, b: 0, c: 0},
                {y: 'NH3', a: NH3, b: 0, c: 0},
                {y: 'NH4', a: NH4, b: 0, c: 0},
                {y: 'NH5', a: NH5, b: 0, c: 0}
            ];
            this.createBarChart('morris-bar-example', $barData, 'y', ['a', 'b', 'c'], ['Huitre', 'Moule', 'Poche'], ['#5fbeaa', '#5d9cec', '#ebeff2']);
        },
        //init
        $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
}(window.jQuery),

//initializing 
    function ($) {
        "use strict";
        $.MorrisCharts.init();
    }(window.jQuery);