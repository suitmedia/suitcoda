// ------------------------- dependency -------------------------
var Horseman    = require('node-horseman'),
    horseman    = new Horseman(),
    fs          = require('fs'),
    isUrl       = require('is-url'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander');

// --------------------------- get url ---------------------------
program
.version('0.0.1')
.option('-url, --url [url]', 'input url')
.option('-d, --destination [path]', 'input path to store the output')
.parse(process.argv);

var url     = program.url;
var dest    = '';
    dest    = program.destination;

if ( ! dest ){
    dest = '';
}

if ( !isUrl(url) ){
    console.log('ERROR: this is not an url');
    horseman.close();
    process.exit(1);
}

// ---------------------- initialization ----------------------
var resultHTMLLinter = {
    name    : 'HTML Linter',
    url     : url,
    checking: []
};

// ---------------------- w3 html validator ----------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'HTML Validator by W3',
        class       : 'Code Quality',
        messages    : []
    }
);

var openW3 = horseman
    .open( 'http://validator.w3.org/check?uri=' + url );

var isHtml5 = horseman 
    .exists('.error');

var isHtml4 = horseman
    .exists('.msg_err');

if ( isHtml5 ){
    var w3ResultError = horseman
        .evaluate( function (selector) {
            
            var $results    = $(selector);
            var $errors     = $results.find('.error');
            var $warnings   = $results.find('.info.warning');

            var errors_msg      = [],
                errors_line     = [],
                errors_code     = [];

            $.each($errors, function(index, elem) {
                errors_msg.push( $(elem).find('p:first-child span').text() );
                errors_line.push( $(elem).find('.location .first-line').text() );
                errors_code.push( $(elem).find('.extract').text() );
            });

            return {
                errorMsg  : errors_msg,
                errorLine : errors_line,
                errorCode : errors_code
            };

        } , '#results' );

    var w3ResultWarning = horseman
        .evaluate( function (selector) {
            
            var $results    = $(selector);
            var $errors     = $results.find('.error');
            var $warnings   = $results.find('.info.warning');

            var warnings_msg    = [],
                warnings_line   = [],
                warnings_code   = [];

            $.each($warnings, function(index, elem) {
                warnings_msg.push( $(elem).find('p:first-child span').text() );
                warnings_line.push( $(elem).find('.location .first-line').text() );
                warnings_code.push( $(elem).find('.extract').text() );
            });

            return {
                warningMsg  : warnings_msg,
                warningLine : warnings_line,
                warningCode : warnings_code
            };

        } , '#results' );

    for ( var i = 0; i < w3ResultError.errorMsg.length; i++ ) {
        resultHTMLLinter.checking[0].messages.push({
            type    : 'Error',
            desc    : w3ResultError.errorMsg[i],
            line    : w3ResultError.errorLine[i],
            code    : w3ResultError.errorCode[i]
        });
    }

    for ( var i = 0; i < w3ResultWarning.warningMsg.length; i++ ) {
        resultHTMLLinter.checking[0].messages.push({
            type    : 'Warning',
            desc    : w3ResultWarning.warningMsg[i],
            line    : w3ResultWarning.warningLine[i],
            code    : w3ResultWarning.warningCode[i]
        });
    }

} else if ( isHtml4 ) {
    var w3ResultError = horseman
        .evaluate( function (selector) {
            
            var $results    = $(selector);
            var $errors     = $results.find('.msg_err');
            var $warnings   = $results.find('.msg_warn');

            var errors_msg       = [],
                errors_line      = [],
                errors_code      = [];

            $.each($errors, function(index, elem) {
                errors_msg.push( $(elem).find('.msg').text() );
                errors_line.push( $(elem).find('em').text() );
            });

            return {
                errorMsg  : errors_msg,
                errorLine : errors_line
            };

        } , '#result' );

    var w3ResultWarning = horseman
        .evaluate( function (selector) {
            
            var $results    = $(selector);
            var $errors     = $results.find('.msg_err');
            var $warnings   = $results.find('.msg_warn');

            var warnings_msg     = [],
                warnings_line    = [],
                warnings_code    = [];

            $.each($warnings, function(index, elem) {
                warnings_msg.push( $(elem).find('.msg').text() );
                warnings_line.push( $(elem).find('em').text() );
            });

            return {
                warningMsg  : warnings_msg,
                warningLine : warnings_line
            };

        } , '#result' );

    for ( var i = 0; i < w3ResultError.errorMsg.length; i++ ) {
        resultHTMLLinter.checking[0].messages.push({
            type    : 'Error',
            desc    : w3ResultError.errorMsg[i],
            line    : w3ResultError.errorLine[i]
        });
    }

    for ( var i = 0; i < w3ResultWarning.warningMsg.length; i++ ) {
        resultHTMLLinter.checking[0].messages.push({
            type    : 'Warning',
            desc    : w3ResultWarning.warningMsg[i],
            line    : w3ResultWarning.warningLine[i]
        });
    }
} 

    

