This extension is specifically for the FamilySearch wiki farm.  It creates a masthead
feature with dynamic navigation and styling specifically for FamilySearch.  You can
use it as an example of how to do the same for your wiki.

If you are checking this out from Git and intend to use it, you may use the
following commands to make a clean directory of just this template without the
Git meta-data and other examples.

	cd extensions
	git clone https://gerrit.wikimedia.org/r/mediawiki/extensions/FsHeader.git
	cp -R FsHeader ./MyExtension

This automates the recommended code checkers for PHP and JavaScript code in Wikimedia projects
(see https://www.mediawiki.org/wiki/Continuous_integration/Entry_points).
To take advantage of this automation.

1. install nodejs, npm, and PHP composer
2. change to the extension's directory
3. `npm install`
4. `composer install`

Once set up, running `npm test` and `composer test` will run automated code checks.
