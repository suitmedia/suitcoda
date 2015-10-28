module.exports = function (url) {

    var Horseman    = require('node-horseman'),
        horseman    = new Horseman();

    var openPage = horseman.open( url );

    function getElem (value) {
        return 'meta[name="' + value + '"]';
    }

    function getTag (value) {
        return '<meta name="' + value + '" content="" />';
    }

    var tcNecessaryName = [
        'twitter:card',
        'twitter:site',
        'twitter:title',
        'twitter:description'
    ];
    var tcNecessaryElem = [];
    var tcNecessaryTag = [];

    tcNecessaryName.forEach(function (value, index) {
        tcNecessaryElem.push(getElem(value));
        tcNecessaryTag.push(getTag(value));
    });

    var tcAppName = [
        'twitter:app:id:iphone',
        'twitter:app:id:ipad',
        'twitter:app:id:googleplay'
    ];
    var tcAppElem = [];
    var tcAppTag = [];

    tcAppName.forEach(function (value, index) {
        tcAppElem.push(getElem(value));
        tcAppTag.push(getTag(value));
    });

    var tcPlayerName = [
        'twitter:player',
        'twitter:player:width',
        'twitter:player:height',
        'twitter:image'
    ];
    var tcPlayerElem = [];
    var tcPlayerTag = [];

    tcPlayerName.forEach(function (value, index) {
        tcPlayerElem.push(getElem(value));
        tcPlayerTag.push(getTag(value));
    });

    var resultTwitterCard = {
        socmedName  : 'Twitter Card',
        message     : []
    };

    var tcDesc;

    tcNecessaryElem.forEach(function (value,index) {
        var isExist = horseman.exists(value);

        if ( !isExist ) {
            tcDesc = 'Twitter Card with name property ' + tcNecessaryName[index] + ' is not found. Please add this meta tag ' + tcNecessaryTag[index] + ' to kept the standarization';

            resultTwitterCard.message.push({
                error      : 'Error',
                desc       : tcDesc
            });
        }
    });

    var getTc = horseman.attribute('meta[name="twitter:card"]','content');

    if ( getTc === "app" ) {
        tcAppElem.forEach(function (value,index) {
            var isExist = horseman.exists( value );

            if ( !isExist ) {
                tcDesc = 'Twitter Card App type with name property ' + tcAppName[index] + ' is not found. Please add this meta tag ' + tcAppTag[index] + ' to kept the standarization';
                
                resultTwitterCard.message.push({
                    error      : 'Error',
                    desc       : tcDesc
                });
            }
        });
    }

    if ( getTc === "player" ) {
        tcPlayerElem.forEach(function (value, index) {
            if ( !isExist ) {
                tcDesc = 'Twitter Card Player type with name property ' + tcPlayerName[index] + ' is not found. Please add this meta tag ' + tcPlayerTag[index] + ' to kept the standarization';
                
                resultTwitterCard.message.push({
                    error      : 'Error',
                    desc       : tcDesc
                });
            }
        });
    }

    horseman.close();
    return resultTwitterCard;
};