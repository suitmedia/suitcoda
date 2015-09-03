var casper  = require('casper').create({
    pageSettings: {
        webSecurityEnabled: false
    }
}),
    isUrl   = require('is-url'),
    utils   = require('utils');

var url;
if ( !casper.cli.has("url") ){
    console.log('error');
    casper.exit();
} else {
    url = casper.cli.get("url");
    if ( !isUrl(url) ){
        console.log('ERROR: this is not an url');
        casper.exit();
    }
}

casper.start(url);

casper.then( function () {

    var getFile = this.getElementsAttribute('link[rel="stylesheet"]', 'href');

    for (var i = 0; i < getFile.length; i++) {
        if ( getFile[i].substring(0,4) !== 'http' ){
            getFile[i] = 'http:' + getFile[i];
        }

        var filename = getFile[i].substring( getFile[i].lastIndexOf('/') + 1 , getFile[i].length );

        this.download( getFile[i], 'css/' + filename );
    };
});

casper.run();
