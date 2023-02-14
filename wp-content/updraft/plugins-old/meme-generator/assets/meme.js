// CAN\NVAS.js plugin
// ninivert, december 2016
(function (window, document) {
  /**
  * CAN\VAS Plugin - Adding line breaks to canvas
  * @arg {string} [str=Hello World] - text to be drawn
  * @arg {number} [x=0]             - top left x coordinate of the text
  * @arg {number} [y=textSize]      - top left y coordinate of the text
  * @arg {number} [w=canvasWidth]   - maximum width of drawn text
  * @arg {number} [lh=1]            - line height
  * @arg {number} [method=fill]     - text drawing method, if 'none', text will not be rendered
  */

  CanvasRenderingContext2D.prototype.drawBreakingText = function (str, x, y, w, lh, method) {
    // local variables and defaults
    var textSize = parseInt(this.font.replace(/\D/gi, ''));
    var textParts = [];
    var textPartsNo = 0;
    var words = [];
    var currLine = '';
    var testLine = '';
    str = str || '';
    x = x || 0;
    y = y || 0;
    w = w || this.canvas.width;
    lh = lh || 1;
    method = method || 'fill';

    // manual linebreaks
    textParts = str.split('\n');
    textPartsNo = textParts.length;

    // split the words of the parts
    for (var i = 0; i < textParts.length; i++) {
      words[i] = textParts[i].split(' ');
    }

    // now that we have extracted the words
    // we reset the textParts
    textParts = [];

    // calculate recommended line breaks
    // split between the words
    for (var i = 0; i < textPartsNo; i++) {

      // clear the testline for the next manually broken line
      currLine = '';

      for (var j = 0; j < words[i].length; j++) {
        testLine = currLine + words[i][j] + ' ';

        // check if the testLine is of good width
        if (this.measureText(testLine).width > w && j > 0) {
          textParts.push(currLine);
          currLine = words[i][j] + ' ';
        } else {
          currLine = testLine;
        }
      }
      // replace is to remove trailing whitespace
      textParts.push(currLine);
    }

    // render the text on the canvas
    for (var i = 0; i < textParts.length; i++) {
      if (method === 'fill') {
        this.fillText(textParts[i].replace(/((\s*\S+)*)\s*/, '$1'), x, y+(textSize*lh*i));
      } else if (method === 'stroke') {
        this.strokeText(textParts[i].replace(/((\s*\S+)*)\s*/, '$1'), x, y+(textSize*lh*i));
      } else if (method === 'none') {
        return {'textParts': textParts, 'textHeight': textSize*lh*textParts.length};
      } else {
        console.warn('drawBreakingText: ' + method + 'Text() does not exist');
        return false;
      }
    }

    return {'textParts': textParts, 'textHeight': textSize*lh*textParts.length};
  };
}) (window, document);













