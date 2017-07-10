/* globals $:false */
var width = $(window).width(),
    height = $(window).height(),
    isMobile = false,
    target,
    infos = false,
    idle,
    intro = true,
    $projectsContent,
    projectsScroll,
    lastTarget = false,
    $root = '/georgiapendlebury';
$(function() {
    var app = {
        init: function() {
            $(window).resize(function(event) {
                app.sizeSet();
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
                app.placeNav();
                $('#close a').click(function(event) {
                    event.preventDefault();
                    app.goBack();
                });
                $('#intro').click(function(event) {
                    $body.removeClass('intro');
                    intro = false;
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
                    app.marqueeHover();
                    app.loadCategories();
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
                draggable: true
            });
            navWidth = 0;
            $(".slider-nav .slide").each(function(index, el) {
              navWidth += $(el).outerWidth();
            });
            $nav = $('.slider-nav').flickity({
                cellSelector: '.slide',
                imagesLoaded: true,
                asNavFor: '.slider',
                cellAlign: navWidth > width ? 'left' : 'center',
                contain: false,
                setGallerySize: false,
                accessibility: false,
                wrapAround: false,
                prevNextButtons: false,
                pageDots: false,
                draggable: true,
                freeScroll: true
            });
            $introSlider = $('.slider-intro').flickity({
                cellSelector: '.slide',
                imagesLoaded: true,
                setGallerySize: false,
                accessibility: false,
                wrapAround: true,
                prevNextButtons: false,
                pageDots: false,
                draggable: false
            });
            if ($introSlider.length > 0) {
                $introSlider.flkty = $introSlider.data('flickity');
                var changeInterval;
                var offsets = ["0%", "-20%", "20%", "-10%", "10%"];
                var zIndex = 1;
                $introSlider.on('select.flickity', function() {
                    $el = $($introSlider.flkty.selectedElement);
                    $el.addClass('overlap').css('z-index', zIndex);
                    if (zIndex > 1) {
                        $el.find('.content').css('transform', 'translateX(' + offsets[Math.floor(Math.random() * offsets.length)] + ')');
                    }
                });
                // $('[event-target="intro-change"]').hover(function() {
                //     changeInterval = setInterval(changeIntro, 500);
                // }, function() {
                //     window.clearInterval(changeInterval);
                // });
                var totalDistance = 0;
                var lastSeenAt = {
                    x: null,
                    y: null
                };
                $introSlider.mousemove(function(event) {
                    if (lastSeenAt.x) {
                        totalDistance += Math.sqrt(Math.pow(lastSeenAt.y - event.clientY, 2) + Math.pow(lastSeenAt.x - event.clientX, 2));
                        //Math.round(totalDistance);
                        console.log(totalDistance % 100);
                        if (totalDistance > 200) {
                          changeIntro();
                          totalDistance = 0;
                        }
                    }
                    lastSeenAt.x = event.clientX;
                    lastSeenAt.y = event.clientY;
                });

                function changeIntro() {
                    zIndex++;
                    $introSlider.flickity('next', true, true);
                }
            }
            if ($slider.length > 0) {
                $slider.mousemove(function(event) {
                    if (!isMobile && !infos) {
                        app.showInfos();
                        window.clearTimeout(idle);
                        idle = setTimeout(function() {
                            app.hideInfos();
                        }, 5000);
                    }
                });
                $(".overview-nav").hover(function() {
                  app.resetIdle();
                });
                $slider.addClass('play');
                $('.slider-nav img').load(function() {
                    $nav.flickity('resize');
                });
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
                        //$mouseNav.removeClass('back pause').addClass('play');
                        // For lazysizes
                        // var adjCellElems = $slider.flickity('getAdjacentCellElements', 2);
                        // $(adjCellElems).find('.lazyimg:not(".lazyloaded")').addClass('lazyload');
                    });
                    $slider.click(function(event) {
                        if (!isMobile) {
                            if ($slider.hasClass('play')) {
                                $($slider.flkty.selectedElement).find('video').get(0).play();
                                $slider.removeClass('play').addClass('pause');
                            } else if ($slider.hasClass('pause')) {
                                $($slider.flkty.selectedElement).find('video').get(0).pause();
                                $slider.removeClass('pause').addClass('play');
                            }
                        }
                    });
                }
                $slider.on('staticClick.flickity', function(event, pointer, cellElement, cellIndex) {
                    if (!cellElement) {
                        return;
                    }
                    $slider.flickity('next');
                });
            }
        },
        placeNav: function() {
            $('#site-title, .menu-item').each(function(index, el) {
                $(el).css('transform', 'translateY(' + (Math.floor(Math.random() * 80) + 10) + 'vh) translateZ(0)');
            });
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
        hideInfos: function() {
            $body.addClass('idle');
            infos = false;
        },
        showInfos: function() {
            $body.removeClass('idle');
            infos = true;
        },
        resetIdle: function() {
            app.showInfos();
            window.clearTimeout(idle);
            infos = false;
        },
        loadCategories: function() {
            $("[data-category]").click(function(event) {
                event.preventDefault();
                var id = $(this).data('category');
                var scroll = $('.category-grid[data-category="' + id + '"]').position().top;
                smoothScroll.animateScroll(scroll);
            });
            app.categoryCheckPosition();
            $(window).scroll(app.categoryCheckPosition);
        },
        categoryCheckPosition: function() {
            //$('.category').last().addClass('active');
            var currentScroll = $(window).scrollTop() + height / 2;
            $('.category-grid').each(function(index, el) {
                refElement = $(el);
                $('.category').removeClass("active");
                if (refElement.position().top <= currentScroll && refElement.position().top + refElement.height() > currentScroll) {
                    var id = refElement.data('category');
                    $('.category[data-category="' + id + '"]').addClass("active");
                } else {
                    $('.category').last().addClass("active");
                }
                //if ($el.scrollTop()) {}
            });
        },
        marqueeHover: function() {
            // $('.item-marquee').each(function(index, el) {
            //     $el = $(el);
            //     
            // });
            // Marquee3k.init({
            //     selector: '.item-marquee'
            // });
            // $('.project-item').mousemove(function(event) {
            //     $el = $(this);
            //     $el.find('.item-marquee').css('top', event.pageY - $el.offset().top - 15);
            // });
            $projectsThumbs = $('.project-image');
            $projectsThumbs.hover(function() {
                $el = $(this);
                title = "<span>" + $el.data('marquee') + "</span>";
                id = $el.data('id');
                $el.find('.item-marquee').remove();
                $el.append('<div id="marquee-' + id + '" class="item-marquee" data-speed="0.7" data-pausable="true">' + title + '</div>');
                Marquee3k.init({
                    selector: '#marquee-' + id
                });
                $el.mousemove(function(event) {
                    $el = $(this);
                    $el.find('.item-marquee').css('top', event.pageY - $el.offset().top - 15);
                });
            }, function() {
                $(this).find('.item-marquee').remove();
            });
        },
        goBack: function() {
            // if (window.history && history.length > 0 && !$body.hasClass('projects')) {
            //     window.history.go(-1);
            // } else {
            //     $('#site-title a').click();
            // }
            $('#site-title a').click();
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
                        target = $currentTarget.data('target');
                    },
                    onBefore: function(request, $container) {
                        lastTarget = $('#page-content').attr('class');
                        console.log("-1: " + lastTarget, "0: " + target);
                        if (lastTarget == "projects") {
                            projectsScroll = $(window).scrollTop();
                            console.log(projectsScroll);
                            if (!$projectsContent) {
                                $projectsContent = $('#page-content');
                            }
                        }
                        // popstate = request.url.replace(/\/$/, '').replace(window.location.origin + $root, '');
                        // console.log(popstate);
                        // if (popstate == '') {
                        //     target = 'projects';
                        // } else if (isInStr('filter:print', popstate)) {
                        //     target = 'projects print';
                        // } else if (isInStr('filter:motion', popstate)) {
                        //     target = 'projects motion';
                        // } else if (isInStr('/work/', popstate)) {
                        //     return;
                        // } else {
                        //     target = popstate.replace('/', '');
                        // }
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
                            $content = $newContent.find('#page-content');
                            newTarget = $content.attr('class');
                            $body.attr('class', newTarget);
                            if (newTarget == "projects" && $projectsContent) {
                                $target.html($projectsContent);
                            } else {
                                $target.html($content);
                            }
                            if (newTarget == "projects" && projectsScroll) {
                                $(window).scrollTop(projectsScroll);
                            }
                        }
                    },
                    onAfter: function($container, $newContent) {
                        app.loadSlider();
                        app.marqueeHover();
                        app.categoryCheckPosition();
                        app.resetIdle();
                    }
                },
                smoothState = $(container).smoothState(options).data('smoothState');
        }
    };
    app.init();
});