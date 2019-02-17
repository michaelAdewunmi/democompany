# DemoCompany WordPress Theme
*A WordPress theme for a fictional company by rtcamp called demo company. This theme is build off the AWESOME [underscores starter theme](https://underscores.me)*.

![theme-screenshot](https://github.com/michaelAdewunmi/democompany/blob/master/screenshot.png)

**Contributors**: Michael Adewunmi Osikoya
**Tags**: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, Custom Post-types, Customized Footer.


## Example Usage (Demo Links)
The example usage of this theme is found at https://fictionaldemocompany.gq


## Theme Dependencies (Libraries Used)
* [JQuery](https://jquery.com) - The Fast, small and feature rich javascript library
* [Bootstrap](https://getbootstrap.com) version 4.3.1 for [CSS layout](https://getbootstrap.com/docs/4.3/layout/overview) and [JavaScript](https://getbootstrap.com/docs/4.3/getting-started/javascript).
* [PopperJs](https://popper.js.org) - Used by the bootstrap library.
* [FontAwesome](https://fontawesome.com) - The library of vector icons.

## Custom post types, News Widgets and Footer's Social Media Widgets
This theme make use of custom post types. Also the theme utilizes a news widget and a social media widget in the footer area.

Since it is not advisable to bundle plugin functionality within a theme, the codes for powering the custom post type creation, the news widget and the social media widgets have been placed in the mu-plugins folder.

If youre using this theme elsewhere, then please [go here](https://www.dropbox.com/s/wo6va5erqb8vn90/mu-plugins.zip?dl=0) and download the zip file. Once downloaded, place the file in the mu-plugins in your wp-content folder on your host server wordpress directory and you're good to go.

***
***
### == Code Testings ==
various tests were done using phpUnit and the Wordpress CLI to ensure that there are no loopholes in the code written. These test files have been placed in the tests folder.

To test the footer widgets and the news widgets, please ensure the files are downloaded and placed in the mu-plugins folder in the wordpress wp-content directory. Thats where the test file will look for it. All tests were carried out in one file.

ALthough this is not the best practice but since all functionalities are core part of the theme, then this is the reason why all tests was done in one file.

##### In Addition to the theme unit tests done above, this wordpress theme has also been fully tested to pass all 7392 test carried out by the [wordpress Theme Check plugin](https://wordpress.org/plugins/theme-check/).

##### In conclusion, the theme's codebase has being tested with [Scrutinizer-ci](https://scrutinizer-ci.com) with an average score of 9.79/10


> Note: The WordPress theme test (using the theme check plugin) was done ONLY with the required theme files in place.This simply means that files such as .gitignore, .scrutinizer.yml and other unenecessary files werte totally removed before the test is beng carried out. This means cloning this repo (as is) and testing it wont produce a 100% passed test due to unnecessary files not associated with theme usage.


### == Installation ==
1. Clone this repo and delete all unnecessary files and folders such as the test folder, gitignore file, phpcs.xml.dist, .phpcs.xml.dist, phpunit.xml.dist, .travis.yml, .scrutinizer.yml, and other files not required by wordpress themes.

2. In your admin panel, go to Appearance > Themes and click the Add New button.

3. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.

4. Click Activate to use your new theme right away.


### == Credits ==
* theme design by [rtcamp](https://rtcamp.com)
* Theme developed based on Underscores https://underscores.me/, (C) 2012-2019 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css https://necolas.github.io/normalize.css/, (C) 2012-2019 Nicolas Gallagher and Jonathan Neal, [MIT](https://opensource.org/licenses/MIT)
* [google](https://google.com) - Always to the rescue to help developers remeber the actual way to spell or use the forgotten wordpress function. That's why my quote says "Life without google is possible but the one with google in it is better". :)


