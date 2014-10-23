Ext.override(Ext.Resizable, {
    onMouseMove : function(e){
        
        if(this.enabled){
            try{// try catch so if something goes wrong the user doesn't get hung

            //var curXY = this.startPoint;
            var curSize = this.curSize || this.startBox;
            var x = this.startBox.x, y = this.startBox.y;
            var ox = x, oy = y;
            var w = curSize.width, h = curSize.height;
            var ow = w, oh = h;
            var mw = this.minWidth, mh = this.minHeight;
            var mxw = this.maxWidth, mxh = this.maxHeight;
            var wi = this.widthIncrement;
            var hi = this.heightIncrement;

            var eventXY = e.getXY();
            var diffX = -(this.startPoint[0] - Math.max(this.minX, eventXY[0]));
            var diffY = -(this.startPoint[1] - Math.max(this.minY, eventXY[1]));

            var pos = this.activeHandle.position;
            
            switch(pos){
                case "east":
                    w += diffX; 
                    w = Math.min(Math.max(mw, w), mxw);
                    break;
                case "south":
                    h += diffY;
                    h = Math.min(Math.max(mh, h), mxh);
                    break;
                case "southeast":
                    w += diffX; 
                    h += diffY;
                    w = Math.min(Math.max(mw, w), mxw);
                    h = Math.min(Math.max(mh, h), mxh);
                    break;
            }
                       
            if(this.preserveRatio){
                switch(pos){
                    case "southeast":
                    case "east":
                        if ((x+w) > this.resizeRegion.right){
                            w = this.resizeRegion.right - x;
                        }

                        h = oh * (w/ow);
                        h = Math.min(Math.max(mh, h), mxh);
                        w = ow * (h/oh);

                        if ((y+h) > this.resizeRegion.bottom){
                            h = this.resizeRegion.bottom - y;
                            w = ow * (h/oh);
                        }

                        break;
                    case "south":                    
                        if ((y+h) > this.resizeRegion.bottom){
                            h = this.resizeRegion.bottom - y;
                        }

                        w = ow * (h/oh);
                        w = Math.min(Math.max(mw, w), mxw);
                        h = oh * (w/ow);
                        
                        if ((x+w) > this.resizeRegion.right){
                            w = this.resizeRegion.right - x;
                            h = oh * (w/ow);
                        }                                                
                        break;
                }
            }

            this.proxy.setBounds(x, y, w, h);
            if(this.dynamic){
                this.resizeElement();
            }
            }catch(e){}
        }
        this.fireEvent('onMouseMove');
    }
});


Ext.ux.Spotlight = function(config){
    Ext.apply(this, config);        
    this.bd = Ext.get(config.background);
    if (config.thumbnail) {
        this.thumbnail = Ext.get(config.thumbnail);
    }
}

