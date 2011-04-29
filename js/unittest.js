// script.aculo.us unittest.js v1.8.2, Tue Nov 18 18:30:58 +0100 2008

// Copyright (c) 2005-2008 Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)
//           (c) 2005-2008 Jon Tirsen (http://www.tirsen.com)
//           (c) 2005-2008 Michael Schuerig (http://www.schuerig.de/michael/)
//
// script.aculo.us is freely distributable under the terms of an MIT-style license.
// For details, see the script.aculo.us web site: http://script.aculo.us/

// experimental, Firefox-only
Event.simulateMouse = function(element, eventName) {
  var options = Object.extend({
    pointerX: 0,
    pointerY: 0,
    buttons:  0,
    ctrlKey:  false,
    altKey:   false,
    shiftKey: false,
    metaKey:  false
  }, arguments[2] || {});
  var oEvent = document.createEvent("MouseEvents");
  oEvent.initMouseEvent(eventName, true, true, document.defaultView, 
    options.buttons, options.pointerX, options.pointerY, options.pointerX, options.pointerY, 
    options.ctrlKey, options.altKey, options.shiftKey, options.metaKey, 0, $(element));
  
  if(this.mark) Element.remove(this.mark);
  this.mark = document.createElement('div');
  this.mark.appendChild(document.createTextNode(" "));
  document.body.appendChild(this.mark);
  this.mark.style.position = 'absolute';
  this.mark.style.top = options.pointerY + "px";
  this.mark.style.left = options.pointerX + "px";
  this.mark.style.width = "5px";
  this.mark.style.height = "5px;";
  this.mark.style.borderTop = "1px solid red;";
  this.mark.style.borderLeft = "1px solid red;";
  
  if(this.step)
    alert('['+new Date().getTime().toString()+'] '+eventName+'/'+Test.Unit.inspect(options));
  
  $(element).dispatchEvent(oEvent);
};

// Note: Due to a fix in Firefox 1.0.5/6 that probably fixed "too much", this doesn't work in 1.0.6 or DP2.
// You need to downgrade to 1.0.4 for now to get this working
// See https://bugzilla.mozilla.org/show_bug.cgi?id=289940 for the fix that fixed too much
Event.simulateKey = function(element, eventName) {
  var options = Object.extend({
    ctrlKey: false,
    altKey: false,
    shiftKey: false,
    metaKey: false,
    keyCode: 0,
    charCode: 0
  }, arguments[2] || {});

  var oEvent = document.createEvent("KeyEvents");
  oEvent.initKeyEvent(eventName, true, true, window, 
    options.ctrlKey, options.altKey, options.shiftKey, options.metaKey,
    options.keyCode, options.charCode );
  $(element).dispatchEvent(oEvent);
};

Event.simulateKeys = function(element, command) {
  for(var i=0; i<command.length; i++) {
    Event.simulateKey(element,'keypress',{charCode:command.charCodeAt(i)});
  }
};

var Test = {};
Test.Unit = {};

// security exception workaround
Test.Unit.inspect = Object.inspect;

Test.Unit.Logger = Class.create();
Test.Unit.Logger.prototype = {
  initialize: function(log) {
    this.log = $(log);
    if (this.log) {
      this._createLogTable();
    }
  },
  start: function(testName) {
    if (!this.log) return;
    this.testName = testName;
    this.lastLogLine = document.createElement('tr');
    this.statusCell = document.createElement('td');
    this.nameCell = document.createElement('td');
    this.nameCell.className = "nameCell";
    this.nameCell.appendChild(document.createTextNode(testName));
    this.messageCell = document.createElement('td');
    this.lastLogLine.appendChild(this.statusCell);
    this.lastLogLine.appendChild(this.nameCell);
    this.lastLogLine.appendChild(this.messageCell);
    this.loglines.appendChild(this.lastLogLine);
  },
  finish: function(status, summary) {
    if (!this.log) return;
    this.lastLogLine.className = status;
    this.statusCell.innerHTML = status;
    this.messageCell.innerHTML = this._toHTML(summary);
    this.addLinksToResults();
  },
  message: function(message) {
    if (!this.log) return;
    this.messageCell.innerHTML = this._toHTML(message);
  },
  summary: function(summary) {
    if (!this.log) return;
    this.logsummary.innerHTML = this._toHTML(summary);
  },
  _createLogTable: function() {
    this.log.innerHTML =
    '<div id="logsummary"></div>' +
    '<table id="logtable">' +
    '<the