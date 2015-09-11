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
    .option('-d, --destination [path]', 'input path to store the output')
    .parse(process.argv);

var url     = program.url;
var dest    = program.destination;

if ( !dest ){
    dest = '';
}

// validation url
if ( !isUrl(url) ){
    console.log('ERROR: this is not an url');
    horseman.close();
    process.exit(1);
}

// -------------------- initialization --------------------
var resultSocmed = {
    name    : 'Social Media',
    url     : url,
    checking: []
};

// ------------------- checking meta tag -------------------
var openPage = horseman.open( url );

var socmedName      = ['Opengraph', 'Twitter Cards', 'Facebook Insight'];
var socmedSelector  = ['meta[property*="og"]', 'meta[name*="twitter"]', 'meta[property*="fb"]'];

socmedSelector.forEach(function (value, index) {
    var isExist = horseman.exists(value);
    
    var getCode;

    if ( isExist ){
        getCode = horseman.evaluate(function (selector) {
            var result = document.querySelectorAll(selector);
            var tempp = [];

            for (var i = 0; i < result.length; i++) {
                tempp.push(result[i].outerHTML);
            }

            return tempp;
        }, value );
    } else {
        getCode = 'This meta tag does not exist';
    }

    resultSocmed.checking.push({
        socmedName : socmedName[index],
        isExist    : isExist,
        code       : getCode
    });
});

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultSocmed);

function saveReport () {
    fs.writeFile(dest + 'resultSocmed.json', toJson, function (err) {
        if (err) throw err;
    }); 
}

saveReport();

horseman.close();
