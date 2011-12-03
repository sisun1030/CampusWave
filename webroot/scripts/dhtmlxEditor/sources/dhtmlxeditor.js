//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
You allowed to use this component or parts of it under GPL terms
To use it on other terms or get Professional edition of the component please contact us at sales@dhtmlx.com
*/
/*_TOPICS_
@0:Formatting
@1:Getting data 
*/


/**
*  	@desc: Constructor of dhtmlxEditor object.
*	@param: id - parent object id
*	@param: skin - skin name for editor
*  	@type:   public
*/


function dhtmlXEditor(base, skin) {
	
	var that = this;
	
	// skin config
	this.skin = (skin||dhtmlx.skin||"dhx_skyblue");
	
	this.iconsPath = dhtmlx.image_path||"../../codebase/imgs/";
	
	// configure base
	if (typeof(base) == "string") base = document.getElementById(base);
	
	this.base = base;
	while (this.base.childNodes.length > 0) this.base.removeChild(this.base.childNodes[0]);
	
	// search for extended toolbar
	this._isToolbar = (this.initDhtmlxToolbar!=null&&window.dhtmlXToolbarObject!=null?true:false);
	if (!this._isToolbar) {
		this.tbData = "<div class='dhxeditor_"+this.skin+"_btns'>"+
					"<a href='javascript:void(0);' onclick='return false;' tabindex='-1'><div actv='b' cmd='applyBold' class='dhxeditor_"+this.skin+"_tbbtn btn_bold'></div></a>"+
					"<a href='javascript:void(0);' onclick='return false;' tabindex='-1'><div actv='i' cmd='applyItalic' class='dhxeditor_"+this.skin+"_tbbtn btn_italic'></div></a>"+
					"<a href='javascript:void(0);' onclick='return false;' tabindex='-1'><div actv='u' cmd='applyUnderscore' class='dhxeditor_"+this.skin+"_tbbtn btn_underline'></div></a>"+
					"<a href='javascript:void(0);' onclick='return false;' tabindex='-1'><div actv='c' cmd='clearFormatting' class='dhxeditor_"+this.skin+"_tbbtn btn_clearformat'></div></a>"+
					"<div class='verline_l'></div><div class='verline_r'></div>"+
				"</div>";
	} else {
		this.tbData = "";
	}
	
	// configure base for dhxcont
	var pos = (_isIE?this.base.currentStyle["position"]:window.getComputedStyle(this.base, null).getPropertyValue("position"));
	if (!(pos == "relative" || pos == "absolute")) this.base.style.position = "relative";
	this.base.innerHTML = this.tbData+"<div style='position:absolute; width: 100%; overflow: hidden;'></div>";
	
	// init dhxcont
	var dhxCont = new dhtmlXContainerLite(this.base);
	dhxCont.skin = this.skin;
	dhxCont.setContent(this.base.childNodes[(this._isToolbar?0:1)]);
	var ofs = (this._isToolbar?0:this.base.childNodes[0].offsetHeight);
	this.base.adjustContent(this.base, ofs);
	
	this.cBlock = document.createElement("DIV");
	this.cBlock.className = "dhxcont_content_blocker";
	this.cBlock.style.display = "none";
	this.base.appendChild(this.cBlock);
	
	// editable area
	this.editor = document.createElement("IFRAME");
	this.editor.className = "dhxeditor_mainiframe_"+this.skin;
	this.editor.frameBorder = 0;
	if (_isOpera) this.editor.scrolling = "yes";
	
	// onAccess event - focus/blue as param
	var fr = this.editor;
	if (_isIE) {
		fr.onreadystatechange = function(a) {
			if (fr.readyState == "complete") {
				try {
					this.contentWindow.document.body.attachEvent("onfocus",function(e){that._ev("focus",e);});
					this.contentWindow.document.body.attachEvent("onblur",function(e){that._ev("blur",e);});
					this.contentWindow.document.body.attachEvent("onkeydown",function(e){that._ev("keydown",e);});
					this.contentWindow.document.body.attachEvent("onkeyup",function(e){that._ev("keyup",e);});
					this.contentWindow.document.body.attachEvent("onkeypress",function(e){that._ev("keypress",e);});
					this.contentWindow.document.body.attachEvent("onmouseup",function(e){that._ev("mouseup",e);});
					this.contentWindow.document.body.attachEvent("onmousedown",function(e){that._ev("mousedown",e);});
					this.contentWindow.document.body.attachEvent("onclick",function(e){that._ev("click",e);});
				} catch(e){};
			}
		}
		fr.onunload = function() {
			this.contentWindow.document.body.detachEvent("onfocus",function(){that._ev("focus",event);});
			this.contentWindow.document.body.detachEvent("onblur",function(){that._ev("blur",event);});
			this.contentWindow.document.body.detachEvent("onkeydown",function(){that._ev("keydown",event);});
			this.contentWindow.document.body.detachEvent("onkeyup",function(){that._ev("keyup",event);});
			this.contentWindow.document.body.detachEvent("onkeypress",function(){that._ev("keypress",event);});
			this.contentWindow.document.body.detachEvent("onmouseup",function(){that._ev("mouseup",event);});
			this.contentWindow.document.body.detachEvent("onmousedown",function(){that._ev("mousedown",event);});
			this.contentWindow.document.body.detachEvent("onclick",function(){that._ev("click",event);});
		}
	} else {
		var e = this.editor;
		fr.onload = function() {
			this.contentWindow.addEventListener("focus",function(e){that._ev("focus",e);},false);
			this.contentWindow.addEventListener("blur",function(e){that._ev("blur",e);},false);
			this.contentWindow.addEventListener("keydown",function(e){that._ev("keydown",e);},false);
			this.contentWindow.addEventListener("keyup",function(e){that._ev("keyup",e);},false);
			this.contentWindow.addEventListener("keypress",function(e){that._ev("keypress",e);},false);
			this.contentWindow.addEventListener("mouseup",function(e){that._ev("mouseup",e);},false);
			this.contentWindow.addEventListener("mousedown",function(e){that._ev("mousedown",e);},false);
			this.contentWindow.addEventListener("click",function(e){that._ev("click",e);},false);
		}
		fr.onunload = function(){
			this.contentWindow.removeEventListener("focus",function(e){that._ev("focus",e);},false);
			this.contentWindow.removeEventListener("blur",function(e){that._ev("blur",e);},false);
			this.contentWindow.removeEventListener("keydown",function(e){that._ev("keydown",e);},false);
			this.contentWindow.removeEventListener("keyup",function(e){that._ev("keyup",e);},false);
			this.contentWindow.removeEventListener("keypress",function(e){that._ev("keypress",e);},false);
			this.contentWindow.removeEventListener("mouseup",function(e){that._ev("mouseup",e);},false);
			this.contentWindow.removeEventListener("mousedown",function(e){that._ev("mousedown",e);},false);
			this.contentWindow.removeEventListener("click",function(e){that._ev("click",e);},false);
		}
	}
	
	this._ev = function(t,ev) {
		this.callEvent("onAccess",[t,ev]);
	}
	this._focus = function() {
		if (_isIE) {
			this.editor.contentWindow.document.body.focus();
		} else {
			this.editor.contentWindow.focus();
		}
	}
	
	
	this.base.attachObject(this.editor);
	this.edWin = this.editor.contentWindow;
	this.edDoc = this.edWin.document;
	
	this._prepareContent = function(saveContent, roMode) {
		
		var storedContent = "";
		if (saveContent === true && this.getContent != null) storedContent = this.getContent();
		
		var edDoc = this.editor.contentWindow.document;
		edDoc.open("text/html", "replace");
		if (_isOpera) {
			edDoc.write("<html><head><style> html, body { overflow:auto; padding:0px; padding-left:1px !important; height:100%; margin:0px; font-family:Tahoma; font-size:10pt; background-color:#ffffff;} </style></head><body "+(roMode!==true?"contenteditable='true'":"")+" tabindex='0'></body></html>");
		} else {
			if (window._KHTMLrv) {
				edDoc.write("<html><head><style> html {overflow-x: auto; overflow-y: auto;} body { overflow: auto; overflow-y: scroll;} html,body { padding:0px; padding-left:1px !important; height:100%; margin:0px; font-family:Tahoma; font-size:10pt; background-color:#ffffff;} </style></head><body "+(roMode!==true?"contenteditable='true'":"")+" tabindex='0'></body></html>");
			} else {
				if (_isIE) {
					// && navigator.appVersion.indexOf("MSIE 9.0")!= -1
					edDoc.write("<html><head><style> html {overflow-y: auto;} body {overflow-y: scroll;} html,body { overflow-x: auto; padding:0px; padding-left:1px !important; height:100%; margin:0px; font-family:Tahoma; font-size:10pt; background-color:#ffffff;} </style></head><body "+(roMode!==true?"contenteditable='true'":"")+" tabindex='0'></body></html>");
				} else {
					edDoc.write("<html><head><style> html,body { overflow-x: auto; overflow-y: scroll; padding:0px; padding-left:1px !important; height:100%; margin:0px; font-family:Tahoma; font-size:10pt; background-color:#ffffff;} </style></head><body "+(roMode!==true?"contenteditable='true'":"")+" tabindex='0'></body></html>");
				}
			}
		}
		edDoc.close();
		
		if (_isIE) edDoc.contentEditable = (roMode!==true); else edDoc.designMode = (roMode!==true?"On":"Off");
		
		if (_isFF) try { edDoc.execCommand("useCSS", false, true); } catch(e) {}
		
		if (saveContent === true && this.setContent != null) this.setContent(storedContent);
		
	}
	
	// fix
	this._prepareContent();
	
	this.setIconsPath = function() {
		// fake
	}
	this.init = function(){
		// fake
	}
	
	this.setSizes = function() {
		var ofs = (this._isToolbar?0:this.base.childNodes[0].offsetHeight);
		this.base.adjustContent(this.base, ofs);
	}
	
	this._resizeTM = null;
	this._resizeTMTime = 100;
	this._doOnResize = function() {
		window.clearTimeout(that._resizeTM);
		that._resizeTM = window.setTimeout(function(){if(that.setSizes)that.setSizes();}, that._resizeTMTime);
	}
	this._doOnUnload = function() {
		window.detachEvent("onresize", this._doOnResize);
		window.removeEventListener("resize", this._doOnResize, false);
	}
	dhtmlxEvent(window, "resize", this._doOnResize);
	
	// toolbar buttons
	this.base.childNodes[0].onselectstart = function(e) {
		e = e||event;
		e.cancelBubble = true;
		e.returnValue = false;
		if (e.preventDefault) e.preventDefault();
		return false;
	}
	for (var q=0; q<this.base.childNodes[0].childNodes.length-2; q++) {
		this.base.childNodes[0].childNodes[q].childNodes[0].onmousedown = function(e) {
			var t = this.getAttribute("cmd");
			if (typeof that[t] == "function") {
				that[t]();
				that.callEvent("onToolbarClick",[this.getAttribute("actv")]);
			}
			return false;
		}
		this.base.childNodes[0].childNodes[q].childNodes[0].onclick = function(e) {
			return false;
		}
	}
	
	/**
	* @desc: carried out execCommand method
	* @type: private
	* @param: name - name of the command
	* @param: param - command parameter
	*/
	this.runCommand = function(name,param){
		if(this._roMode===true)return;
		if(arguments.length < 2) param = null;
		if(_isIE)this.edWin.focus();
		try {
			var edDoc = this.editor.contentWindow.document
			edDoc.execCommand(name,false,param);
		}catch(e){
			
		}
		if(_isIE){
			this.edWin.focus();
			var self = this;
			window.setTimeout(function(){
				self.edWin.focus();
			},1);
		}
	}
	
	// commands
	this.applyBold = function() {
		this.runCommand("Bold");
	}
	this.applyItalic = function() {
		this.runCommand("Italic");
	}
	this.applyUnderscore = function() {
		this.runCommand("Underline");
	}
	this.clearFormatting = function() {
		this.runCommand("RemoveFormat");
	}
	
	// attach extended toolbar
	if (this._isToolbar) this.initDhtmlxToolbar();
	
	// events
	dhtmlxEventable(this);
	
	dhtmlxEvent(this.edDoc, "click", function(e){
		var ev = e||window.event;
		var el = ev.target||ev.srcElement;
		that.showInfo(el);
	});
	
	if (_isOpera) {
		dhtmlxEvent(this.edDoc, "mousedown", function(e){
			var ev = e||window.event;
			var el = ev.target||ev.srcElement;
			that.showInfo(el);
		});
	}
	
	dhtmlxEvent(this.edDoc, "keyup", function(e){
		var ev = e||window.event;
		var key = ev.keyCode;
		var el = ev.target||ev.srcElement;
		if((key==37)||(key==38)||(key==39)||(key==40)||(key==13))
			that.showInfo(el);
	});
	
	//var that = this;
	this.attachEvent("onFocusChanged", function(state){if(that._doOnFocusChanged)that._doOnFocusChanged(state);});
	
	
	/**
	* @desc: return style hash for the element
	* @type: private
	*/
	this.showInfo = function(el){
		
		var el = (this.getSelectionBounds().end)?this.getSelectionBounds().end : el;

		if(!el) return
		try{
			if(this.edWin.getComputedStyle){
				var st = this.edWin.getComputedStyle(el, null);
				var fw = ((st.getPropertyValue("font-weight")==401)?700:st.getPropertyValue("font-weight"));
				this.style =  { fontStyle	: st.getPropertyValue("font-style"),
					fontSize	: st.getPropertyValue("font-size"),
					textDecoration	: st.getPropertyValue("text-decoration"),
					fontWeight	: fw,
					fontFamily	: st.getPropertyValue("font-family"),
					textAlign	: st.getPropertyValue("text-align")
				};
				if(window._KHTMLrv){/*if Safari*/
					this.style.fontStyle = st.getPropertyValue("font-style");
					this.style.vAlign = st.getPropertyValue("vertical-align");
					this.style.del = this.isStyleProperty(el,"span","textDecoration","line-through");
					this.style.u = this.isStyleProperty(el,"span","textDecoration","underline");
				}
			}
			else{
				var st = el.currentStyle;
				this.style =  { fontStyle	: st.fontStyle,
					fontSize	: st.fontSize,
					textDecoration	: st.textDecoration,
					fontWeight	:  st.fontWeight,
					fontFamily	: st.fontFamily,
					textAlign	: st.textAlign
				};
			}
			this.setStyleProperty(el,"h1");
			this.setStyleProperty(el,"h2");
			this.setStyleProperty(el,"h3");
			this.setStyleProperty(el,"h4");
			if(!window._KHTMLrv){
				this.setStyleProperty(el,"del");
				this.setStyleProperty(el,"sub");
				this.setStyleProperty(el,"sup");
				this.setStyleProperty(el,"u");
			}
			this.callEvent("onFocusChanged",[this.style, st])
		}
		catch(e){ return null}
	}
	/**
	* @desc: gets selection bounds: root, start and end nodes
	* @type: private
	*/
	this.getSelectionBounds = function(){
   		var range, root, start, end;
		if(this.edWin.getSelection){ 
      		var selection = this.edWin.getSelection();
      		range = selection.getRangeAt(selection.rangeCount-1);
      		start = range.startContainer;
      		end = range.endContainer;
			root = range.commonAncestorContainer;
      		if(start.nodeName == "#text") root = root.parentNode; 
	    	if(start.nodeName == "#text") start = start.parentNode;
			if (start.nodeName.toLowerCase() == "body") start = start.firstChild;
      		if(end.nodeName == "#text") end = end.parentNode;
			if (end.nodeName.toLowerCase() == "body") end = end.lastChild;
			if(start == end) root = start;	
			return {
        		root: root,
        		start: start,
        		end: end
      		}
		}else if(this.edWin.document.selection){ 
			range = this.edDoc.selection.createRange()
      		if(!range.duplicate) return null;
			root = range.parentElement();
      		var r1 = range.duplicate();
      		var r2 = range.duplicate();
      		r1.collapse(true);
      		r2.moveToElementText(r1.parentElement());
      		r2.setEndPoint("EndToStart",r1);
      		start = r1.parentElement();
      		r1 = range.duplicate();
      		r2 = range.duplicate();
      		r2.collapse(false);
      		r1.moveToElementText(r2.parentElement());
      		r1.setEndPoint("StartToEnd", r2);
      		end = r2.parentElement();
	   		if (start.nodeName.toLowerCase() == "body") start = start.firstChild;
			if (end.nodeName.toLowerCase() == "body") end = end.lastChild;
			
      		if(start == end) root = start;
     	 	return {
         		root: root,
         		start: start,
         		end: end
			}
   		}
   		return null 
	}
	/**
	* @desc: gets html content of editor document
	* @type: public
	* @topic: 1
	*/
	this.getContent = function(){
		if (!this.edDoc.body) {
			return "";
		} else {
			if (_isFF) return this.editor.contentWindow.document.body.innerHTML.replace(/<\/{0,}br\/{0,}>\s{0,}$/gi,"");
			return this.edDoc.body.innerHTML;
		}
	}
	/**
	* @desc: sets content to editor document
	* @type: public
	* @param: html - html string which should be set as editor content 
	* @topic: 0
	*/
	this.setContent = function(str){
		if (this.edDoc.body) {
			if (navigator.userAgent.indexOf('Firefox') != -1) {
				if (typeof(this._ffTest) == "undefined") {
					this.editor.contentWindow.document.body.innerHTML = "";
					this.runCommand("InsertHTML", "test");
					this._ffTest = (this.editor.contentWindow.document.body.innerHTML.length > 0);
				}
				if (this._ffTest) {
					// FF 4.x+
					this.editor.contentWindow.document.body.innerHTML = str;
				} else {
					// FF 2.x, 3.x
					this.editor.contentWindow.document.body.innerHTML = "";
					if (str.length == 0) str=" ";
					this.runCommand("InsertHTML", str);
				}
			} else {
				this.editor.contentWindow.document.body.innerHTML = str;
			}
			this.callEvent("onContentSet",[]);
		} else {
			//var that = this;
			dhtmlxEvent(this.edWin, "load", function(e){
				that.setContent(str);
			});
		}
	}
	/**
	* @desc: sets content from the html document to editor document
	* @type: public
	* @param: url - path to the html page 
	* @topic: 0
	*/
	this.setContentHTML = function(url){
		(new dtmlXMLLoaderObject(this._ajaxOnLoad,this,false,true)).loadXML(url);
	}
	this._ajaxOnLoad = function(obj,a,b,c,loader){
		if(loader.xmlDoc.responseText) obj.setContent(loader.xmlDoc.responseText); 
	}
};

