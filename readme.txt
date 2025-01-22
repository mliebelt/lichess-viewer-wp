=== pgn-viewer-for-lichess ===
Contributors: mliebelt
Donate link:
Tags: chess, pgn, lichess
Requires at least: 4.6
Tested up to: 6.8
Stable tag: 1.0.5
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Integration of lichess-pgn-viewer into WordPress.

== Description ==

=== Using Shortcodes ===

To use a shortcode, do the following steps:

1. Enter on a new element `/shortcode`.
2. Enter inside the element then the shortcode including the content of the following sections.

==== Basic View ====

     [lpgnv]1. e4 e5 2. ...[/lpgnv]

This is the lichess-pgn-viewer: allows to play through a game (including variations), printing the comments, NAGs, ...

=== Using Block Level Element ===

<NOT IMLEMENTED YET>

You can use instead the following:

1. Enter as block element `/Lichess PGN Viewer`.
2. You will then have a form with all options that are possible with the shortcode as well.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.

== Frequently Asked Questions ==

= What parameters are available? =

The parameters the viewer understands are:

* The content of the shortcode is the PGN itself. The viewer reads a lot from tags included there.
* Additional attributes for the shortcode are:
  * fen: <string>, default undefined.
  * boardstyle: <string>, default 'green', available 'blue', 'wood'.
  * orientation: <string>, no default, then taken from tag Orientation. Possible values 'white' or 'black'.
  * showclocks: <boolean>, default true.
  * showmoves: <string|boolean>, default 'auto', others 'right', 'bottom', false. bottom is the same as false, and does not show the moves.
  * showcontrols: <boolean>, default true.
  * scrolltomove: <boolean>, default true.
  * keyboardToMove: <boolean>, default true.
  * theme: <string>, default dark, others are 'light', 'solarizeddark' and 'solarizedlight'.
  * initialply: <number>, default 0, shows the position after the `initialPly` move. Only main lines allowed.

The following code shows how to use some of the parameters in a page:

    [lpgnv orientation=black theme=light]1. e4 e5 2. Nf3 Nc6[/lpgnv]


= Where can I find more information about the implementation? =

Have a look at the GitHub repository https://github.com/mliebelt/lichess-viewer-wp and look there at the file `package.json` to get hints how to develop the plugin then.

== Screenshots ==

1. Example for use of lpgnv, theme=light, orientation=black

== Changelog ==

= 1.0.5

* Added themes solarizeddark and solarizedlight.

= 1.0.4

* Renamed the plugin to meet the requirements of WordPress.

= 1.0.3

* Added (light) theme to the configuration, to allow users to have a more light visual representation.

= 1.0.2

* Added some more attributes for ocnfiguration: fen, showclocks, showmoves, showcontrols, scrolltomove, keyboardtomove
* Some documentation, more boardstyles: green, blue, wood, metal, newspaper.

= 1.0.1

* Fixed problem with influences to PgnViewerJS-WP (my other chessground-based plugin)
* Try to get PGN as good as possible.

= 1.0.0

* First working version, with some flaws. Not published.
