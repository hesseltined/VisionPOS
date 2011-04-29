// lightwindow.js v2.0
//
// Copyright (c) 2007 stickmanlabs
// Author: Kevin P Miller | http://www.stickmanlabs.com
// 
// LightWindow is freely distributable under the terms of an MIT-style license.
//
// I don't care what you think about the file size...
//   Be a pro: 
//	    http://www.thinkvitamin.com/features/webapps/serving-javascript-fast
//      http://rakaz.nl/item/make_your_pages_load_faster_by_combining_and_compressing_javascript_and_css_files
//

/*-----------------------------------------------------------------------------------------------*/

if(typeof Effect == 'undefined')
  throw("lightwindow.js requires including script.aculo.us' effects.js library!");

// This will stop image flickering in IE6 when elements with images are moved
try {
	document.execCommand("BackgroundImageCache", false, true);
} catch(e) {}

var lightwindow = Class.create();	
lightwindow.prototype = {
	//
	//	Setup Variables
	//
	element : null,
	contentToFetch : null,
	windowActive : false,
	dataEffects : [],
	dimensions : {
		cruft : null,
		container : null,
		viewport : {
			height : null,
			width : null,
			offsetTop : null,
			offsetLeft : null
		}
	},
	pagePosition : {
		x : 0,
		y : 0
	},
	pageDimensions : {
		width : null,
		height : null
	},
	preloadImage : [],
	preloadedImage : [],
	galleries : [],
	resizeTo : {
		height : null,
		heightPercent : null,
		width : null,
		widthPercent : null,
		fixedTop : null,
		fixedLeft : null
	},
	scrollbarOffset : 18,
	navigationObservers : {
		previous : null,
		next : null
	},
	containerChange : {
		height : 0,
		width : 0
	},
	activeGallery : false,
	galleryLocation : {
		current : 0,
		total : 0
	},
	//
	//	Initialize the lightwindow.
	//
	initialize : function(options) {
		this.options = Object.extend({
			resizeSpeed : 8,
			contentOffset : {
				height : 20,
				width : 20
			},
			dimensions : {
				image : {height : 250, width : 250},
				page : {height : 250, width : 250},
				inline : {height : 250, width : 250},
				media : {height : 250, width : 250},
				external : {height : 250, width : 250},
				titleHeight : 25
			},
			classNames : {	
				standard : 'lightwindow',
				action : 'lightwindow_action'
			},
			fileTypes : {
				page : ['asp', 'aspx', 'cgi', 'cfm', 'htm', 'html', 'pl', 'php4', 'php3', 'php', 'php5', 'phtml', 'rhtml', 'shtml', 'txt', 'vbs', 'rb'],
				media : ['aif', 'aiff', 'asf', 'avi', 'divx', 'm1v', 'm2a', 'm2v', 'm3u', 'mid', 'midi', 'mov', 'moov', 'movie', 'mp2', 'mp3', 'mpa', 'mpa', 'mpe', 'mpeg', 'mpg', 'mpg', 'mpga', 'pps', 'qt', 'rm', 'ram', 'swf', 'viv', 'vivo', 'wav'],
				image : ['bmp', 'gif', 'jpg', 'png', 'tiff']
			},
			mimeTypes : {
				avi : 'video/avi',
				aif : 'audio/aiff',
				aiff : 'audio/aiff',
				gif : 'image/gif',
				bmp : 'image/bmp',
				jpeg : 'image/jpeg',
				