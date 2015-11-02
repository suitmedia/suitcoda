var counter = 0;

function check(url) {

    var Horseman    = require('node-horseman'),
        horseman    = new Horseman();

    function getElem (value) {
        return 'meta[property="' + value + '"]';
    }

    function getTag (value) {
        return '<meta property="' + value + '" content="" />';
    }

    var ogDesc;


    var ogNecessaryName = [
        'og:title',
        'og:type',
        'og:site_name',
        'og:url',
        'og:description',
        'og:locale',
    ];
    var ogNecessaryElem = [];
    var ogNecessaryTag = [];

    ogNecessaryName.forEach(function (value,index) {
        ogNecessaryElem.push(getElem(value));
        ogNecessaryTag.push(getTag(value));
    });

    var ogTypeElem      = 'meta[property="og:type"]';
    var ogTypeChoice    = ['website','article','video','music','books','profile'];


    var articleNecessaryName = [
        'article:author',
        'article:publisher',
        'article:tag',
        'article:published_time',
        'article:modified_time',
    ];
    var articleNecessaryElem = [];
    var articleNecessaryTag = [];

    articleNecessaryName.forEach(function (value,index) {
        articleNecessaryElem.push(getElem(value));
        articleNecessaryTag.push(getTag(value));
    });

    var ogImgElem = 'meta[property="og:image"]';

    var ogImgNecessaryName = [
        'og:image:type',
        'og:image:width',
        'og:image:height'
    ];
    var ogImgNecessaryElem  = [];
    var ogImgNecessaryTag = [];

    ogImgNecessaryName.forEach(function (value,index) {
        ogImgNecessaryElem.push(getElem(value));
        ogImgNecessaryTag.push(getTag(value));
    });

    var resultOpengraph = {
        socmedName  : 'Open Graph',
        message     : []
    };

    var openPage = horseman.open( url );

    ogNecessaryElem.forEach(function (value, index) {
        var isExist = horseman.exists(value);

        if ( !isExist ) {
            // if does not exist,push to json
            ogDesc = 'Open Graph with property ' + ogNecessaryName[index] + ' is not found. Please add this meta tag ' + 
                    ogNecessaryTag[index] + ' to keep the standarization';

            resultOpengraph.message.push({
                error      : 'Error',
                desc       : ogDesc
            });
        }
        
        counter++;
    });

    // cek og:type
    var isExistOgType   = horseman.exists( ogTypeElem );
    if ( isExistOgType ) {
        var getOgType = horseman.attribute('meta[property="og:type"]','content');

        // check if og:type is one of website,article,video,music,books,profile
        if ( ogTypeChoice.indexOf(getOgType) < 0 ) {
            ogDesc = 'Your Open Graph type [' + getOgType + '] not match with our standarization. [website, books, video, music, books, profile] Please use one of these type.';
          
            resultOpengraph.message.push({
                error      : 'Error',
                desc       : ogDesc
            });
        }
        counter++;

        // if og:type = article
        if ( getOgType === 'article' ) {
            articleNecessaryElem.forEach(function (value, index) {
                var isExist = horseman.exists(value);

                if ( !isExist ) {
                    ogDesc = 'Open Graph with property ' + articleNecessaryName[index] + ' is not found. Please add this meta tag ' + 
                              articleNecessaryTag[index] + ' to keep the standarization';

                    resultOpengraph.message.push({
                        error       : 'Error',
                        desc        : ogDesc
                    });
                }

                counter++;
            });
        }
    }

    // cek og image
    var isExistOgImg    = horseman.exists( ogImgElem );

    if ( isExistOgImg ) {
        ogImgNecessaryElem.forEach(function (value, index) {
            var isExist = horseman.exists( value );

            if ( !isExist ) {
                ogDesc = 'Open Graph with property ' + ogImgNecessaryName[index] + ' is not found. Please add this meta tag ' + 
                              ogImgNecessaryTag[index] + ' to keep the standarization';

                resultOpengraph.message.push({
                    error       : 'Error',
                    desc        : ogDesc
                });
            }

            counter++;
        });
    }

    horseman.close();
    return resultOpengraph;
};

module.exports = {
    check : check,
    count : function () {
        return counter;
    }
};