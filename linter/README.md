# HTML, JS, CSS Linter #

Using [PhantomJS](http://phantomjs.org/), [node-horseman](http://www.horsemanjs.org/), and [CasperJs](http://casperjs.org/).

### HTML Linter ###

Includes : 

* [W3 Validator](https://validator.w3.org/)
* Title Tag Checking
* Header Tag Checking
* Footer Tag Checking
* Script Tag Checking
* Favicon
* ARIA Landmark (banner, main, contentinfo, navigation, search)
* Image with No Alt Text
* Internationalization (i18n)
* Meta Tag (desc, viewport)

Usage :

```
node htmlHorseman.js --url [URL] --destination [path]
```

* -url / --url : input the url to do the test (required)
* -d / --destination : input the path to store the JSON output

output : resultHTML.json

### CSS Linter ###

Will catch all external stylesheet from url

by : [csslint](https://github.com/CSSLint/csslint)

Usage :

```
node cssHorseman.js --url [URL] --destination [path]
```

* -url / --url : input the url to do the test (required)
* -d / --destination : input the path to store the JSON output

output : resultCSS.json

### JS Linter ###

Will catch all javascript file from url (exclude jQuery, Google Analytic)

by : [jshint](http://jshint.com/)

Usage :

```
node jsHorseman.js --url [URL] --destination [path]
```

* -url / --url : input the url to do the test (required)
* -d / --destination : input the path to store the JSON output

output : resultJS.json