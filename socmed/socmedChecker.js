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

// ----------------------- Open Graph -----------------------
var opengraph = require('./opengraph.js');
resultSocmed.checking.push(opengraph(url));


// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultSocmed);

function saveReport () {
    fs.writeFile(dest + 'resultSocmed.json', toJson, function (err) {
        if (err) throw err;
    }); 
}

saveReport();

horseman.close();
