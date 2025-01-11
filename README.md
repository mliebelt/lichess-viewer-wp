# lichess-viewer-wp

Small wrapper around lichess viewer named pgn-viewer for Wordpress. Lichess has built over time excellent chess software, and the pgn-viewer built by them seems to be very lightweight, and just right in a lot of circumstances. I want to find out if it is difficult to bring that viewer to Wordpress, and to have a block editor that supports embedding that player then.

## Goals

* Have a minimal implementation (first based on shortcodes) very fast, that could be used.
* Try to find out which features are there, and which of them should be available in a block editor UI then.
* Find out how to support at least some piece styles, and as well some different backgrounds for the  boards.

## Configuration

* The content of the shortcode is the PGN itself. The viewer reads a lot from tags included there.
* Additional attributes for the shortcode are:
  * fen: <string>, default undefined.
  * boardstyle: <string>, default 'green', available 'blue', 'wood'.
  * orientation: <string>, no default, then taken from tag Orientation. Possible values 'white' or 'black'.
  * showclocks: <boolean>, default true.
  * showmoves: <string|boolean>, default 'auto', others 'right', 'bottom', false.
  * showcontrols: <boolean>, default true.
  * scrolltomove: <boolean>, default true.
  * keyboardToMove: <boolean>, default true.

## Usage

The following are typical examples how to use it.

```text
[lpgnv boardstyle="green"] e4 e5 [/lpgnv]
```

Here an example with much more attributes.

```text
[lpgnv showclocks=true showcontrols=false scrolltomove=false keyboardtomove=false boardstyle="blue"] 1. e4 { [%clk 0:55:05] } 1... e5 { [%clk 0:55:05] } 2. Nf3 { [%clk 0:55:05] } 2... Nc6 { [%clk 0:55:07] } 3. Bc4 { [%clk 0:55:02] } 3... Bc5 { [%clk 0:54:59] } 4. c3 { [%clk 0:54:57] } 4... d6 { [%clk 0:54:47] } 5. d4 { [%clk 0:54:47] } 5... exd4 { [%clk 0:54:39] } 6. cxd4 { [%clk 0:54:29] } 6... Bb4+ { [%clk 0:54:22] } 7. Bd2 { [%clk 0:54:23] } 7... Bg4 { [%clk 0:54:16] } (7... Bxd2+ 8. Qxd2 Nf6 9. d5 Ne5 10. Nxe5 dxe5 11. Qe3)
[/lpgnv]
```


## Current State

* Not published yet.
* To use that version in Wordpress, do the following steps:
  1. Clone the repository.
  2. Do an `npm install`, then `npm run build`.
  3. Do a `npm run release`.
  4. Upload the created file `lichess-viewer-wp.zip` to your Wordpress instance.
