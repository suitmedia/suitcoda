var psi         = require('psi'),
    fs          = require('fs-extra'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander');

program
.version('0.0.1')
.option('-u, --url [url]', 'input url')
.option('-d, --destination [path]', 'input path to store the output')
.parse(process.argv);

var url         = program.url;
var dest        = program.destination || '';
var strategy    = 'mobile';
 
var option = {
    strategy : strategy
};

fs.exists(program.destination, function (exists) {
    if ( !exists ) {
        fs.mkdirsSync( program.destination );
    }
    dest = './' + program.destination;

    psi(url , option , function (err, data) {
        var toJson = jsonPretty(data);

        fs.writeFile(dest + 'resultPagespeedMobile.json', toJson, function (err) {
            if (err) throw err;
            console.log('It\'s saved!');
        });
    });
});
