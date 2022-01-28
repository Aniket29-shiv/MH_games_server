/*!
 * Copyright (c) 2017 Erik van den Berg (http://www.net-developer.nl/rotapie)
 * Licensed under MIT (http://www.opensource.org/licenses/mit-license.php) license.  
 * Version: 1.0.0
 * Dependencies: jQuery 1.4.2+
*/
(function($){

    var _renderPie = function (canvas, settings){
         
        // Resize canvas to settings' max radius * 2.
        var canvasSize = 2 * settings._maxRadius;
        canvas.attr('width', canvasSize).attr('height', canvasSize);

        var context = canvas[0].getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);

        var angle = settings.angle;
        var j = settings.sliceIndex;

        // Render slices.
        for (var i = 0; i < settings.slices.length; i++)
        { 
            var endAngle = angle + settings.slices[j].radians;
            context.fillStyle = settings.slices[j].color;
            context.beginPath();
            context.arc(settings._maxRadius, settings._maxRadius, (j == settings.sliceIndex ? settings.selectedRadius : settings._minRadius), angle, endAngle);
            context.lineTo(settings._maxRadius, settings._maxRadius); // (Center canvas x,y equals settings._maxRadius)
            context.closePath();
            context.fill();
            angle = endAngle;
            j++;
            if (j >= settings.slices.length) // wrap around.
                j = 0;
        }

        // Render inner circle.
        if(settings.innerRadius > 0)
        {
            context.fillStyle = settings.innerColor;
            context.beginPath();
            context.arc(settings._maxRadius, settings._maxRadius, settings.innerRadius, 0, 2 * Math.PI);
            context.closePath();
            context.fill();
        } 
        
        // Render percentage.
        if (settings.fontSize > 0)
        {
            var slice = settings.slices[settings.sliceIndex];

            // Font color defaults to slice color if fontColor not set.
            context.fillStyle = slice.fontColor || slice.color;

            var bigFont = settings.fontWeight + ' ' + settings.fontSize + 'px ' + settings.fontFamily;
            var smallFont = settings.fontWeight + ' ' + (0.5 * settings.fontSize) + 'px ' + settings.fontFamily;

            var whole = Math.floor(settings.percentage);
            var fraction = Math.round(10 * (settings.percentage - Math.floor(settings.percentage)));

            context.textAlign = 'middle';
            context.textBaseline = 'middle';
            context.font = bigFont;
        
            if (fraction == 0)
            {
                whole += '%';
                context.fillText(whole, settings._maxRadius - 0.5 * context.measureText(whole).width, settings._maxRadius + settings._fontYOffset);
            }
            else
            {
                whole += settings.decimalPoint;
                fraction += '%';
                 
                var bigWidth = context.measureText(whole).width;
                context.font = smallFont;  
                var smallWidth = context.measureText(fraction).width;
                var x = settings._maxRadius - 0.5 * (bigWidth + smallWidth);

                context.font = bigFont; 
                context.fillText(whole, x, settings._maxRadius + settings._fontYOffset);
                context.textBaseline = 'alphabetic';
                context.font = smallFont;
                context.fillText(fraction, x + bigWidth, settings._maxRadius + settings._fontYOffset);
            }
        }
    };
     
    var _rotatePie = function (canvas, sliceIndex) {
        
        // Retrieve settings from canvas.
        var settings = canvas.data('settings');

        // Cancel if animation in progress.
        if (settings.animating) return false;

        // Callback.
        if (settings.beforeAnimate)
        { 
            var returnVal = settings.beforeAnimate.call(canvas, sliceIndex, settings);
            if (returnVal === false) return false; // If user returns false, cancel animation.
        }

        settings.animating = true; 
         
        // Calculate total angle to rotate.
        // Total angle is half of current angle + angles of all slices in between + half of end slice's angle.
        var angle = 0.5 * settings.slices[settings.sliceIndex].radians;  // Half of current angle. 
        var tempIndex = settings.sliceIndex;
        while (tempIndex != sliceIndex)
        {
            tempIndex++;
            if (tempIndex >= settings.slices.length) tempIndex = 0; // wrap sliceIndex around.
            angle +=
                    tempIndex == sliceIndex ? // end index?
                    0.5 * settings.slices[tempIndex].radians : // Half of end angle.
                    settings.slices[tempIndex].radians;
        }

        var endAngle;
        var endPercentage = settings.slices[sliceIndex].percentage;
        var deltaAngle;
        var fraction;
        var deltaRadius; // The radius difference between frames during animation (radius of selected slice is animated smaller during rotation and bigger after rotation).
        var deltaInnerRadius;
        var deltaFontSize;
        var deltaPercentage;
        var rotateClockwise = sliceIndex > settings.sliceIndex;

        if (rotateClockwise) // Rotate clockwise.
        {
            endAngle = settings.angle + (2 * Math.PI - angle);
            deltaAngle = settings.deltaAngle;
            fraction = settings.deltaAngle / (2 * Math.PI - angle);
        }
        else
        { 
            endAngle = settings.angle - angle;
            deltaAngle = -settings.deltaAngle;
            fraction = settings.deltaAngle / angle; 
        }

        deltaRadius = fraction * (settings._maxRadius - settings._minRadius);
        deltaInnerRadius = fraction * (settings._maxInnerRadius - settings._minInnerRadius);
        deltaFontSize = fraction * (settings._maxFontSize - settings._minFontSize);
        deltaPercentage = fraction * (endPercentage - settings.slices[settings.sliceIndex].percentage);
         
        var firstPart = true;
        var animatePie = function () {
             
            if (firstPart) // Rotation required.
            {
                // Animate currently selected slice from big to small while rotating. 
                settings.selectedRadius -= deltaRadius;
                if (settings.selectedRadius <= settings._minRadius)
                    settings.selectedRadius = settings._minRadius; // Cap at min radius.

                // Animate inner circle smaller.
                settings.innerRadius -= deltaInnerRadius;
                if (settings.innerRadius <= settings._minInnerRadius)
                    settings.innerRadius = settings._minInnerRadius; // Cap at min inner radius.

                // Animate fontsize smaller.
                settings.fontSize -= deltaFontSize;
                if (settings.fontSize <= settings._minFontSize)
                    settings.fontSize = settings._minFontSize; // Cap at min fontsize.

                // Animate percentage number.
                settings.percentage += deltaPercentage;
                if ((deltaPercentage > 0 && settings.percentage >= endPercentage) || (deltaPercentage < 0 && settings.percentage <= endPercentage))
                    settings.percentage = endPercentage; // Cap percentage.

                // Rotate.
                if (settings.sliceIndex != sliceIndex)
                { 
                    settings.angle += deltaAngle;
                    if (rotateClockwise && settings.angle >= endAngle || (!rotateClockwise && settings.angle <= endAngle)) // Cap angle.
                    { 
                        settings.sliceIndex = sliceIndex;
                        settings.angle = -0.5 * Math.PI - 0.5 * settings.slices[settings.sliceIndex].radians;
                    }
                }

                if (settings.selectedRadius == settings._minRadius &&
                    settings.innerRadius == settings._minInnerRadius &&
                    settings.fontSize == settings._minFontSize &&
                    settings.sliceIndex == sliceIndex &&
                    settings.percentage == endPercentage)
                {
                    firstPart = false;
                } 
            }
            else // After rotation.
            {
                // Animate currently selected slice from small to big.
                settings.selectedRadius += deltaRadius;
                if (settings.selectedRadius >= settings._maxRadius) settings.selectedRadius = settings._maxRadius; // Cap at max radius.

                // Animate inner circle bigger.
                settings.innerRadius += deltaInnerRadius;
                if (settings.innerRadius >= settings._maxInnerRadius) settings.innerRadius = settings._maxInnerRadius; // Cap at max inner radius.

                // Animate fontsize bigger.
                settings.fontSize += deltaFontSize;
                if (settings.fontSize >= settings._maxFontSize) settings.fontSize = settings._maxFontSize; // Cap at max fontsize.

                if (settings.selectedRadius == settings._maxRadius &&
                    settings.innerRadius == settings._maxInnerRadius &&
                    settings.fontSize == settings._maxFontSize) // Animation complete.
                {
                    _renderPie(canvas, settings);
                    settings.animating = false;

                    // Callback.
                    if (settings.afterAnimate)
                    {
                        settings.afterAnimate.call(canvas, settings);
                    }

                    return false; // Break animation loop.
                }
            }
            
            _renderPie(canvas, settings);
            requestAnimationFrame(function () {
                animatePie();
            }); 
        };

        requestAnimationFrame(function () {
            animatePie();
        });
    };

    var _pieClick = function (e) {
        var canvas = $(this);
        var settings = canvas.data('settings');
        var x = e.offsetX - settings._maxRadius;
        var y = -e.offsetY + settings._maxRadius;
        var alpha = Math.atan(Math.abs(y) / Math.abs(x));

        if (x > 0)
        {
            alpha = y > 0 ? (0.5 * Math.PI - alpha) : (0.5 * Math.PI + alpha); 
        }
        else
        {
            alpha = y > 0 ? (1.5 * Math.PI + alpha) : (1.5 * Math.PI - alpha);
        }

        var index = settings.sliceIndex;
        var angle = 0.5 * settings.slices[settings.sliceIndex].radians;
        while (alpha > angle)
        {
            index++;
            if (index >= settings.slices.length) index = 0; // wrap around.
            angle += settings.slices[index].radians;
        }

        _rotatePie(canvas, index);
    };
    
    // If value is percentage convert to absolute pixel value of containerWidth.
    var _getDimension = function (containerWidth, value) {
        var percentage = value.toString();
        if (percentage.substring(value.length - 1) == '%')
            return Math.round(containerWidth * parseFloat(percentage) / 100);
        else return value;
    };

    var _setDefaults = function (canvas, settings) {
 
        for (var i = 0; i < settings.slices.length; i++)
        {
            // Convert slice percentages to radians.
            settings.slices[i].radians = settings.slices[i].percentage / 100 * 2 * Math.PI;
            
            // If no color provided, set to transparant.
            if (!settings.slices[i].color)
                settings.slices[i].color = 'rgba(0, 0, 0, 0)';
        }
        
        // Convert percentage dimensions to pixel values.
        var containerWidth = canvas.parent().width();
        settings._maxRadius = _getDimension(containerWidth, settings.maxRadius);
        settings._minRadius = _getDimension(containerWidth, settings.minRadius);
        settings._maxInnerRadius = _getDimension(containerWidth, settings.maxInnerRadius);
        settings._minInnerRadius = _getDimension(containerWidth, settings.minInnerRadius); 
        settings._maxFontSize = _getDimension(containerWidth, settings.maxFontSize);
        settings._minFontSize = _getDimension(containerWidth, settings.minFontSize);
        settings._fontYOffset = _getDimension(containerWidth, settings.fontYOffset);

        settings.selectedRadius = settings._maxRadius; // Set the radius of the selected (top) slice to the maximum radius.
        settings.innerRadius = settings._maxInnerRadius; // Set the radius of the inner circle to the maximum inner radius.
        settings.fontSize = settings._maxFontSize; // Set the fontsize to the maximum font size.
        settings.percentage = settings.slices[settings.sliceIndex].percentage; // Set the current percentage to the selected slice's percentage.
        settings.angle = -0.5 * Math.PI - 0.5 * settings.slices[settings.sliceIndex].radians; // Set the start angle.
        
        // If settings.clickable a user can select a different percentage by clicking on the canvas.
        canvas.unbind();
        if (settings.clickable)
            canvas.click(_pieClick);
    }; 
      
    $.fn.rotapie = function (options) {

        var wrapped = this;

        wrapped.each(function () {

            var container = $(this);

            // Create default settings.
            var settings = $.extend({ 
                slices: [
                            { color: '#006673', percentage: 10 }, // If color not set, slice will be transparant.
                            { color: '#0294a8', percentage: 30 }, // Font color to render percentage defaults to 'color' but can be overriden by setting 'fontColor'.
                            { color: '#77ccd1', percentage: 60 }
                        ],
                sliceIndex: 0, // Start index selected slice.
                deltaAngle: 0.2, // The rotation angle in radians between frames, smaller number equals slower animation.
                minRadius: 100, // Radius of unselected slices, can be set to percentage of container width i.e. '50%'
                maxRadius: 110, // Radius of selected slice, can be set to percentage of container width i.e. '45%'
                minInnerRadius: 55, // Smallest radius inner circle when animated, set to 0 to disable inner circle, can be set to percentage of container width i.e. '35%'
                maxInnerRadius: 65, // Normal radius inner circle, set to 0 to disable inner circle, can be set to percentage of container width i.e. '30%'
                innerColor: '#fff', // Background color inner circle. 
                minFontSize: 30, // Smallest fontsize percentage when animated, set to 0 to disable percentage display, can be set to percentage of container width i.e. '20%'
                maxFontSize: 40, // Normal fontsize percentage, set to 0 to disable percentage display, can be set to percentage of container width i.e. '10%'
                fontYOffset: 0, // Vertically offset the percentage display with this value, can be set to percentage of container width i.e. '-10%'
                fontFamily: 'Times New Roman', // FontFamily percentage display.
                fontWeight: 'bold', // FontWeight percentage display.
                decimalPoint: '.', // Can be set to comma or other symbol.
                clickable: true // If set to true a user can select a different slice by clicking on it. 
            }, options || {});
 
            // Create a canvas element in container to draw pie on.
            var canvas = container.find('canvas.rotapie');
            if (canvas.length == 0)
            { 
                canvas = $('<canvas class="rotapie"></canvas>');
                canvas.appendTo(container);
            }

            // Use settings to create default start conditions.
            _setDefaults(canvas, settings);

            // Store pie settings with canvas.
            canvas.data('settings', settings);
            
            // Single global window resize event updates all pie dimensions on page for all pies that use percentages.
            $(window).unbind('resize.rotapie').bind('resize.rotapie', function (e) {
                $('canvas.rotapie').each(function () {
                    var canvas = $(this);
                    var settings = canvas.data('settings'); 
                    _setDefaults(canvas, settings);
                    _renderPie(canvas, settings);
                }); 
            });

            // Render pie. 
            _renderPie(canvas, settings); 
        }); 

        // Return public API.
        return { 
            animate: function (index, pieIndex) {
                if (pieIndex === undefined) // Animate every pie in wrapped set if pie index not specified.
                {
                    wrapped.each(function () {
                        _rotatePie($(this).find('canvas.rotapie'), index);
                    }); 
                }
                else
                { 
                    _rotatePie($(wrapped[pieIndex]).find('canvas.rotapie'), index);
                } 
            },
            repaint: function (pieIndex) {
                if (pieIndex === undefined) // Repaint every pie in wrapped set if index not specified.
                {
                    wrapped.each(function () {
                        var canvas = $(this).find('canvas.rotapie');
                        var settings = canvas.data('settings'); 
                        _setDefaults(canvas, settings); 
                        _renderPie(canvas, settings);
                    });
 
                }
                else
                {
                    var canvas = $(wrapped[pieIndex]).find('canvas.rotapie');
                    var settings = canvas.data('settings');
                    _setDefaults(canvas, settings);
                    _renderPie(canvas, settings);
                } 
            },
            getSettings: function (pieIndex) {
                if (pieIndex === undefined && wrapped.length > 1) // Return all pie settings in wrapped set if index not specified.
                {
                    var settings = [];
                    wrapped.each(function () {
                        settings.push($(this).find('canvas.rotapie').data('settings'));
                    });

                    return settings;
                }
                else
                { 
                    return wrapped.find('canvas.rotapie').data('settings'); 
                }
            }
        };
    };
})(jQuery);