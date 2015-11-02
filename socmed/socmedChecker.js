// ---------------------- dependency ----------------------
var isUrl       = require('is-url'),
    fs          = require('fs'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander');

// ------------------------ get URL ------------------------
program
.version('0.0.1')
.option('-u, --url [url]', 'input url')
.option('-d, --destination [path]', 'input path to store the output')
.option('-o, --opengraph', 'Include Open Graph Validation')
.option('-t, --twittercard', 'Include Twitter Card Validation')
.option('-f, --facebookinsight', 'Include Facebook Insight Validation')
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

var counter = 0;

// ----------------------- Open Graph -----------------------
if ( program.opengraph ) {
    var opengraph   = require('./opengraph.js');
    var ogCheck     = opengraph.check(url);
    var ogCount     = opengraph.count();

    resultSocmed.checking.push(ogCheck);
    counter = counter + ogCount;
}

// -------------------- Facebook Insight --------------------
if ( program.facebookinsight ) {
    var fbinsight   = require('./fbinsight.js');
    var fbCheck     = fbinsight.check(url);
    var fbCount     = fbinsight.count();

    resultSocmed.checking.push(fbCheck);
    counter = counter + fbCount;
}

// ----------------------- Open Graph -----------------------
if ( program.twittercard ) {
    var twittercard = require('./twittercard.js');
    resultSocmed.checking.push(twittercard(url));
}


// ------------------------ save to json file ------------------------
resultSocmed.counter = counter;
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