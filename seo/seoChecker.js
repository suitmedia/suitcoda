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
.option('-u, --url [url]', 'Input URL')
.option('-d, --destination [path]', 'Input Path to Store The Output')
.option('--title',      'Include Title Tag Checker')
.option('--header',     'Include Header Tag Checker')
.option('--footer',     'Include Footer Tag Checker')
.option('--favicon',    'Include Favicon Checker')
.option('--aria',       'Include ARIA Landmark Checker')
.option('--noalt',      'Include No Alternate Text on Image Tag Checker')
.option('--i18n',       'Include Internationalization (i18n) Checker')
.option('--meta',       'Include Necessary Meta Tag Checker')
.option('--heading',    'Include Heading Tag Checker')
.parse(process.argv);

var url     = program.url;
var dest    = '';
    dest    = program.destination;

if ( !dest ) {
    dest = '';
}

if ( !isUrl(url) ) {
    console.log('ERROR: this is not an url');
    horseman.close();
    process.exit(1);
}

// ---------------------- initialization ----------------------
var resultSEO = {
    name    : 'SEO Checker',
    url     : url,
    checking: []
};

var error   = 'Error',
    warning = 'Warning',
    errDesc,
    counter = 0;

var openUrl = horseman.open(url);

// ----------------------- Title tag checking -----------------------
if ( program.title ) {
    var countTitle = horseman.count( 'title' );

    if ( countTitle === 0 ) {
        errDesc = 'Title Tag is not found. Please add Title Tag to keep the standarization.';
        pushErrMsg(errDesc);
    } else if ( countTitle > 1 ) {
        errDesc = 'We have found ' + countTitle + ' Title Tags. Title Tag should only be one.';
        pushErrMsg(errDesc);
    }

    counter++;
}

// ----------------------- header tag checking -----------------------
if ( program.header ) {
    var countHeader = horseman.count( 'header' );

    if ( countHeader === 0 ) {
        errDesc = 'Header Tag is not found. Please add Header Tag to keep the standarization.';
        pushErrMsg(errDesc);
    }

    counter++;
}

// ---------------------- footer tag checking ----------------------
if ( program.footer ) {
    var countFooter = horseman.count( 'footer' );

    if ( countFooter === 0 ) {
        errDesc = 'Footer Tag is not found. Please add Footer Tag to keep the standarization.';
        pushErrMsg(errDesc);
    }

    counter++;
}

// ----------------------------- favicon -----------------------------
if ( program.favicon ) {
    var countFavicon = horseman.count('link[rel*="icon"]');

    if ( countFavicon === 0 ) {
        errDesc = 'Favicon is not found. Please add <link rel="icon" type="image/png" href="path/to/your/file"></link> to keep the standarization.';
        pushErrMsg(errDesc);
    }

    counter++;
}

// -------------------------- ARIA Landmark --------------------------
if ( program.aria ) {
    var arr_role        = ['banner', 'main', 'contentinfo', 'navigation', 'search'];

    for (var i = 0; i < arr_role.length; i++) {
        var _current = '[role="' + arr_role[i] + '"]';

        var isExist = horseman.exists(_current);

        if ( !isExist ) {
            errDesc = 'This Aria Landmark : '+ arr_role[i] +' is not found. Please add ' + _current + ' to this page to keep the standarization.';
            pushWarnMsg(errDesc);
        }

        counter++;
    }
}

// --------------------------- image no alt ---------------------------
if ( program.noalt ) {
    var imgCount = horseman
        .count('img');

    var noAltTextCount = horseman
        .count('img[alt=""]');

    if ( noAltTextCount > 0 ) {
        var noAltTextCode = horseman
            .evaluate(function (selector) {
                var selectorNoAlt = document.querySelectorAll('img[alt=""]');

                var tempp = [];
                for (var i = 0; i < selectorNoAlt.length; i++) {
                    tempp.push(selectorNoAlt[i].outerHTML);
                }

                return tempp;
            }, 'img');
        
        for (var i = 0; i < noAltTextCode.length; i++) {
            errDesc = 'This Image Tag ' + noAltTextCode[i] + ' has no Alternate Text. Please add the alternate text to keep the standarization.';
            pushErrMsg(errDesc);
        }
    }
    
    counter = counter + imgCount;
}

