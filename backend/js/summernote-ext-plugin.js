 // get template function  
    var tmpl = $.summernote.renderer.getTemplate();
    // add a button   
    $.summernote.addPlugin({
        buttons : {
           // "insertBlock"  is button's namespace.      
           "insertBlock" : function(lang, options) {
               // make icon button by template function          
               return tmpl.iconButton('fa fa-plus', {
                   // callback function name when button clicked 
                   event : 'insertBlock',
                   // set data-value property                 
                   value : 'insertBlock',                
                   hide : true
               });           
           }
        }, 
        
        events : {
           "insertBlock" : function(event, editor, layoutInfo) {
                // Get current editable node
                var $editable = layoutInfo.editable();
                $("#tagSelectionModal").modal("toggle");
           }
        }     
    });
    
    function initBlock(fieldName)
    {
        $("#" + fieldName).summernote({
                toolbar : [
                     ['style', ['style']],
                     ['font', ['bold', 'italic', 'underline', 'clear']],
                     ['fontname', ['fontname']],
                     ['color', ['color']],
                     ['para', ['ul', 'ol', 'paragraph']],
                     ['height', ['height']],
                     ['table', ['table']],
                     ['insert', ['link', 'picture', 'hr']],
                     ['view', ['fullscreen', 'codeview']],
                     ['help', ['help']],
                     ['insert2', ['insertBlock']],
                   ],
                height : "200" 
       });
    }