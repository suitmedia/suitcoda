// ------------------------- dependency -------------------------
var Horseman    = require('node-horseman'),
    horseman    = new Horseman(),
    fs          = require('fs-extra'),
    isUrl       = require('is-url'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander'),
    http        = require('http'),
    jshintt     = require('jshint'),
    rte         = require('readtoend');

// --------------------------- get url ---------------------------
program
    .version('0.0.1')
    .option('-u, --url [url]', 'input url')
    .option('-d, --destination [path]', 'input path to store the output')
    .parse(process.argv);

var url     = program.url,
    dest;

if ( !isUrl(url) ) {
    console.log('ERROR: this is not an url');
    horseman.close();
    process.exit(1);
}

// initialization
var resultJSLinter = {
    name    : 'JS Linter',
    url     : url,
    checking: []
};

fs.exists(program.destination, function (exists) {
    if ( !exists ) {
        fs.mkdirsSync( program.destination );
    }
    dest = './' + program.destination;

    // download JS asset
    var filenameJS = url.substring( url.lastIndexOf('/') + 1 , url.length );

    fs.mkdirSync('js/');
    var file = fs.createWriteStream('js/' + filenameJS);

    var request = http.get(url , function (response) {
        response.pipe(file);

        // read the file
        rte.readToEnd(response, function (err, body) {
            var source = body;
            var options = { undef: true };
            var predef = { jQuery: false };

            // js hint run
            jshintt.JSHINT(source, options, predef);

            resultJSLinter.checking = jshintt.JSHINT.errors;
            
            // json prettify
            var toJson = jsonPretty(resultJSLinter);
            
            // save result
            fs.writeFile(dest + 'resultJS.json', toJson, function (err) {
                if (err) throw err;
            }); 

            // remove asset file
            fs.remove('./js/', function (err) {
                if (err) return console.log(err);
            });
        });
    });
});
    
// end of horseman
horseman.close();