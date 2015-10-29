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
var resultSEO = {
    name    : 'SEO Checker',
    url     : url,
    checking: []
};

var error   = 'Error',
    warning = 'Warning',
    errDesc;

var openUrl = horseman.open(url);

// ----------------------- Title tag checking -----------------------
var countTitle = horseman.count( 'title' );

if ( countTitle === 0 ) {
    errDesc = 'Title Tag is not found. Please add Title Tag to keep the standarization.';

    pushErrMsg(errDesc);
} else if ( countTitle > 1 ) {
    errDesc = 'We have found ' + countTitle + ' Title Tags. Title Tag should only be one.';
    pushErrMsg(errDesc);
}

// ----------------------- header tag checking -----------------------
var countHeader = horseman.count( 'header' );

if ( countHeader === 0 ) {
    errDesc = 'Header Tag is not found. Please add Header Tag to keep the standarization.';
    pushErrMsg(errDesc);
}

// ---------------------- footer tag checking ----------------------
var countFooter = horseman.count( 'footer' );

if ( countFooter === 0 ) {
    errDesc = 'Footer Tag is not found. Please add Footer Tag to keep the standarization.';
    pushErrMsg(errDesc);
}

// ----------------------------- favicon -----------------------------

var countFavicon = horseman.count('link[rel*="icon"]');

if ( countFavicon === 0 ) {
    errDesc = "favicon harus ada";
    pushErrMsg(errDesc);
}

// -------------------------- ARIA Landmark --------------------------
var arr_role        = ['banner', 'main', 'contentinfo', 'navigation', 'search'];

for (var i = 0; i < arr_role.length; i++) {
    var _current = '[role="' + arr_role[i] + '"]';

    var isExist = horseman.exists(_current);

    if ( !isExist ) {
        errDesc = 'This Aria Landmark : '+ arr_role[i] +' is not found. Please add ' + _current + ' to this page to keep the standarization.';
        pushWarnMsg(errDesc);
    }
}

// --------------------------- image no alt ---------------------------
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



// ------------------------------ i18n ------------------------------
var isLang = horseman.exists('html[lang]');

if ( isLang ) {
    var getLang = horseman.attribute('html','lang');
    if ( getLang === "" ) {
        errDesc = 'Please fill the Lang attribute to keep the standarization.';
        pushErrMsg(errDesc);
    }
} else {
    errDesc = 'Language attribute is not found. Please add <html lang=""> to keep the standarization.';
    pushErrMsg(errDesc);
}

var isHttpEquiv = horseman.exists('meta[http-equiv]');
var isCharset = horseman.exists('meta[charset]');
var getHttpEquiv = horseman.attribute('meta[http-equiv]','http-equiv');
var getCharset = horseman.attribute('meta[charset]','charset');

if ( getHttpEquiv === "Content-Type" && ( getCharset === "utf-8" || getCharset === "UTF-8") ) {
    errDesc = 'Please do not declare both of character encoding element (<meta charset="utf-8"/> and <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>).';
    pushErrMsg(errDesc);
} else {
    if ( isCharset ) {
        if ( getCharset === "" ) {
            errDesc = 'Please fill the charset attribute on meta tag.';
            pushErrMsg(errDesc);
        } else if ( getCharset !== "utf-8" && getCharset !== "UTF-8" ) {
            errDesc = 'Please only use "utf-8" for charset attribute on meta tag.';
            pushErrMsg(errDesc);
        } 
    } else {
        if ( getHttpEquiv === '' ) {
            errDesc = 'Please fill the http-equiv attribute on meta tag.';
            pushErrMsg(errDesc);
        } else if ( getHttpEquiv !== 'Content-Type' ) {
            errDesc = 'Http-equiv attribute on meta tag is wrong. Please change it to <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> to keep the standarization.';
            pushErrMsg(errDesc);  
        } else {
            errDesc = 'Character encoding declaration is not found. Please add <meta charset="utf-8"/> or <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> to keep the standarization.';
            pushErrMsg(errDesc);
        }
    } 

}



// ------------------------ meta tag checking ------------------------


var metaDesc   = 'meta[name="description"]',
    metaVp     = 'meta[name="viewport"]';

var isMetaDesc = horseman.exists(metaDesc);
if ( isMetaDesc ) {
    var getMetaDesc = horseman.attribute('meta[name="description"]', 'content');
    if ( getMetaDesc === "" ) {
        errDesc = "Meta Description tag must be filled.";
        pushErrMsg(errDesc);
    }
} else {
    errDesc = "Please add Meta Description tag to keep the standarization.";
}

var isMetaVp = horseman.exists(metaVp);
if ( isMetaVp ) {
    var getMetaVp = horseman.attribute('meta[name="viewport"]', 'content');
    if ( getMetaVp === "" ) {
        errDesc = "Meta Viewport tag must be filled";
        pushErrMsg(errDesc);
    }
} else {
    errDesc = "Please add Meta Viewport tag to keep the standarization.";
    pushErrMsg(errDesc);
}

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultSEO);

function saveReport () {
    fs.writeFile(dest + 'resultSEO.json', toJson, function (err) {
        if (err) throw err;
        console.log("resultSEO.json has saved!");
    }); 
}

saveReport();

// ---------------------------- function ----------------------------
function pushErrMsg (message) {
    resultSEO.checking.push({
        error   : error,
        desc    : message
    });
}

function pushWarnMsg (message) {
    resultSEO.checking.push({
        error   : warning,
        desc    : message
    });
}

horseman.close();