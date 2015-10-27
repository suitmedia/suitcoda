module.exports = function (url) {

    var Horseman    = require('node-horseman'),
        horseman    = new Horseman();

    var openPage = horseman.open( url );

    var resultOpengraph = {
        socmedName  : 'Open Graph',
        message     : []
    };

    var ogElem = 'meta[property*="og:"]';

    isOpengraph = horseman.exists( ogElem );

    if ( isOpengraph ){

        // cek og necessary
        var ogNecessaryElem = [
            'meta[property="og:title"]',
            'meta[property="og:type"]',
            'meta[property="og:site_name"]',
            'meta[property="og:url"]',
            'meta[property="og:description"]',
            'meta[property="og:locale"]'
        ];

        var ogNecessaryElemName = [
            'og:title',
            'og:type',
            'og:site name',
            'og:url',
            'og:description',
            'og:locale',
        ];

        var ogNecessaryTag = [
            '<meta property="og:title" content="" />',
            '<meta property="og:type" content="" />',
            '<meta property="og:site_name" content="" />',
            '<meta property="og:url" content="" />',
            '<meta property="og:description" content="" />',
            '<meta property="og:locale" content="" />'
        ];

        ogNecessaryElem.forEach(function (value, index) {
            var isExist = horseman.exists(value);
            var ogDesc;

            if ( !isExist ){
                // if does not exist,push to json
                ogDesc = 'Open Graph with property ' + ogNecessaryElemName[index] + ' is not found. Please add this meta tag ' + 
                        ogNecessaryTag[index] + ' to kept the standarization';

                resultOpengraph.message.push({
                    error      : 'Error',
                    desc       : ogDesc
                });
            }
        });

        // cek og:type
        var ogTypeElem      = 'meta[property="og:type"]';
        var isExistOgType   = horseman.exists( ogTypeElem );

        if ( isExistOgType ){
            var ogTypeChoice    = ['website','article','video','music','books','profile'];
            var getOgType       = horseman.attribute('meta[property="og:type"]','content');

            if ( ogTypeChoice.indexOf(getOgType) < 0 ) {
                ogDesc = 'Your Open Graph type [' + getOgType + '] not match with our standarization. [website, books, video, music, books, profile] Please use one of these type.';
              
                resultOpengraph.message.push({
                    error      : 'Error',
                    desc       : ogDesc
                });
            }

            // if og:type = article
            if ( getOgType === 'article' ){
                var articleNecessaryName = [
                    'article:author',
                    'article:publisher',
                    'article:tag',
                    'article:published_time',
                    'article:modified_time',
                ];

                var articleNecessaryElem = [
                    'meta[property="article:author"]',
                    'meta[property="article:publisher"]',
                    'meta[property="article:tag"]',
                    'meta[property="article:published_time"]',
                    'meta[property="article:modified_time"]'
                ];

                var articleNecessaryTag = [
                    '<meta property="article:author" content="" />',
                    '<meta property="article:publisher" content="" />',
                    '<meta property="article:tag" content="" />',
                    '<meta property="article:published_time" content="" />',
                    '<meta property="article:modified_time" content="" />',
                ];

                articleNecessaryElem.forEach(function (value, index) {
                    var isExist = horseman.exists(value);
                    var articleDesc;

                    if ( !isExist ) {
                        articleDesc = 'Open Graph with property ' + articleNecessaryName[index] + ' is not found. Please add this meta tag ' + 
                                  articleNecessaryTag[index] + ' to kept the standarization';

                        resultOpengraph.message.push({
                            error       : 'Error',
                            desc        : articleDesc
                        });
                    }
                });
            }
        }

        // cek og image
        var ogImgName       = 'Open Graph Image';
        var ogImgElem       = 'meta[property="og:image"]';
        var isExistOgImg    = horseman.exists( ogImgElem );
        var ogImgDesc;

        if ( isExistOgImg ){
            var ogImgNecessaryName = [
                'og:image:type',
                'og:image:width',
                'og:image:height'
            ];

            var ogImgNecessaryTag = [
                '<meta property="og:image:type" content="" />',
                '<meta property="og:image:width" content="" />',
                '<meta property="og:image:height" content="" />',
            ];

            var ogImgNecessaryElem = [
                'meta[property="og:image:type"]',
                'meta[property="og:image:width"]',
                'meta[property="og:image:height"]'
            ];

            ogImgNecessaryElem.forEach(function (value, index) {
                var isExist = horseman.exists( value );

                if ( !isExist ){
                    ogImgDesc = 'Open Graph with property ' + ogImgNecessaryName[index] + ' is not found. Please add this meta tag ' + 
                                  ogImgNecessaryTag[index] + ' to kept the standarization';

                    resultOpengraph.message.push({
                        error       : 'Error',
                        desc        : ogImgDesc
                    });
                } 
            });
        }
    } else {
        resultOpengraph.message.push({
            error       : 'Error',
            desc        : 'Open Graph is not found'
        });
    }

    horseman.close();
    return resultOpengraph;
};