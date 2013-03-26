
Servant
=======

- Intro, download & docs
	- http://www.eiskis.net/servant/
- Source & issues
	- http://bitbucket.org/Eiskis/proot/
- By Jerry Jäppinen
	- Released under LGPL
	- eiskis@gmail.com
	- http://eiskis.net/
	- @Eiskis



Setup
-----

1. Download Servant
2. Unzip the download on a server with PHP 5.2
3. Make sure `mod_rewrite` or `rewrite_module` is enabled the server.

Things should work out-of-the-box. You should see the demo site when you point your browser to where you put Servant.

Consult troubleshooting guide at [nothing here] if you encounter any problems.



Getting started
---------------

1. Each directory under *sites/* is a site.
2. All .txt, .html, .md and .php files under a site folder are articles.
3. Servant creates a web site with menus etc. for site contents.
4. You can choose a template and template for each site, to customize format and look of each site.



General TODO notes
------------------

- Stop hardcoding class names when validating object type
	- e.g. in ServantArticle, ServantObject
- Add caching
- Set some headers
- Detect localhost to go into debug mode
	- caching disabled
	- debug log visible
