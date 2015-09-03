// ------------------------- dependency -------------------------
var Horseman    = require('node-horseman'),
    horseman    = new Horseman(),
    fs          = require('fs-extra'),
    isUrl       = require('is-url'),
    jsonPretty  = require('json-pretty'),
    shell       = require('shelljs'),
    program     = require('commander'),
    jshintt     = require('jshint');

// --------------------------- get url ---------------------------
program
.version('0.0.1')
.option('-url, --url [url]', 'input url')
.parse(process.argv);

var url = program.url;

if ( !isUrl(url) ){
    console.log('ERROR: this is not an url');
    horseman.close();
}

// ----------------------- download css asset -----------------------
if (shell.exec('casperjs downloadJS.js --url=' + url).code !== 0) {
    echo('Download Failed.');
    exit(1);
}

// ---------------------------- JS Hint ----------------------------
var resultJSLinter = {
    name    : 'JS Linter',
    url     : url,
    checking: []
};

var filename = fs.readdirSync('js/');

for (var i = 0; i < filename.length; i++) {
    resultJSLinter.checking.push({
        fileName    : filename[i],
        messages    : [] 
    });

    var source = fs.readFileSync('./js/'+ filename[i] , 'utf-8');
    var options = { undef: true };
    var predef = { jQuery: false };

    jshintt.JSHINT(source, options, predef);

    resultJSLinter.checking[i].messages = jshintt.JSHINT.errors;
};

// ------------------------ save result ------------------------
var toJson = jsonPretty(resultJSLinter);

function saveReport () {
    fs.writeFile('resultJS.json', toJson, function (err) {
        if (err) throw err;
    });	
};

saveReport();

// --------------------- remove asset file ---------------------
fs.removeSync('./js/');

horseman.close();