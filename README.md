10 Oct 2018

Port of Sportacus from Symfony 2.8 to Symfony 4.1 and php 7.1

Ideally this will be 90% copy/paste as long as I can resist the urge to refactor.

Also want to merge and fix up some of the hacks I introduced.

### Issues

Tab spaces set to 2
Many of the new S4 files are set to 4.  Need to pick one or the other at some point.

Changing all controllers with @Template to return arrays

### PageController

Basic index, help and contact screens

Copied over the original assets directory which contains bootstrap, jquery and some misc things.
Added the print.css/screen.css as well.

Todo: See if using webpack is practical

Original has extra web/css/screen.css?