Ext.ux.Spotlight.prototype = {
    active : false,
    duration: .25,
    easing:'easeNone',

    update : function(){
        this.show(this.custom);
        
        var width = this.custom.getWidth(false);
        var height = this.custom.getHeight(false);
        var top = this.custom.getTop(true) * -1;
        var left = this.custom.getLeft(true) * -1;

        if (this.thumbnail) {
            var rx = this.width / width;
            var ry = this.height / height;
            
            width = Math.round(rx * this.picture.getWidth());
            height = Math.round(ry * this.picture.getHeight());
            top = Math.round(ry * top);
            left = Math.round(rx * left);

            this.thumbnail.setWidth(width);
            this.thumbnail.setHeight(height);            
            this.thumbnail.setStyle('margin-top', top + 'px');
            this.thumbnail.setStyle('margin-left', left + 'px');
            
        }
    },
    
    createElements : function(){
        
        this.top = this.bd.createChild({cls:'x-spotlight',style:'font-size:0px;'});
        this.right = this.bd.createChild({cls:'x-spotlight'});
        this.left = this.bd.createChild({cls:'x-spotlight'});
        this.bottom = this.bd.createChild({cls:'x-spotlight'});
        this.all = new Ext.CompositeElement([this.right, this.left, this.top, this.bottom]);
    },
    
    show : function(el, callback, scope){
        this.el = el;
        if(!this.right){
            this.createElements();
        }
        if(!this.active){
            this.all.setDisplayed('');
            this.applyBounds(true, false);
            this.active = true;
            Ext.EventManager.onWindowResize(this.syncSize, this);
            this.applyBounds(false, false, callback, scope);
        }else{
            this.applyBounds(false, false, false, callback, scope); // all these booleans look hideous
        }
    },

    hide : function(callback, scope){
        Ext.EventManager.removeResizeListener(this.syncSize, this);
        this.applyBounds(true, true, callback, scope);
    },

    doHide : function(){
        this.active = false;
        this.all.setDisplayed(false);
    },

    syncSize : function(){
        this.applyBounds(false, false);
    },

    applyBounds : function(basePts, doHide, callback, scope){

        var rg = this.el.getRegion();
        var parent = Ext.get(this.el.dom.parentNode);
        
        var dw = this.bd.getWidth();
        var dh = this.bd.getHeight();
        
        var dl = parent.getLeft();
        var dt = parent.getTop();
                
        var c = 0, cb = false;

        this.right.setBounds(
                rg.right,
                basePts ? dh : rg.top,
                dw - rg.right + dl,
                basePts ? 0 : (dh - rg.top + dt),
                cb);

        this.left.setBounds(
                dl,
                dt,
                rg.left - dl,
                basePts ? 0 : rg.bottom - dt,
                cb);

        this.top.setBounds(
                basePts ? dw : rg.left,
                (rg.top - dt == 1) ? -1 : (rg.top - dt == 0) ? -2 : dt,
                basePts ? 0 : dw - rg.left + dl,
                rg.top - dt,
                cb);       
        
        this.bottom.setBounds(
                dl,
                rg.bottom,
                basePts ? 0 : rg.right - dl,
                dh - rg.bottom + dt,
                cb);

        
        if(doHide){
            this.doHide();
        }
        if(callback){
            Ext.callback(callback, scope, [this]);
        }
    },

    destroy : function(){
        this.doHide();
        Ext.destroy(
                this.right,
                this.left,
                this.top,
                this.bottom);
        delete this.el;
        delete this.all;
    }
};


Ext.namespace('Ext.ux');

/**
 *
 * @class ImageCroperPanel
 * @extends Ext.Panel
 */
