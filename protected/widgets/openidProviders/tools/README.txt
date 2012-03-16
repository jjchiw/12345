OVERVIEW
-------------------
This is a simple Javascript OpenID selector. It has been designed so 
that users do not even need to know what OpenID is to use it, they 
simply select their account by a recognisable logo.

RELEASE FOR YII FEATURES
-------------------
Author: GOsha
What was done:
- Reviewed directory structure
- UK locale was renamed to UA
     hint: like Ukrainian domain zone, not United Kingdom
- Maked possible to edit config directly from widget
     hint: it was only by hand in main js file
- Found, added and edited .sh script for generating sprites for Linux
- See more OPTIONS in extension page

HOMEPAGE
-------------------
http://code.google.com/p/openid-selector/

USAGE
-------------------
See online demo:
http://openid-selector.googlecode.com/svn/trunk/demo.html


TROUBLESHOOTING
-------------------
Please remember after you change list of providers, you must run 
tools/generate-sprite.js <lang> to refresh sprite image

generate-sprite.js requires ImageMagick to be installed and works
only in Windows (Linux and Apple users can run in VM)

Before running generate-sprite.js for the first time, check its
source code and correct line 16 (var imagemagick = '<...>';) to 
point to ImageMagick install dir.

FOR LINUX
-------------------
There is sh script for generating sprites
http://code.google.com/p/openid-selector/source/browse/trunk/generate-sprite.sh?r=115
USAGE:
1. Go to tools dir:       [user@localhost home] cd /path/to/tools/directory
2. Run generating script: [user@localhost tools] sh generate-sprite.sh en
3. After generating, please remove sprite-generators dir from project


LICENSE
-------------------
openid-selector code is licenced under the New BSD License.
