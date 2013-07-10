License AGPLV3 or higher

Create a diff between two versions of a primivite (node, way or relation).

## Configuration :
* PHP 5.X

PEAR packages needed :
* HTTP/Request2 ;
* Net/URL ;
* Log ;
* PEAR/Exception.

## Use :
Call diff.openstreetmap with URLs like this : &lt;hostname&gt;/diff.openstreetmap/diff/&lt;primitive&gt;/&lt;id&gt;/[from]/[to],

where :
* [primitive] : the type of primitive (node, way or relation) ;
* [id] : the id of the object to be displayed ;
* [from] (optional) : the start version for diff. Must be smaller than [to]. If not specified, its default value is 1 ;
* [to] (optional) : the end version for diff. Must be greater than [from]. If not specified, its default value is the current version of the object.