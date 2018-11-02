10 Oct 2018

Port of Sportacus from Symfony 2.8 to Symfony 4.1 and php 7.1

Ideally this will be 90% copy/paste as long as I can resist the urge to refactor.

Also want to merge and fix up some of the hacks I introduced.

### Issues

Tab spaces set to 2
Many of the new S4 files are set to 4.  Need to pick one or the other at some point.

Changing all controllers with @Template to return arrays

For now, get rid of all my array access traits, failed experiment.


Refactor repositories to use ServiceEntityRepository.  
Note that doing so implies entities can only belong to one entity manager.

Experimenting with strict_types

### TODO mysql case issue

ALTER TABLE Location RENAME INDEX uniq_a7e8eb9d5e237e06 TO UNIQ_5E9E89CB5E237E06;

Have to explicitly specify table names.

### PageController

Basic index, help and contact screens

Copied over the original assets directory which contains bootstrap, jquery and some misc things.
Added the print.css/screen.css as well.

Todo: See if using webpack is practical

Original has extra web/css/screen.css?

### Entities

Enquiry - Not a real entity, leave for now

Location - Standalone

### Controllers

LocationController was the first to be ported.
* Extend from AbstractController
* Injected LocationRepository
* Added findLocation
* Access entity manager via repository


RegionController was next.
* Remove action from form templates
* Remove Template annotation
* Combine new/create and edit/update

Going back and forth on form standardization.  Where to put styling and where to put actions?

### Project

Got rid of the var doc annotations in Project.  
Replaced with return types.  
Need to be very careful with nulls.  
Need to look at returning arrays of a given type.
Still not sure if this is a good idea or not.
Empty form text strings return null not an empty string.
empty_data fixes that

What about non-set dates?  Hard to initialize new dates.

And existing data is a problem though can tweak getters to return proper data types.

### AgeGroup

Brought over the entity and implemented the list all functionality.
Not sure how much individual editing is actually being done.

### Database

* AgeGroup links to Region,Project 
* Project many-to-many with OffPos via project_offpos
* Region is standalone
* Game linked to AgeGroup, Location, Region, Project
* Team linked to AgeGroup, Region, Project
* project_game_team      Game, Team, Level (probably AgeGroup)
* project_game_officials Game, Official, Team