Ext.ux.ImageCroperPanel = Ext.extend(Ext.Panel, {
	initComponent : function(){
        var defConfig = {
            //autoWidth:true,
            //autoHeight:true,
            border:false
        };
        
        Ext.applyIf(this,defConfig);
        
		Ext.ux.ImageCroperPanel.superclass.initComponent.call(this); 
        this.addEvents('load');
	},
	
    afterRender : function(){
    	var wh = this.ownerCt.getSize();
        Ext.applyIf(this, wh);
    	Ext.ux.ImageCroperPanel.superclass.afterRender.call(this);
    			
    },	
		
	loadImage : function(img) {
        
        this.src = img;
        if (this.thumbnail)
            this.thumbnail = Ext.get(this.thumbnail);
		
        if (typeof this.body.dom.childNodes[1] == 'undefined') {
                       
            this.custom = this.body.createChild({
                tag:'div',
                id:'custom',
                style : {
                    margin:0,
                    padding:0,
                    position:'absolute',
                    top:0,
                    display:'block',
                    width:this.customWidth,
                    height:this.customHeight,
                    background:'url(' + Ext.BLANK_IMAGE_URL + ')'
                },
                children:[{
                    id:'custom-top',
                    tag:'div',        
                    cls:'custom-hline',
                    style:{
                        top: 0
                    },
                    children:[{
                        tag:'img',
                        src:Ext.BLANK_IMAGE_URL
                    }]
                },{
                    id:'custom-bottom',
                    tag:'div',        
                    cls:'custom-hline',
                    style:{
                        bottom: 0
                    },
                    children:[{
                        tag:'img',
                        src:Ext.BLANK_IMAGE_URL
                    }]
                },{
                    id:'custom-left',
                    tag:'div',        
                    cls:'custom-vline',
                    style:{
                        left: 0
                    }
                },{
                    id:'custom-right',
                    tag:'div',        
                    cls:'custom-vline',
                    style:{
                        right: 0
                    }
                }]
            });
            
            var childs = this.custom.dom.childNodes;
            for (var i = 0; i < childs.length; i++){
                Ext.get(childs[i].id).setOpacity(.3);
            }

            this.picture = this.body.createChild({
                tag:'img',
                id:'background',
                src:Ext.BLANK_IMAGE_URL
            });
            
            this.picture.on('load', this.onLoad, this);
                        
            var spot = new Ext.ux.Spotlight({
                animate:false,
                background:this.body.id,
                picture:this.picture,
                custom:this.custom,
                width:this.customWidth,
                height:this.customHeight,
                thumbnail:this.thumbnail,
                easing:'easeOut',
                duration:.3
            });

                
            var resizer = new Ext.Resizable(this.custom, {
                preserveRatio:this.preserveRatio,
                dynamic:true,
                minWidth:50,
                pinned:false,
                transparent:true,
                draggable:true,
                wrap:false,
                pinned:false,
                constrainTo:this.body,
                listeners:{
                    resize:function(){
                        this.dd.constrainTo(this.constrainTo, 0, false);
                        spot.update();
                    },
                    onMouseMove:function(){
                        spot.update();
                    }
                }
            });
            
            resizer.dd.onDrag = function(){
                spot.update();
                resizer.dd.constrainTo(resizer.constrainTo, 0, false);
            };
            
            this.resizer = resizer;
            this.spot = spot;
            
        } else {
            this.picture = Ext.get(this.picture.id);
        }
        
        this.picture.set({
            src:img
        });
        
        if (this.thumbnail){
            this.thumbnail.set({
                src:img
            });
        }
    },
    
    clear: function() {
        if (this.body.dom.childNodes[1]) {
            this.picture.remove();
            this.custom.remove();
            this.spot.destroy();
            if (this.thumbnail){
                this.thumbnail.set({
                    src:Ext.BLANK_IMAGE_URL
                });
            }
        }
    },
    
    onLoad: function() {
        
        this.onResize();
        
        this.custom.setStyle({
            top:0, left:0
        });

        if (this.thumbnail){
            this.thumbnail.set({
                width:this.body.getWidth()
            });
        }

        this.resizer.resizeTo(this.customWidth, this.customHeight);
        this.fireEvent('load', this);
    },
    
    onResize: function() {
        if (this.body.dom.childNodes[1]) {

            var picture = this.body.createChild({
                tag:'img',
                src:this.src
            });
        
            picture.on('load', function(){
                this.originalWidth = picture.getWidth();
                this.originalHeight = picture.getHeight();
                picture.remove();

                var width = this.findParentByType('panel').getSize().width;
                
                var height = Math.round((width / this.originalWidth) * this.originalHeight);

                this.picture.setWidth(width);
                this.picture.setHeight(height);
                
                this.resizer.resizeTo(this.custom.getWidth(), this.custom.getHeight());
                
            }, this);
            
        }
        this.fireEvent('resize', this);
    },

    getCropRegion : function(){
        var width = this.custom.getWidth(false);
        var height = this.custom.getHeight(false);
        var top = this.custom.getTop(true);
        var left = this.custom.getLeft(true);
        
        if (this.thumbnail) {
            var rx = this.customWidth / width;
            var ry = this.customHeight / height;
            
            width = Math.round(rx * this.picture.getWidth());
            height = Math.round(ry * this.picture.getHeight());
            top = Math.round(ry * top);
            left = Math.round(rx * left);
        }
        return({
            width:width,
            height:height,
            top:top,
            left:left,
            src:this.src
        });

    }    
	
});
 
Ext.reg('imagecroperpanel',Ext.ux.ImageCroperPanel); 