function dhtmlXContainerLite(obj) {
	
	var that = this;
	
	this.obj = obj;
	this.dhxcont = null;
	
	this.setContent = function(data) {
		this.dhxcont = data;
		this.dhxcont.innerHTML = "<div style='position: relative; left: 0px; top: 0px; overflow: hidden;'></div>";					 
		this.dhxcont.mainCont = this.dhxcont.childNodes[0];
		this.obj.dhxcont = this.dhxcont;
	}
	
	this.obj._genStr = function(w) {
		var s = ""; var z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		for (var q=0; q<w; q++) s += z.charAt(Math.round(Math.random() * (z.length-1)));
		return s;
	}
	
	this.obj.adjustContent = function(parentObj, offsetTop, marginTop, notCalcWidth, offsetBottom) {
		
		this.dhxcont.style.left = (this._offsetLeft||0)+"px";
		this.dhxcont.style.top = (this._offsetTop||0)+offsetTop+"px";
		//
		var cw = parentObj.clientWidth+(this._offsetWidth||0);
		if (notCalcWidth !== true) this.dhxcont.style.width = Math.max(0, cw)+"px";
		if (notCalcWidth !== true) if (this.dhxcont.offsetWidth > cw) this.dhxcont.style.width = Math.max(0, cw*2-this.dhxcont.offsetWidth)+"px";
		//
		var ch = parentObj.clientHeight+(this._offsetHeight||0);
		this.dhxcont.style.height = Math.max(0, ch-offsetTop)+(marginTop!=null?marginTop:0)+"px";
		if (this.dhxcont.offsetHeight > ch - offsetTop) this.dhxcont.style.height = Math.max(0, (ch-offsetTop)*2-this.dhxcont.offsetHeight)+"px";
		if (offsetBottom) if (!isNaN(offsetBottom)) this.dhxcont.style.height = Math.max(0, parseInt(this.dhxcont.style.height)-offsetBottom)+"px";
		
		// main window content
		if (this._minDataSizeH != null) {
			// height for menu/toolbar/status bar should be included
			if (parseInt(this.dhxcont.style.height) < this._minDataSizeH) this.dhxcont.style.height = this._minDataSizeH+"px";
		}
		if (this._minDataSizeW != null) {
			if (parseInt(this.dhxcont.style.width) < this._minDataSizeW) this.dhxcont.style.width = this._minDataSizeW+"px";
		}
		
		if (notCalcWidth !== true) {
			this.dhxcont.mainCont.style.width = this.dhxcont.clientWidth+"px";
			// allow border to this.dhxcont.mainCont
			if (this.dhxcont.mainCont.offsetWidth > this.dhxcont.clientWidth) this.dhxcont.mainCont.style.width = Math.max(0, this.dhxcont.clientWidth*2-this.dhxcont.mainCont.offsetWidth)+"px";
		}
		
		var menuOffset = (this.menu!=null?(!this.menuHidden?this.menuHeight:0):0);
		var toolbarOffset = (this.toolbar!=null?(!this.toolbarHidden?this.toolbarHeight:0):0);
		var statusOffset = (this.sb!=null?(!this.sbHidden?this.sbHeight:0):0);
		
		// allow border to this.dhxcont.mainCont
		this.dhxcont.mainCont.style.height = this.dhxcont.clientHeight+"px";
		if (this.dhxcont.mainCont.offsetHeight > this.dhxcont.clientHeight) this.dhxcont.mainCont.style.height = Math.max(0, this.dhxcont.clientHeight*2-this.dhxcont.mainCont.offsetHeight)+"px";
		this.dhxcont.mainCont.style.height = Math.max(0, parseInt(this.dhxcont.mainCont.style.height)-menuOffset-toolbarOffset-statusOffset)+"px";
		
	}
	/**
	*   @desc: attaches a dhtmlxToolbar to a window
	*   @type: public
	*/
	this.obj.attachToolbar = function() {
		var toolbarObj = document.createElement("DIV");
		toolbarObj.style.position = "relative";
		toolbarObj.style.overflow = "hidden";
		toolbarObj.id = "dhxtoolbar_"+this._genStr(12);
		this.dhxcont.insertBefore(toolbarObj, this.dhxcont.childNodes[(this.menu!=null?1:0)]);
		this.toolbar = new dhtmlXToolbarObject(toolbarObj.id, this.skin);
		if (that.skin == "dhx_web") {
			this.toolbarHeight = 32;
			this.dhxcont.className = "dhtmlx_editor_extended_"+that.skin;
			
		} else {
			this.toolbarHeight = toolbarObj.offsetHeight+(this._isLayout&&this.skin=="dhx_skyblue"?2:0);
		}
		this.toolbarId = toolbarObj.id;
		if (this._doOnAttachToolbar) this._doOnAttachToolbar("init");
		this.adjust();
		return this.toolbar;
	}
	/**
	*   @desc: attaches an object into a window
	*   @param: obj - object or object id
	*   @param: autoSize - set true to adjust a window to object's dimension
	*   @type: public
	*/
	this.obj.attachObject = function(obj, autoSize) {
		if (typeof(obj) == "string") obj = document.getElementById(obj);
		if (autoSize) {
			obj.style.visibility = "hidden";
			obj.style.display = "";
			var objW = obj.offsetWidth;
			var objH = obj.offsetHeight;
		}
		this._attachContent("obj", obj);
		if (autoSize && this._isWindow) {
			obj.style.visibility = "visible";
			this._adjustToContent(objW, objH);
			/* this._engineAdjustWindowToContent(this, objW, objH); */
		}
	}
	this.obj.adjust = function() {
		if (this.skin == "dhx_skyblue") {
			if (this.toolbar) {
				if (this._isWindow || this._isLayout) {
					document.getElementById(this.toolbarId).style.height = "29px";
					this.toolbarHeight = document.getElementById(this.toolbarId).offsetHeight;
					if (this._doOnAttachToolbar) this._doOnAttachToolbar("show");
				}
				if (this._isCell) {
					document.getElementById(this.toolbarId).className += " in_layoutcell";
				}
				if (this._isAcc) {
					document.getElementById(this.toolbarId).className += " in_acccell";
				}
			}
		}
	}
	// attach content obj|url
	this.obj._attachContent = function(type, obj, append) {
		// clear old content
		while (that.dhxcont.mainCont.childNodes.length > 0) { that.dhxcont.mainCont.removeChild(that.dhxcont.mainCont.childNodes[0]); }
		// attach
		if (type == "obj") {
			if (this._isWindow && obj.cmp == null && this.skin == "dhx_skyblue") {
				this.dhxcont.mainCont.style.border = "#a4bed4 1px solid";
				this.dhxcont.mainCont.style.backgroundColor = "#FFFFFF";
				this._redraw();
			}
			that.dhxcont._frame = null;
			that.dhxcont.mainCont.appendChild(obj);
			that.dhxcont.mainCont.style.overflow = (append===true?"auto":"hidden");
			obj.style.display = "";
		}
	}
	
	this.obj._dhxContDestruct = function() {
		
		while (this.dhxcont.mainCont.childNodes.length > 0) this.dhxcont.mainCont.removeChild(this.dhxcont.mainCont.childNodes[0]);
		this.dhxcont.mainCont.innerHTML = "";
		this.dhxcont.mainCont = null;
		try { delete this.dhxcont["mainCont"]; } catch(e){};
		
		while (this.dhxcont.childNodes.length > 0) this.dhxcont.removeChild(this.dhxcont.childNodes[0]);
		this.dhxcont.innerHTML = "";
		this.dhxcont = null;
		try { delete this["dhxcont"]; } catch(e){};
		
		// clear methods
		this._genStr = null;
		this._attachContent = null;
		this._dhxContDestruct = null;
		this.adjust = null;
		this.attachObject = null;
		this.moveContentTo = null;
		this.adjustContent = null;
		this.attachToolbar = null;
		
	}
	
}

