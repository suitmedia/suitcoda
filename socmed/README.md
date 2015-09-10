# Social Media - Meta Tag Checker #

Using [PhantomJS](http://phantomjs.org/) and [node-horseman](http://www.horsemanjs.org/)

Includes : 

* [Open Graph](http://ogp.me/)
* [Twitter Cards](https://dev.twitter.com/cards/overview)
* [Facebook Insights](https://developers.facebook.com/docs/platforminsights/domains)

Usage :

```
node socmedChecker.js --url [URL] --destination [path]
```

* -url / --url : input the url to do the test (required)
* -d / --destination : input the path to store the JSON output

output : resultSocmed.json