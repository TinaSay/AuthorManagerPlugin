# Authors Manager Plugin

A plugin was made as a test task for Toptal. The plugin is standardized and organized, using object-oriented approach.
The purpose of the plugin is the CRUD actions for authors from the admin panel and displaying them on front end.

## Features

* The plugin is based on the [Plugin API](http://codex.wordpress.org/Plugin_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* All classes, functions, and variables are documented so that you know what you need to change.
* The plugin uses a strict file organization scheme that corresponds both to the WordPress Plugin Repository structure, and that makes it easy to organize the files that compose the plugin.

## Installation

1. Go to Dashboard -> Plugins
2. Press 'Add new' button
3. Upload Plugin as the zip folder
4. Press 'Activate'

## Usage

* Go to 'Authors' menu in dashboard
* Add new author
* Fill all necessary fields with proper information
* To see posts from the frontend click 'View posts' to see the archive and 'View post' to see a singular page of the post.
* Frontend views are available by the following paths: your-domain/authors for all authors list 
and your-domain/authors/first_name-last_name for each single author view

## License

The Authors Manager Plugin is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

## Important Notes

* To make sure that the urls work properly, go to Settings->Permalinks and choose 'Post name' option
* You can easily rewrite css styles, as all classes have specific names
* For better user experience try not to leave any of the input fields empty

## Includes

Note that if you include your own classes, or third-party libraries, there are three locations in which said files may go:

* `plugin-name/inc` is where useful classes reside, that ensure plugin functionality
* `plugin-name/admin` is for all admin-specific functionality
* `plugin-name/public` is for all public-facing functionality
