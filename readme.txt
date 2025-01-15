=== Plugin Name ===
Contributors: mliebelt
Donate link:
Tags: chess, pgn
Requires at least: 4.6
Tested up to: 6.8
Stable tag: 1.0.3
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Integration of lichess-pgn-viewer into WordPress.

== Description ==

=== Using Shortcodes ===

To use a shortcode, do the following steps:

1. Enter on a new element `/shortcode`.
2. Enterinside the element then the shortcode including the content of the following sections.

==== Basic View ====

     [lpgnv]1. e4 e5 2. ...[/lpgnv]

This is the lichess-pgn-viewer: allows to play through a game (including variations), printing the comments, NAGs, ...

=== Using Block Level Element ===

You can use instead the following:

1. Enter as block element `/PGN Viewer Block Editor`, in the variants ` View`, ` Edit`, ` Board` or ` Print`.
2. You will then have a form with all options that are possible with the shortcode as well.
3. Depending on the kind of element you want to have, different values are needed:
    * View: all possible
    * Edit: same as view
    * Board: only FEN and layout elements of the board
    * Print: most not needed.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= What parameters are available? =

The parameters the viewer understands are:

* id: May be set by the user or generated automatically by the system.
* locale: the locale to use for displaying the moves, default is 'en'. Available are: cs, da, de, en, es, et, fi, fr, hu, is, it, nb, nl, pl, pt, ro, sv.
* position: the position where the game starts, default is the initial position.
* showcoords: default true, if false, hides the ranks and columns on the board.
* piecestyle: the pieces to use, default is 'merida'. Availabe are: 'wikipedia', 'alpha', 'uscf', 'case', 'condal', 'leipzig', 'chesscom', 'maya', 'merida', and 'beyer'.
* orientation: 'white' or 'black', default is 'white'.
* theme: the theme defines the overall board, color, pieces, ... Current are: green, zeit, chesscom, informator, sportverlag, beyer, falken, blue
* boardsize: the size of the board, if it should be different to the size of the column.
* size: the size of the column to print the board, the buttons, the moves, ...
* moveswidth: used to size the width of the moves section. Needed for layout == left | right
* movesheight: used to size the height of the moves section. Needed for layout == left | right
* layout: top, bottom, left, right, top-left, top-right, bottom-left, bottom-right
* startplay: move from which the game should be started
* showresult: true, if the result of the game should be shown inside the notation, default false
* colormarker: default none, options are: cm, cm-big, cm-small, circle, circle-big, circle-small
* notation: default short, option is: long
* notationlayout: default inline, option is: list
* showfen: default false, option: true. Shows an additional text editor for the FEN of the current position.
* coordsfactor: default 1, by using a different number, coords font is grown or shrunk.
* coordsfontsize: alternative, set the size of the font in pixel
* timertime: default 700, number of milliseconds between moves
* hidemovesbefore: default false, if set to true, hide the moves before move denoted by startplay


The following code shows how to use some of the parameters in a page:

    [pgnv locale=fr piecestyle=uscf orientation=black theme=zeit size=500px]1. e4 e5 2. Nf3 Nc6[/pgnv]

= What if I want to use most of the parameters the same all the time? =

There is a Javascript variable `PgnBaseDefaults` that you could set. Do the following:

* Go as admin of your Wordpress site to Appearance > Theme Editor
* Search on the right the theme file named `Theme Header` (== `header.php`).
* Search inside that file the section that begins with `<head>`.
* Insert somewhere before the plugins are loaded the following: `<script>const PgnBaseDefaults = { locale: 'de', layout: 'left',  size: '720px' }</script>` (of course with the defaults you like).

When you now create new pages, you can leave out the parameters you have already set per default. And you can of course overwrite them by having individual parameters set in the call.

= Where can I find more information about the implementation? =

Have a look at the GitHub repository https://github.com/mliebelt/PgnViewerJS-WP and the sister repository https://github.com/mliebelt/PgnViewerJS (which contains the implementation in Javascript).

== Screenshots ==

1. Example for use of pgnView (shortcode pgnv).
2. Example for use of pgnEdit (shortcode pgne).
3. Example for use of pgnBoard (shortcode pgnb).
4. Example for use of pgnPrint (shortcode pgnp).

== Changelog ==

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