// ----------------------- Title tag checking -----------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Title Tag Checking',
        class       : 'SEO',
        messages    : []
    }
);

var isTitle = horseman
    .open( url )
    .exists( 'title' );

if ( isTitle ) {

    var getTitle = horseman
        .title();

    var getTitleLength = horseman
        .count('title');

    var getTitleHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, 'title');

    resultHTMLLinter.checking[1].messages.push(
        {
            titleTagCount   : getTitleLength,
            titleTag        : getTitle,
            titleTagHtml    : getTitleHtml
        }
    );
} else {
    resultHTMLLinter.checking[1].messages.push(
        {
            titleTagLength  : 0,
            titleTag        : 'Title Tag is not specified',
            titleTagHtml    : 'Title Tag is not specified'
        }
    );
}

// ----------------------- header tag checking -----------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Header Tag Checking',
        class       : 'SEO',
        messages    : []
    }
);

var isHeader = horseman
    .exists( 'header' );

if ( isHeader ) {

    var getHeaderLength = horseman
        .count('header');

    var getHeaderHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, 'header');

    resultHTMLLinter.checking[2].messages.push(
        {
            headerTagCount  : getHeaderLength,
            headerTagHtml   : getHeaderHtml
        }
    );
} else {
    resultHTMLLinter.checking[2].messages.push(
        {
            headerTagCount  : 0,
            headerTagHtml   : 'Header Tag is not specified'
        }
    );
}

// ---------------------- footer tag checking ----------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Footer Tag Checking',
        class       : 'SEO',
        messages    : []
    }
);

var isFooter = horseman
    .exists( 'footer' );

if ( isFooter ) {

    var getFooterLength = horseman
        .count('footer');

    var getFooterHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, 'footer');

    resultHTMLLinter.checking[3].messages.push(
        {
            footerTagCount  : getFooterLength,
            footerTagHtml   : getFooterHtml
        }
    );
} else {
    resultHTMLLinter.checking[3].messages.push(
        {
            footerTagCount  : 0,
            footerTagHtml   : 'Footer tag is not specified'
        }
    );
}

// ----------------------- script tag checking -----------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Script Tag Checking',
        class       : 'SEO',
        messages    : []
    }
);

var isScript = horseman
    .exists( 'script' );

if ( isScript ){
    var getScriptLength = horseman
        .count('script');

    var getScriptHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, 'script');

    resultHTMLLinter.checking[4].messages.push(
        {
            scriptTagCount : getScriptLength,
            scriptTagHtml  : getScriptHtml 
        }
    );
} else {
    resultHTMLLinter.checking[4].messages.push(
        {
            scriptTagCount : 0,
            scriptTagHtml  : 'Script Tag is not specified' 
        }
    );
}

// ----------------------------- favicon -----------------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Favicon Checking',
        class       : 'SEO',
        messages    : []
    }
);

var isFavicon = horseman
    .exists('link[rel*="icon"]');

if ( isFavicon ){
    var getFaviconLength = horseman
        .count('link[rel*="icon"]');

    var getFaviconHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, 'link[rel*="icon"]');

    resultHTMLLinter.checking[5].messages.push({
        faviconCount    : getFaviconLength,
        faviconHtml     : getFaviconHtml
    });
} else {
    resultHTMLLinter.checking[5].messages.push({
        faviconCount    : 0,
        faviconHtml     : 'Favicon is not specified'
    });
}

// -------------------------- ARIA Landmark --------------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'ARIA Landmark Checking',
        class       : 'SEO',
        messages    : []
    }
);

resultHTMLLinter.checking[6].messages.push({
    ariaExist       : [],
    ariaNotExist    : []
});

var arr_role        = ['banner', 'main', 'contentinfo', 'navigation', 'search'],
    arr_role_length = arr_role.length;

for (var i = arr_role_length - 1; i >= 0; i--) {
    var _current = '[role="' + arr_role[i] + '"]';

    var isExist = horseman
        .exists(_current);

    if ( isExist ){
        var getAriaHtml = horseman
            .evaluate(function (selector) {
                var selector = document.querySelectorAll(selector);
                var tempp = [];
                for (var i = 0; i < selector.length; i++) {
                    tempp.push(selector[i].outerHTML);
                };

                return tempp;

            }, _current);

        resultHTMLLinter.checking[6].messages[0].ariaExist.push({
            role    : arr_role[i],
            code    : getAriaHtml
         });
    } else {
        resultHTMLLinter.checking[6].messages[0].ariaNotExist.push({
            role    : arr_role[i],
            code    : 'This ARIA Landmark is not specified'
         });
    }
}

// --------------------------- image no alt ---------------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Image No Alt Checking',
        class       : 'SEO',
        messages    : []
    }
);

