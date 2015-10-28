module.exports = function (url) {

    var Horseman    = require('node-horseman'),
        horseman    = new Horseman();

    function getElem (value) {
        return 'meta[name="' + value + '"]';
    }

    function getTag (value) {
        return '<meta name="' + value + '" content="" />';
    }

    var fbName = [
        'fb:admins',
        'fb:page_id',
        'fb:app_id'
    ];
    var fbElem  = [];
    var fbTag   = [];

    fbName.forEach(function (value,index) {
        fbElem.push(getElem(value));
        fbTag.push(getTag(value));
    });

    var fbDesc;

    var resultFbInsight = {
        socmedName  : 'Facebook Insight',
        message     : []
    };

    var openPage = horseman.open( url );

    fbElem.forEach(function (value,index) {
        var isExist = horseman.exists( value );

        if ( !isExist ) {
            fbDesc = 'Facebook Insight with property ' + fbName[index] + ' is not found. Please add this meta tag ' + fbTag[index] + 'to keep the standarization.';

            resultFbInsight.message.push({
                error : 'Warning',
                desc  : fbDesc
            });
        }
    });

    horseman.close();
    return resultFbInsight;
};