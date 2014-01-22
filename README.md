kohana-restful-api
==================

Simple module for implementation of RESTful API as self-contained packages

####Request
<pre>
/**
 * version API = v1
 * resource = news
 * resource id = 23
 * response format = json
 */
http://site.com/api/v1/news/23.json
</pre>

will be loaded class DOCROOT/API/v1/News and executed method "read" with params: id=23

####Structure application
<pre>
DOCROOT
....API
........v1
............APIclass.php
............APIclass2.php
........v2
............APIclass.php
............APIclass2.php
....application
....modules
........restful-api
....system
</pre>
