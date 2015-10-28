// ---------------------- dependency ----------------------
var isUrl       = require('is-url'),
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
    process.exit(1);
}

// -------------------- initialization --------------------
var resultSocmed = {
    name    : 'Social Media',
    url     : url,
    checking: []
};

// ----------------------- Open Graph -----------------------
var opengraph = require('./opengraph.js');
resultSocmed.checking.push(opengraph(url));


// ----------------------- Open Graph -----------------------
var twittercard = require('./twittercard.js');
resultSocmed.checking.push(twittercard(url));


// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultSocmed);

function saveReport () {
    fs.writeFile(dest + 'resultSocmed.json', toJson, function (err) {
        if (err) {
            throw err;
        } else {
            console.log('resultSocmed.json has saved!');
        }
    }); 
}

saveReport();