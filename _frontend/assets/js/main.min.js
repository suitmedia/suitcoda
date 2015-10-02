/*! [PROJECT_NAME] | Suitmedia */

;(function ( window, document, undefined ) {

    var path = {
        css: myPrefix + 'assets/css/',
        js : myPrefix + 'assets/js/vendor/'
    };

    var assets = {
        _jquery_cdn     : 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
        _jquery_local   : path.js + 'jquery.min.js',
        _fastclick      : path.js + 'fastclick.min.js',
        _highcharts     : path.js + 'highcharts.min.js',
        _sh             : path.js + 'shCore.min.js',
        _shCSS          : path.js + 'shBrushCss.min.js',
        _shJS           : path.js + 'shBrushJScript.min.js',
        _shPHP          : path.js + 'shBrushPhp.min.js',
        _sprintf        : path.js + 'sprintf.min.js',
        _bazeValidate   : path.js + 'baze.validate.min.js',
        _prism          : path.js + 'prism.min.js'
    };

    var Site = {

        init: function () {
            Site.fastClick();
            Site.enableActiveStateMobile();
            Site.WPViewportFix();
            Site.dropdownMenu();
            Site.projectTabNav();
            Site.projectChart();
            Site.progressBar();
            Site.syntaxHighlighter();
            Site.showIssueCode();
            Site.validateForm();

            window.Site = Site;
        },

        fastClick: function () {
            Modernizr.load({
                load    : assets._fastclick,
                complete: function () {
                    FastClick.attach(document.body);
                }
            });
        },

        enableActiveStateMobile: function () {
            if ( document.addEventListener ) {
                document.addEventListener('touchstart', function () {}, true);
            }
        },

        WPViewportFix: function () {
            if ( navigator.userAgent.match(/IEMobile\/10\.0/) ) {
                var style   = document.createElement("style"),
                    fix     = document.createTextNode("@-ms-viewport{width:auto!important}");

                style.appendChild(fix);
                document.getElementsByTagName('head')[0].appendChild(style);
            }
        },

        projectTabNav: function () {
            var $tab = $('.project-nav__tab a');

            if ( !$tab.length ) return;

            var $btnNewTesting = $('.btn-new-testing');

            $btnNewTesting.on('click', function() {
                closeAllTab();
                $('#newtesting').addClass('project-content--show');
            });

            $tab.on('click',function () {
                var target = $(this).attr('href');
                var $target = $(target);

                removeAllActive();
                closeAllTab();
                $(this).addClass('active');
                $target.addClass('project-content--show');
            });

            function closeAllTab () {
                var $contentTab = $('.project-content');

                for (var i = 0; i < $contentTab.length; i++) {
                    $contentTab.eq(i).removeClass('project-content--show');  
                }
            }

            function removeAllActive () {
                var $tabs = $('.project-nav__tab a');

                for (var i = 0; i < $tabs.length; i++) {
                    $tabs.eq(i).removeClass('active');
                }
            }
        },

        dropdownMenu: function () {
            var $trigger = $('.header-list>li>a');
            var $allDropdownMenu = $('.dropdown-menu');

            $trigger.on('click', function () {
                var $menu = $(this).siblings();

                if ( $menu.hasClass('dropdown-menu--show') ) {
                    closeAllDropdown();
                } else {
                    closeAllDropdown();
                    $menu.addClass('dropdown-menu--show');
                }
            });

            function closeAllDropdown () {
                $allDropdownMenu.removeClass('dropdown-menu--show');
            }
        },

        projectChart: function () {
            var $chart = $('.project-chart');

            if ( !$chart.length ) return;

            var init = function () {

                $chart.highcharts({
                    title: {
                        text: 'Project Overview of Suitcoda Testing',
                        align: 'center'
                    },
                    xAxis: {
                        categories: ['#1','#2','#3','#4','#5','#6','#7','#8','#9','#10','#11','#12']
                    },
                    yAxis: {
                        title: {
                            text: 'Percents (%)'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: '%'
                    },
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'Overall',
                        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                    }, {
                        name: 'Performance',
                        data: [0, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                    }, {
                        name: 'Code Quality',
                        data: [0, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                    }, {
                        name: 'Security',
                        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                    }, {
                        name: 'SEO',
                        data: [1.2, 2.3, 2.5, 5.4, 5.7, 5.9, 6.2, 7.1, 7.9, 9.1, 10.5, 12.3]
                    }]
                });
            };

            Modernizr.load({
                load    : assets._highcharts,
                complete: init
            });

        },

        progressBar: function () {
            var $progress = $('.progress');
            var $progressBar = $('.progress__bar');

            if ( !$progress.length ) return;

            for (var i = 0; i < $progress.length; i++) {
                var progressValue = $progress.eq(i).attr('data-percent');
                $progressBar.eq(i).css('width', progressValue+'%');
            }
        },

        syntaxHighlighter: function () {
            var $issue = $('pre');

            if ( !$issue.length ) return;

            var init = function () {
                Prism.highlightAll();
            };

            Modernizr.load(
                {
                    load    : assets._prism,
                    complete: init
                }
            );

        },

        showIssueCode: function () {
            var $trigger = $('.btn-show-code');

            if ( !$trigger.length ) return; 

            $trigger.on('click', function() {
                var $issueCode = $(this).next();

                $(this).toggleClass('btn-show-code--show');
                $issueCode.toggleClass('issue__code--show');
            });
        },

        validateForm: function () {
            var $formToValidate = $( "form[data-validate]" );

            if ( !$formToValidate.length ) return;

            var init = function () {
                $formToValidate.bazeValidate();
            };

            Modernizr.load([
                {
                    load    : assets._sprintf,
                },
                {
                    load    : assets._bazeValidate,
                    complete: init
                }
            ]);

        }

    };

    var checkJquery = function () {
        Modernizr.load([
            {
                test    : window.jQuery,
                nope    : assets._jquery_local,
                complete: Site.init
            }
        ]);
    };

    Modernizr.load(
    {
        load    : assets._jquery_cdn,
        complete: checkJquery
    });

})( window, document );
