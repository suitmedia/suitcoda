module.exports = function (url) {

    var Horseman    = require('node-horseman'),
        horseman    = new Horseman();

    var fbElem = [
        'meta[property="fb:admins"]',
        'meta[property="fb:page_id"]',
        'meta[property="fb:app_id"]'
    ];

    var fbName = [
        'fb:admins',
        'fb:page_id',
        'fb:app_id'
    ];

    var fbTag = [
        '<meta property="fb:admins" content="" />',
        '<meta property="fb:page_id" content="" />',
        '<meta property="fb:app_id" content="" />'
    ];

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