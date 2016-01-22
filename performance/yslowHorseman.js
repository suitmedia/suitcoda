var fs          = require('fs-extra'),
    sh          = require('shelljs'),
    program     = require('commander'),
    jsonPretty  = require('json-pretty');

program
.version('0.0.1')
.option('-u, --url [URL]', 'Input URL')
.option('-d, --destination [path]', 'Input Path to Store The Output')
.parse(process.argv);

var url     = program.url;
var dest;
var date = new Date();
var time = date.getTime();
var outputYSlow = 'tempYSlow' + time + '.json';

// ---------------------- run the phantom command ----------------------
var yslowDir = sh.pwd() + '/performance/';
var command = 'phantomjs --config='+ yslowDir +'config.json ' + yslowDir + 'yslow.js --info grade ' + url + ' > ' + outputYSlow; 

if ( sh.exec( command ).code !== 0 ) {
    console.log('cannot generate YSlow result!');
    process.exit(1);
}

// ----------------------------- initialize -----------------------------
var resultYSlow = {
    name    : 'YSlow',
    url     : url,
    checking: []
};

var checkingName = [
    "Minimize HTTP Requests" ,
    "Use a Content Delivery Network" ,
    "Avoid empty src or href" ,
    "Add an Expires or a Cache-Control Header" ,
    "Gzip Components" ,
    "Put StyleSheets at the Top" ,
    "Put Scripts at the Bottom" ,
    "Avoid CSS Expressions" ,
    "Make JavaScript and CSS External" ,
    "Reduce DNS Lookups" ,
    "Minify JavaScript and CSS" ,
    "Avoid Redirects" ,
    "Remove Duplicate Scripts" ,
    "Configure ETags" ,
    "Make AJAX Cacheable" ,
    "Use GET for AJAX Requests" ,
    "Reduce the Number of DOM Elements" ,
    "No 404s" ,
    "Reduce Cookie Size" ,
    "Use Cookie-Free Domains for Components" ,
    "Avoid Filters" ,
    "Do Not Scale Images in HTML" ,
    "Make favicon.ico Small and Cacheable"
];

var i = 0;

fs.exists(program.destination, function (exists) {
    if ( !exists ) {
        fs.mkdirsSync( program.destination );
    }
    dest = './' + program.destination;

    // -------------------------- read yslow file output --------------------------
    fs.readFile('./' + outputYSlow,'utf-8' , function (err, data) {
        if (err) throw err;

        var jsonYSlow           = JSON.parse( data ),
            jsonYSlowChecking   = jsonYSlow.g;

        resultYSlow.overallScore = jsonYSlow.o;

        for ( var key in jsonYSlowChecking ) {
            if ( jsonYSlowChecking[key].score < 100 ) {
                resultYSlow.checking.push({
                    error   : "Error",
                    name    : checkingName[i] + " (" + key + ")",
                    score   : jsonYSlowChecking[key].score,
                    desc    : jsonYSlowChecking[key].message,
                    code    : jsonYSlowChecking[key].components
                });
            }
            i++;
        }

        var toJson = jsonPretty(resultYSlow);

        saveReport(dest, toJson);
        deleteTempFile(outputYSlow);
    });


});

function saveReport(path, content) {
    fs.writeFile(path + 'resultYSlow.json', content, function (err) {
        if (err) throw err;
        console.log("resultYSlow.json has saved!");
    }); 
}

function deleteTempFile(url) {
    fs.remove( url , function (err) {
        if (err) return console.error(err);
        console.log("Temporary file has been deleted.");
    });
}
    