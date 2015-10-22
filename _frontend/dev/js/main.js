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
            Site.deleteWarn();

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

            var $btnNewTesting  = $('.btn-new-testing'),
                $contentTab     = $('.project-content');

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
                $contentTab.removeClass('project-content--show');  
            }

            function removeAllActive () {
                $tab.removeClass('active');
            }
        },

        dropdownMenu: function () {
            var $trigger = $('.header-list>li>a');
            var $allDropdownMenu = $('.dropdown-menu');
            var $body = $('body');

            $trigger.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $menu = $(this).siblings();

                if ( $menu.hasClass('dropdown-menu--show') ) {
                    closeAllDropdown();
                } else {
                    closeAllDropdown();
                    $menu.addClass('dropdown-menu--show');
                }
            });

            $body.on('click', function(e) {
                var $target = $(e.target);

                if ( !$target.parents().hasClass('notif') && !$target.parents().hasClass('user-avatar') && !$target.parents().hasClass('dropdown-menu')  ) {
                    closeAllDropdown();
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

                function drawGraph ( graph, dataTitle, dataSeries, dataXAxis) {
                    var option = {
                        title: {
                            text: dataTitle,
                            align: 'center'
                        },
                        credits: {
                            enabled : false
                        },
                        xAxis: {
                            categories: dataXAxis
                        },
                        yAxis: {
                            title: {
                                text: 'Percents (%)'
                            }
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
                        series: dataSeries
                    };

                    graph.highcharts( option );
                }

                var getGraphData = function () {

                    $.each($chart, function(index, val) {
                        var $this = $(this),
                            dataSource = $this.attr('data-graph'),
                            dataTitle,
                            dataSeries,
                            dataXAxis;

                        $.ajax({
                            url: dataSource,
                            type: 'GET',
                            dataType: 'json'
                        })
                        .done(function(data) {
                            dataTitle = data.title;
                            dataSeries = data.series;
                            dataXAxis = data.xAxis;

                            $chart.addClass('project-chart--done');
                            drawGraph($this, dataTitle, dataSeries, dataXAxis);
                        })
                        .fail(function() {})
                        .always(function() {});
                    });
                };

                getGraphData();
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

        },

        deleteWarn: function () {
            var $trigger = $('.box__close');

            $trigger.on('click', function(e) {
                if ( !window.confirm('Do you want to delete this account?') ) {
                    e.preventDefault();
                }
            });
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
