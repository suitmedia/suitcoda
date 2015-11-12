var psi         = require('psi'),
    fs          = require('fs'),
    jsonPretty  = require('json-pretty'),
    program     = require('commander');

program
.version('0.0.1')
.option('-u, --url [url]', 'input url')
.option('-d, --destination [path]', 'input path to store the output')
.option('-s, --strategy [mobile/desktop]', 'input the strategy to use when analyzing the page (default : desktop)')
.parse(process.argv);

var url         = program.url;
var dest        = program.destination || '';
var strategy    = program.strategy || 'desktop';
 
var option = {
    strategy : strategy
};

fs.exists(program.destination, function (exists) {
    if ( !exists ) {
        fs.mkdir(program.destination , function () {});
    }
    dest = './' + program.destination;

    psi(url , option , function (err, data) {
        var toJson = jsonPretty(data);

        fs.writeFile(dest + 'resultPagespeed.json', toJson, function (err) {
            if (err) throw err;
            console.log('It\'s saved!');
        });
    });
});