//editor
(function(){
	dhtmlx.extend_api("dhtmlXEditor",{
		_init:function(obj){
			return [obj.parent, obj.skin ];
		},
		content:"setContent"
	},{});
})();


dhtmlXEditor.prototype.unload = function() {
	
	if (!this._isToolbar) {
		// clear default button events
		while (this.base.childNodes[0].childNodes.length > 0) {
			if (this.base.childNodes[0].childNodes[0].tagName && String(this.base.childNodes[0].childNodes[0].tagName).toLowerCase() == "a") {
				this.base.childNodes[0].childNodes[0].childNodes[0].onclick = null;
				this.base.childNodes[0].childNodes[0].childNodes[0].onmousedown = null;
				this.base.childNodes[0].childNodes[0].removeChild(this.base.childNodes[0].childNodes[0].childNodes[0]);
			}
			this.base.childNodes[0].removeChild(this.base.childNodes[0].childNodes[0]);
		}
	} else {
		// unload toolbar
		this._unloadExtModule();
	}
	
	this.base.childNodes[0].onselectstart = null;
	this.tbData = null;
	
	// clear events
	this.detachAllEvents();
	
	// remove editor
	if (_isIE) this.editor.onreadystatechange = null; else this.editor.onload = null;
	this.editor.parentNode.removeChild(this.editor);
	this.editor.onunload = null;
	this.editor = null;
	this.edDoc = null;
	this.edWin = null;
	
	// clear container features
	this.base._dhxContDestruct();
	this.base._idd = null;
	this.base.name = null;
	while (this.base.childNodes.length > 0) this.base.removeChild(this.base.childNodes[0]);
	this.base = null;
	this.cBlock = null;
	
	this._isToolbar = null;
	this._resizeTM = null;
	this._resizeTMTime = null;
	this.skin = null;
	this.iconsPath = null;
	
	this._ajaxOnLoad = null;
	this._ev = null;
	this._focus = null;
	this._prepareContent = null;
	this._doOnResize = null;
	this._doOnUnload = null;
	this.setIconsPath = null;
	this.init = null;
	this.setSizes = null;
	this.runCommand = null;
	this.applyBold = null;
	this.applyItalic = null;
	this.applyUnderscore = null;
	this.clearFormatting = null;
	this.attachEvent = null;
	this.callEvent = null;
	this.checkEvent = null;
	this.eventCatcher = null;
	this.detachEvent = null;
	this.detachAllEvents = null;
	this.showInfo = null;
	this.getSelectionBounds = null;
	this.getContent = null;
	this.setContent = null;
	this.setContentHTML = null;
	this.setReadonly = null;
	this.isReadonly = null;
	this.unload = null;
	
};

dhtmlXEditor.prototype.setReadonly = function(mode) {
	this._roMode = (mode===true);
	this._prepareContent(true, this._roMode);
	this.cBlock.style.display = (this._roMode?"":"none");
};

dhtmlXEditor.prototype.isReadonly = function(mode) {
	return (this._roMode||false);
};