var imgCount = horseman
    .count('img');

var noAltTextCount = horseman
    .count('img[alt=""]');

var noAltTextHtml = horseman
    .evaluate(function (selector) {
        var selectorNoAlt = document.querySelectorAll('img[alt=""]');

        var tempp = [];
        for (var i = 0; i < selectorNoAlt.length; i++) {
            tempp.push(selectorNoAlt[i].outerHTML);
        };

        return tempp;

    }, 'img');

resultHTMLLinter.checking[7].messages.push({
    imgTagCount     : imgCount,
    noAltCount      : noAltTextCount,
    noAltHtml       : noAltTextHtml
});

// ------------------------------ i18n ------------------------------
resultHTMLLinter.checking.push(
    {
        testname    : 'Internationalization - i18n',
        class       : 'SEO',
        messages    : []
    }
);

resultHTMLLinter.checking[8].messages.push({
    htmlLang        : '',
    htmlCharset     : '',
    htmlCharsetCode : ''
});

var lang            = 'html[lang]',
    arr_charset     = ['meta[charset]', 'meta[http-equiv="Content-Type"]'],
    charsetExist    = 0,
    content;

var checkLang = horseman
    .exists(lang);

if ( checkLang ){
    var getLang = horseman
        .attribute(lang , 'lang');

    resultHTMLLinter.checking[8].messages[0].htmlLang       = getLang;
} else {
    resultHTMLLinter.checking[8].messages[0].htmlLang       = 'Language is not specified';
}

for (var i = 0; i < arr_charset.length; i++) {
    var curr = arr_charset[i];
    var isExist = horseman
        .exists(curr);

    if ( isExist ) {
        var curr_opt1   = horseman
            .attribute( curr , 'charset' );
        var curr_opt2   = horseman
            .attribute( curr , 'content' );

        var content = curr_opt1 || curr_opt2;

        var getCharsetHtml = horseman
            .evaluate(function (selector) {
                var selector = document.querySelectorAll(selector);
                var tempp = [];
                for (var i = 0; i < selector.length; i++) {
                    tempp.push(selector[i].outerHTML);
                };

                return tempp;

            }, curr );

        resultHTMLLinter.checking[8].messages[0].htmlCharset        = content;
        resultHTMLLinter.checking[8].messages[0].htmlCharsetCode    = getCharsetHtml;
        charsetExist = 1;
        break;
    }
};

if ( charsetExist === 0 ) {
    resultHTMLLinter.checking[8].messages[0].htmlCharset = 'Character encoding is not specified';
        resultHTMLLinter.checking[8].messages[0].htmlCharsetCode    = 'Character encoding is not specified';
}

// ------------------------ meta tag checking ------------------------

resultHTMLLinter.checking.push(
    {
        testname    : 'Meta Tag Checking',
        class       : 'SEO',
        messages    : []
    }
);

resultHTMLLinter.checking[9].messages.push({
    metaDesc             : '',
    metaDescHtml         : '',
    metaViewport         : '',
    metaViewportHtml     : ''
});

var meta_desc   = 'meta[name="description"]',
    meta_vp     = 'meta[name="viewport"]';

var isDesc = horseman
    .exists(meta_desc);

if ( isDesc ) {
    var getDesc = horseman
        .attribute(meta_desc , 'content');

    var getDescHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, meta_desc );

    resultHTMLLinter.checking[9].messages[0].metaDesc       = getDesc;    
    resultHTMLLinter.checking[9].messages[0].metaDescHtml   = getDescHtml;    
} else {
    resultHTMLLinter.checking[9].messages[0].metaDesc       = 'Description is not specified';    
    resultHTMLLinter.checking[9].messages[0].metaDescHtml   = 'Description is not specified';    
}

var isVp = horseman
    .exists(meta_vp);

if ( isVp ) {
    var getVp = horseman
        .attribute(meta_vp , 'content');

    var getVpHtml = horseman
        .evaluate(function (selector) {
            var selector = document.querySelectorAll(selector);
            var tempp = [];
            for (var i = 0; i < selector.length; i++) {
                tempp.push(selector[i].outerHTML);
            };

            return tempp;

        }, meta_vp );

    resultHTMLLinter.checking[9].messages[0].metaViewport       = getVp;    
    resultHTMLLinter.checking[9].messages[0].metaViewportHtml   = getVpHtml;    
} else {
    resultHTMLLinter.checking[9].messages[0].metaViewport       = 'Viewport is not specified';    
    resultHTMLLinter.checking[9].messages[0].metaViewportHtml   = 'Viewport is not specified';    
}

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultHTMLLinter);

function saveReport () {
    fs.writeFile(dest + 'resultHTML.json', toJson, function (err) {
        if (err) throw err;
    });	
};

saveReport();

horseman.close();