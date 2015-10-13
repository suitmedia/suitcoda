<!doctype html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    @include('_include.head')
    <body>
        <div class="site">
            @yield('header')
            @yield('main-content')
            @include('_include.footer')
        </div>
        @include('_include.script')
    </body>
</html>