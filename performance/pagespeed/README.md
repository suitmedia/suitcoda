# PageSpeed Insight #

Using [PhantomJS](http://phantomjs.org/) and [psi](https://www.npmjs.com/package/psi)

Usage :

```
node pagespeed.js --url [url] --destination [path] --strategy [mobile/desktop]
```

* -url / --url : input the url to do the test (required)
* -d / --destination : input the path to store the JSON output
* -s / --strategy : input the strategy to use when analyzing the page (default : desktop)

output : resultPagespeed.json