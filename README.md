# lichess-viewer-wp

Small wrapper around lichess viewer named pgn-viewer for Wordpress. Lichess has built over time excellent chess software, and the pgn-viewer built by them seems to be very lightweight, and just right in a lot of circumstances. I want to find out if it is difficult to bring that viewer to Wordpress, and to have a block editor that supports embedding that player then.

## Goals

* Have a minimal implementation (first based on shortcodes) very fast, that could be used.
* Try to find out which features are there, and which of them should be available in a block editor UI then.
* Find out how to support at least some piece styles, and as well some different backgrounds for the  boards.

## Current State

* Not published yet.
* To use that version in Wordpress, do the following steps:
  1. Clone the repository.
  2. Do an `npm install`, then `npm run build`.
  3. Do a `npm run release`.
  4. Upload the created file `lichess-viewer-wp.zip` to your Wordpress instance.