// ------------------------------ i18n ------------------------------
if ( program.i18n ) {
    
    var isLang = horseman.exists('html[lang]');

    if ( isLang ) {
        var getLang = horseman.attribute('html','lang');
        if ( getLang === "" ) {
            errDesc = 'Please fill the Lang attribute to keep the standarization.';
            pushErrMsg(errDesc);
        }
        counter++;
    } else {
        errDesc = 'Language attribute is not found. Please add <html lang=""> to keep the standarization.';
        pushErrMsg(errDesc);
    }
    counter++;

    var isHttpEquiv = horseman.exists('meta[http-equiv]');
    var isCharset = horseman.exists('meta[charset]');
    var getHttpEquiv = getLowerCase( horseman.attribute('meta[http-equiv]','http-equiv') );
    var getCharset = getLowerCase( horseman.attribute('meta[charset]','charset') );

    if ( !isHttpEquiv && !isCharset ) {
        errDesc = 'Please add character encoding meta tag element (<meta charset="utf-8"/> or <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>)';
        pushErrMsg(errDesc);
    } else {
        if ( getHttpEquiv === "content-type" && getCharset === "utf-8" ) {
            errDesc = 'Please do not declare both of character encoding element (<meta charset="utf-8"/> and <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>).';
            pushErrMsg(errDesc);
        } else {
            if ( isCharset ) {
                if ( getCharset === "" || getCharset === null ) {
                    errDesc = 'Please fill the charset attribute on meta tag.';
                    pushErrMsg(errDesc);
                } else if ( getCharset !== "utf-8" ) {
                    errDesc = 'Please only use "utf-8" for charset attribute on meta tag.';
                    pushErrMsg(errDesc);
                }
            } else if ( isHttpEquiv ) {
                if ( getHttpEquiv === '' || getHttpEquiv === null ) {
                    errDesc = 'Please fill the http-equiv attribute on meta tag.';
                    pushErrMsg(errDesc);
                } else if ( getHttpEquiv !== 'content-type' ) {
                    errDesc = 'Http-equiv attribute on meta tag is wrong. Please change it to <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> to keep the standarization.';
                    pushErrMsg(errDesc);  
                }
            } 
        }
    } 

    counter++;
}


// ------------------------ meta tag checking ------------------------
if ( program.meta ) {
    var metaDesc   = 'meta[name="description"]',
        metaVp     = 'meta[name="viewport"]';

    var isMetaDesc = horseman.exists(metaDesc);
    if ( isMetaDesc ) {
        var getMetaDesc = horseman.attribute('meta[name="description"]', 'content');
        if ( getMetaDesc === "" ) {
            errDesc = "Meta Description tag must be filled.";
            pushErrMsg(errDesc);
        }
        counter++;
    } else {
        errDesc = "Please add Meta Description tag to keep the standarization.";
        pushErrMsg(errDesc);
    }
    counter++;

    var isMetaVp = horseman.exists(metaVp);
    if ( isMetaVp ) {
        var getMetaVp = horseman.attribute('meta[name="viewport"]', 'content');
        if ( getMetaVp === "" ) {
            errDesc = "Meta Viewport tag must be filled";
            pushErrMsg(errDesc);
        }
        counter++;
    } else {
        errDesc = "Please add Meta Viewport tag to keep the standarization.";
        pushErrMsg(errDesc);
    }
    counter++;
}

// ----------------------------- heading -----------------------------
if ( program.heading ) {
    var isMainHeading = horseman.exists('h1');

    if ( isMainHeading ) {
        var countMainHeading = horseman.count('h1');

        if ( countMainHeading > 1 ) {
            errDesc = 'Tag <h1> should only be one.';
            pushWarnMsg(errDesc);
        }
    } else {
        errDesc = 'Tag <h1> is not found. Please add tag <h1></hi> to keep the standarization.';
        pushErrMsg(errDesc);
    }
    counter++;
}

// ------------------------ save to json file ------------------------
resultSEO.counter = counter;
var toJson = jsonPretty(resultSEO);

function saveReport() {
    fs.writeFile(dest + 'resultSEO.json', toJson, function (err) {
        if (err) throw err;
        console.log("resultSEO.json has saved!");
    }); 
}

saveReport();

// ---------------------------- function ----------------------------
function pushErrMsg(message) {
    resultSEO.checking.push({
        error   : error,
        desc    : message
    });
}

function pushWarnMsg(message) {
    resultSEO.checking.push({
        error   : warning,
        desc    : message
    });
}

function getLowerCase (message) {
    if ( message === "" || message === null ) {
        return message;
    } else {
        return message.toLowerCase();
    }
}

horseman.close();