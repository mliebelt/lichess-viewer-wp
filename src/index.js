const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { SelectControl, TextControl, TextareaControl, CheckboxControl } =
  wp.components;
const { useBlockProps } = wp.blockEditor;

// Register the block
registerBlockType("lichess-pgn-viewer/block-editor", {
  title: __("PGN Viewer for Lichess", "lichess-pgn-viewer"),
  icon: "chess",
  category: "widgets",
  attributes: {
    fen: { type: "string", default: "" },
    pgn: { type: "string", default: "" },
    showclocks: { type: "boolean", default: true },
    showmoves: { type: "string", default: "auto" },
    showcontrols: { type: "boolean", default: true },
    scrolltomove: { type: "boolean", default: true },
    keyboardtomove: { type: "boolean", default: true },
    boardstyle: { type: "string", default: "" },
    initialply: { type: "string", default: "0" },
    orientation: { type: "string", default: "" },
    theme: { type: "string", default: "dark" },
  },

  edit: ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps({
      className: "lpgnv-wrapper",
    });

    return (
      <div {...blockProps}>
        {/* Single line for FEN */}
        <div className="row group-1">
          <TextControl
            label={__("FEN", "lichess-pgn-viewer")}
            value={attributes.fen}
            onChange={(fen) => setAttributes({ fen })}
          />
        </div>

        {/* Full-width PGN textarea */}
        <div className="row group-1">
          <TextareaControl
            label={__("PGN", "lichess-pgn-viewer")}
            value={attributes.pgn}
            onChange={(pgn) => setAttributes({ pgn })}
          />
        </div>

        {/* 4-column layout for main settings */}
        <div className="row group-4">
          <SelectControl
            label={__("Orientation", "lichess-pgn-viewer")}
            value={attributes.orientation}
            options={[
              { label: __("Default", "lichess-pgn-viewer"), value: "" },
              { label: __("White", "lichess-pgn-viewer"), value: "white" },
              { label: __("Black", "lichess-pgn-viewer"), value: "black" },
            ]}
            onChange={(orientation) => setAttributes({ orientation })}
          />
          <TextControl
            label={__("Initial Ply", "lichess-pgn-viewer")}
            type="number"
            value={attributes.initialply}
            onChange={(initialply) => setAttributes({ initialply })}
          />
          <SelectControl
            label={__("Theme", "lichess-pgn-viewer")}
            value={attributes.theme}
            options={[
              { label: __("Dark", "lichess-pgn-viewer"), value: "dark" },
              { label: __("Light", "lichess-pgn-viewer"), value: "light" },
              {
                label: __("Solarized Dark", "lichess-pgn-viewer"),
                value: "solarizeddark",
              },
              {
                label: __("Solarized Light", "lichess-pgn-viewer"),
                value: "solarizedlight",
              },
            ]}
            onChange={(theme) => setAttributes({ theme })}
          />
          <SelectControl
            label={__("Board Style", "lichess-pgn-viewer")}
            value={attributes.boardstyle}
            options={[
              { label: __("Default", "lichess-pgn-viewer"), value: "" },
              { label: __("Blue", "lichess-pgn-viewer"), value: "blue" },
              { label: __("Wood", "lichess-pgn-viewer"), value: "wood" },
              { label: __("Green", "lichess-pgn-viewer"), value: "green" },
              { label: __("Metal", "lichess-pgn-viewer"), value: "metal" },
              {
                label: __("Newspaper", "lichess-pgn-viewer"),
                value: "newspaper",
              },
            ]}
            onChange={(boardstyle) => setAttributes({ boardstyle })}
          />
        </div>

        {/* 4-column layout for boolean controls */}
        <div className="row group-4">
          <CheckboxControl
            label={__("Show Clocks", "lichess-pgn-viewer")}
            checked={attributes.showclocks}
            onChange={(showclocks) => setAttributes({ showclocks })}
          />
          <CheckboxControl
            label={__("Show Controls", "lichess-pgn-viewer")}
            checked={attributes.showcontrols}
            onChange={(showcontrols) => setAttributes({ showcontrols })}
          />
          <CheckboxControl
            label={__("Scroll to Move", "lichess-pgn-viewer")}
            checked={attributes.scrolltomove}
            onChange={(scrolltomove) => setAttributes({ scrolltomove })}
          />
          <CheckboxControl
            label={__("Keyboard to Move", "lichess-pgn-viewer")}
            checked={attributes.keyboardtomove}
            onChange={(keyboardtomove) => setAttributes({ keyboardtomove })}
          />
        </div>
      </div>
    );
  },

  save: () => null, // Block is server-side rendered
});
