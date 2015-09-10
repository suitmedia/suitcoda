// ---------------------- dependency ----------------------
var Horseman    = require('node-horseman'),
    horseman    = new Horseman(),
    isUrl       = require('is-url'),
    fs          = require('fs'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander');

// ------------------------ get URL ------------------------
program
.version('0.0.1')
.option('-url, --url [url]', 'input url')
.parse(process.argv);

var url = program.url;

// validation url
if ( !isUrl(url) ){
    console.log('ERROR: this is not an url');
    horseman.close();
}

// -------------------- initialization --------------------
var resultSocmed = {
    name    : 'Social Media',
    url     : url,
    checking: []
}

// ------------------- checking meta tag -------------------
var openPage = horseman
    .open( url );

var socmedName      = ['Opengraph', 'Twitter Cards', 'Facebook Insight'];
var socmedSelector  = ['meta[property*="og"]', 'meta[name*="twitter"]', 'meta[property*="fb"]'];

for (var i = 0; i < socmedSelector.length; i++) {
    var isExist = horseman
        .exists(socmedSelector[i]);
    
    var getCode;

    if ( isExist ){
        getCode = horseman
            .evaluate(function (selector) {
                var selector = document.querySelectorAll(selector);
                var tempp = [];

                for (var i = 0; i < selector.length; i++) {
                    tempp.push(selector[i].outerHTML);
                };

                return tempp;
            }, socmedSelector[i] );
    } else {
        getCode = 'This meta tag does not exist';
    }

    resultSocmed.checking.push({
        socmedName : socmedName[i],
        isExist    : isExist,
        code       : getCode
    });
};

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultSocmed);

function saveReport () {
    fs.writeFile('resultSocmed.json', toJson, function (err) {
        if (err) throw err;
    }); 
};

saveReport();

horseman.close();
