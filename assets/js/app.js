/* globals $:false */
var width = $(window).width(),
    height = $(window).height(),
    isMobile = false,
    target,
    $mouseNav,
    lastTarget = false,
    $root = '/georgiapendlebury';
$(function() {
    var app = {
        init: function() {
            $(window).resize(function(event) {
                app.sizeSet();
                app.projectFitCuts();
            });
            $(document).ready(function($) {
                app.sizeSet();
                $body = $('body');
                $container = $('#container');
                $header = $('header');
                app.smoothState('#main', $container);
                app.loadSlider();
                $(document).keyup(function(e) {
                    //esc
                    if (e.keyCode === 27) app.goBack();
                });
                app.mouseNav();
                app.categoryHover($('.project-item'));
                $('#close a').click(function(event) {
                    event.preventDefault();
                    app.goBack();
                });
                $('#intro').click(function(event) {
                    $(this).remove();
                    setTimeout(function() {
                        $header.addClass('reducting');
                        setTimeout(function() {
                            $header.removeClass('reducting').addClass('reduced');
                        }, 500);
                    }, 2000);
                });
                // $('.project-item.print img').load(function(el) {
                //     console.log('go');
                //     $el = $(el);
                //     h = $el.height();
                //     $el.next('.item-infos.left').width(h);
                //     $el.next('.item-infos.right').width(h);
                // });
                $(window).load(function() {
                    $(".loader").hide();
                    Marquee3k.init({
                        selector: 'item-marquee'
                    });
                    app.marqueeHover();
                    app.projectFitCuts();
                });
            });
        },
        sizeSet: function() {
            width = $(window).width();
            height = $(window).height();
            if (width <= 770 || Modernizr.touch) isMobile = true;
            if (isMobile) {
                if (width >= 770) {
                    //location.reload();
                    isMobile = false;
                }
            }
        },
        projectFitCuts: function($items) {
            if (!$items) {
                $items = $('.project-item.print');
            } else {
                $items.filter('.print');
            }
            $items.each(function(index, el) {
                $el = $(el);
                h = $el.find('img').height();
                $el.find('.item-infos.left').width(h);
                $el.find('.item-infos.right').width(h);
            });
        },
        loadSlider: function() {
            $mouseNav = $('#mouse-nav');
            $slider = false;
            $slider = $('.slider').flickity({
                cellSelector: '.slide',
                imagesLoaded: true,
                lazyLoad: 2,
                setGallerySize: false,
                accessibility: true,
                wrapAround: true,
                prevNextButtons: !isMobile,
                pageDots: false,
                draggable: isMobile,
                dragThreshold: 40
            });
            if ($slider.length > 0) {
                var vids = $("video");
                $.each(vids, function() {
                    this.controls = false;
                });
                $slider.flkty = $slider.data('flickity');
                $slider.count = $slider.flkty.slides.length;
                //$slider.first('.slide').find('.lazyimg:not(".lazyloaded")').addClass('lazyload');
                if ($slider.flkty && vids.length > 0) {
                    $slider.on('select.flickity', function() {
                        $.each(vids, function() {
                            this.pause();
                        });
                        $mouseNav.removeClass('back pause').addClass('play');
                        // For lazysizes
                        // var adjCellElems = $slider.flickity('getAdjacentCellElements', 2);
                        // $(adjCellElems).find('.lazyimg:not(".lazyloaded")').addClass('lazyload');
                    });
                }
                // $slider.on('staticClick.flickity', function(event, pointer, cellElement, cellIndex) {
                //     if (!cellElement || !isMobile) {
                //         return;
                //     }
                //     if (!isMobile && $mouseNav.hasClass('middle')) {
                //       console.log('ok');
                //       app.goBack();
                //     }
                // });
                $slider.click(function(event) {
                    if (!isMobile) {
                        if ($mouseNav.hasClass('back') && $mouseNav.hasClass('middle')) {
                            app.goBack();
                        } else if ($mouseNav.hasClass('play') && $mouseNav.hasClass('middle')) {
                            $($slider.flkty.selectedElement).find('video').get(0).play();
                            $mouseNav.removeClass('play').addClass('pause');
                        } else if ($mouseNav.hasClass('pause') && $mouseNav.hasClass('middle')) {
                            $($slider.flkty.selectedElement).find('video').get(0).pause();
                            $mouseNav.removeClass('pause').addClass('play');
                        }
                    }
                });
            }
        },
        mouseNav: function() {
            $container.mousemove(function(event) {
                var x = event.pageX;
                var y = event.pageY;
                if (x > width * 3 / 4) {
                    $mouseNav.removeClass('left middle').addClass('right');
                } else if (x < width / 4) {
                    $mouseNav.removeClass('middle right').addClass('left');
                } else {
                    $mouseNav.removeClass('left right').addClass('middle');
                }
                $mouseNav.css({
                    top: y,
                    left: x
                });
            });
        },
        categoryHover: function($items) {
            $items.hover(function() {}, function() {});
        },
        marqueeHover: function() {
            $('.project-item').mousemove(function(event) {
                $el = $(this);
                $el.find('.item-marquee').css('top', event.pageY - $el.offset().top - 15);
            });
        },
        goBack: function() {
            // if (window.history && history.length > 0 && !$body.hasClass('projects')) {
            //     window.history.go(-1);
            // } else {
            //     $('#site-title a').click();
            // }
            if (lastTarget == 'projects print') {
                $('.category.c-print a').click();
            } else if (lastTarget == 'projects motion') {
                $('.category.c-motion a').click();
            } else {
                $('#site-title a').click();
            }
        },
        smoothState: function(container, $target) {
            var options = {
                    debug: true,
                    scroll: false,
                    anchors: '[data-target]',
                    loadingClass: 'is-loading',
                    prefetch: true,
                    cacheLength: 2,
                    onAction: function($currentTarget, $container) {
                        lastTarget = target;
                        target = $currentTarget.data('target');
                        console.log(lastTarget);
                    },
                    onBefore: function(request, $container) {
                        popstate = request.url.replace(/\/$/, '').replace(window.location.origin + $root, '');
                        console.log(popstate);
                        if (popstate == '') {
                            target = 'projects';
                        } else if (isInStr('filter:print', popstate)) {
                            target = 'projects print';
                        } else if (isInStr('filter:motion', popstate)) {
                            target = 'projects motion';
                        } else if (isInStr('/work/', popstate)) {
                            return;
                        } else {
                            target = popstate.replace('/', '');
                        }
                    },
                    onStart: {
                        duration: 0, // Duration of our animation
                        render: function($container) {
                            // Add your CSS animation reversing class
                            $('.category').removeClass('active');
                            $body.attr('class', target);
                        }
                    },
                    onReady: {
                        duration: 0,
                        render: function($container, $newContent) {
                            // Remove your CSS animation reversing class
                            // Inject the new content
                            $(window).scrollTop(0);
                            $target.html($newContent.find('#page-content'));
                        }
                    },
                    onAfter: function($container, $newContent) {
                        app.loadSlider();
                        app.categoryHover($('.project-item'));
                        app.mouseNav();
                        app.projectFitCuts();
                    }
                },
                smoothState = $(container).smoothState(options).data('smoothState');
        }
    };
    app.init();
});

function isInStr(needle, str) {
    return str.indexOf(needle) !== -1;
}