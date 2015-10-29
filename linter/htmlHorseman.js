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

if ( !dest ) {
    dest = '';
}

if ( !isUrl(url) ) {
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
var openW3 = horseman
    .open( 'http://validator.w3.org/check?uri=' + url );

var isHtml5 = horseman 
    .exists('.error');

var isHtml4 = horseman
    .exists('.msg_err');

if ( isHtml5 ) {
    var w3ResultError = horseman
        .evaluate( function (selector) {
            
            var $results    = $(selector);
            var $errors     = $results.find('.error');
            var $warnings   = $results.find('.info.warning');

            var errors_msg      = [],
                errors_line     = [],
                errors_code     = [];

            $.each($errors, function (index, elem) {
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
        resultHTMLLinter.checking.push({
            type    : 'Error',
            desc    : w3ResultError.errorMsg[i],
            line    : w3ResultError.errorLine[i],
            code    : w3ResultError.errorCode[i]
        });
    }

    for ( var i = 0; i < w3ResultWarning.warningMsg.length; i++ ) {
        resultHTMLLinter.checking.push({
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

            $.each($errors, function (index, elem) {
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

            $.each($warnings, function (index, elem) {
                warnings_msg.push( $(elem).find('.msg').text() );
                warnings_line.push( $(elem).find('em').text() );
            });

            return {
                warningMsg  : warnings_msg,
                warningLine : warnings_line
            };

        } , '#result' );

    for ( var i = 0; i < w3ResultError.errorMsg.length; i++ ) {
        resultHTMLLinter.checking.push({
            type    : 'Error',
            desc    : w3ResultError.errorMsg[i],
            line    : w3ResultError.errorLine[i]
        });
    }

    for ( var i = 0; i < w3ResultWarning.warningMsg.length; i++ ) {
        resultHTMLLinter.checking.push({
            type    : 'Warning',
            desc    : w3ResultWarning.warningMsg[i],
            line    : w3ResultWarning.warningLine[i]
        });
    }
} 

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultHTMLLinter);

function saveReport() {
    fs.writeFile(dest + 'resultHTML.json', toJson, function (err) {
        if (err) throw err;
    });	
};

saveReport();

horseman.close();