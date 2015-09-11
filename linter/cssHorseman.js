// ------------------------- dependency -------------------------
var Horseman   = require('node-horseman'),
    horseman   = new Horseman(),
    fs         = require('fs-extra'),
    isUrl      = require('is-url'),
    jsonPretty = require('json-pretty'),
    shell      = require('shelljs'),
    program    = require('commander'),
    cssLint    = require('csslint').CSSLint,
    css        = require('css');

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

// ----------------------- download css asset -----------------------
if (shell.exec('casperjs downloadCSS.js --url=' + url).code !== 0) {
    echo('Download Failed.');
    exit(1);
}

// ---------------------------- css lint ----------------------------
var resultCSSLinter = {
    name    : 'CSS Linter',
    url     : url,
    checking: []
};

var filename = fs.readdirSync('css/');

for (var i = 0; i < filename.length; i++) {
    var source = fs.readFileSync( './css/' + filename[i] , 'utf-8');

    var parseSource = css.parse( source );
    var beautified	= css.stringify( parseSource );

    resultCSSLinter.checking.push(
        {
            fileName    : filename[i],
            messages    : []
        }
    );

    var result = cssLint.verify( beautified );
    if (result.messages.length === 0) {
        //Success
    } else {
        //Errors or warnings
        for ( j = 0 ; j < result.messages.length ; j++) {
            var message = result.messages[j];
            resultCSSLinter.checking[i].messages.push(
                {
                    messageType     : message.type,
                    messageLine     : message.line,
                    messageCol      : message.col,
                    messageMsg      : message.message
                }
            );
        }
    }
};

// ------------------------ save to json file ------------------------
var toJson = jsonPretty(resultCSSLinter);

function saveReport () {
    fs.writeFile(dest + 'resultCSS.json', toJson, function (err) {
        if (err) throw err;
    });	
};

saveReport();

// --------------------- remove asset file ---------------------
fs.removeSync('./css/');

horseman.close();