;
(function($){
    $.fn.extend({
        dialog_mod: function(){
            return this.each(function(){
                $(this).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        "Confirm": function(){
                            AddRow();                            
                        }
                    }
                });
            });
        },
        serializeFormJSON: function(){
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';                    
                }
            });
            return o;
        },
        createMenuUI: function(options){
            var opt = $.extend({
                data: [{}]
            }, options);
            return this.each(function(){
                var li = '';
                $.each(opt.data, function(id, item){
                    li += "<li><a href=\"" + item.url + "\"><span class=\"ui-icon ui-icon-disk\"></span>" + item.descr + "</a></li>";
                });
                $(this).empty();
                $("<ul>" + li + "</ul>").menu().appendTo(this);                
            });
        },
        notification: function(options){
            var opt = $.extend({
                mess: "",
                image: false,
                urlImage: "../Images/",
                cssStyle: "notifica",
                css: {}
            }, options);

            return this.each(function(){
                $(this).addClass(opt.cssStyle);
                if(opt.image) { $(this).append("<img src=\"" + opt.urlImage + "\" />"); }
                $(this).append("<span>" + opt.mess + "</span>");
                $(this).css(opt.css);
            });
        },
        loading: function(options){            
            return this.each(function(){
                if (options == 'open') {
                    $(this).dialog({
                        autoOpen: true,
                        modal: true
                    });
                } else {
                    $(this).dialog(options)
                };
            });            
        },
        jalert: function(options){
            var opt = $.extend({
                message : ''
            }, options);

            $(this).html('<span>'+opt.message+'</span>');
            $(this).dialog({
                autoOpen: true,
                modal: true,
                buttons: {
                    'Aceptar' : function(){ 
                        $(this).dialog('close');
                    }
                },
                create: function(event, ui){
                    $(this).parents('div:first').find(".ui-dialog-titlebar").remove();
                },
                close: function(){
                    $(this).remove();
                }
            });
        }
    });
})(jQuery);


