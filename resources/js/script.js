        var activeWindow = 1; // since that there are multiple windows we need to know which is active
        var saveReady = false; // only if document is changed we will save him
        var currId = 0; // current Id of document that's open, have to check this b/c of multi windows
        var newType = 'document'; // add new document/group
        var groupId = 0; // id of selected group
    
        $('.add_new').click( function(e){
            e.preventDefault(); 
            newType = $(this).attr('rel');
            $('#overlay_new_what').html(newType);
            $('#overlay_back, #overlay').show();
        });
        
    
        $('#overlay_back').click( function(){
            $(this).hide();
            $('#overlay').hide();
        });
    
        function loadTitles_old(){
            $.ajax({
                url: 'lib/ajax.php?what=titles',
                dataType: 'json',
                success: function(data){
                    $('#titles').html('');
                    for (var i in data){
                        $('#titles').append("<a href='lib/ajax.php?what=content&id=" + data[i].id + "' class='title'>" + data[i].title + "</a>");
                    }
                }
            });
        }
        
        /**
         * Load titles and groups and put them in sidebar
         */
        function loadTitles(){
            $.ajax({
                url: 'lib/ajax.php?what=titles',
                dataType: 'json',
                success: function(data){
                    $('#titles').html('');
                    for (var i in data){                        
                        $('#titles').append("<div class='group_title_holder'><div class='title_group' rel='" + i + "'>" + data[i].groupTitle + "</div><div class='group_title_colapse'></div></div>");
                        for (var j in data[i].data){
                            if(data[i].data[j].id){
                                $('#titles').append("<a href='lib/ajax.php?what=content&id=" + data[i].data[j].id + "' class='title title_group_docs_" + i + "'>" + data[i].data[j].title + "</a>");
                            }
                        }
                    }
                }
            });
        }        
        
        $('#titles').delegate('.title_group', 'click', function(e){
            e.preventDefault();
            groupId = $(this).attr('rel');
            $('.title_group').removeClass('group_active');
            $(this).addClass('group_active');
        });
        
         $('#titles').delegate('.group_title_colapse', 'click', function(e){
            e.preventDefault();
            groupId = $(this).prev().attr('rel');
            $('.title_group_docs_' + groupId).slideToggle('fast');
            $(this).toggleClass('group_title_expand');
        });       
        
        
        
        loadTitles();
        
        /**
         *  Set active window
         */
        $('.content_panel').click( function(){
            
            var $this = $(this);
            
            save('change window', function(){           
                activeWindow = $this.attr('rel');
                $('.content_panel').removeClass('active_window');
                $('#content_' + activeWindow).addClass('active_window');
            
            });
        });
        
        
        
        $('#titles').delegate('.title', 'click', function(e){
            e.preventDefault();
            
            var href = this.href;
            var $this = $(this);
            
            save('new document opening', function(){

                //$('.title').removeClass('active');
                //$this.addClass('active');
            
                $.ajax({
                    url: href,
                    dataType: 'json',
                    success: function(data){
                        $('#cont_' + activeWindow).html('').val('');
                        $('#cont_' + activeWindow).html(data.content).val(data.content);
                        $('#content_' + activeWindow + '_title').html(data.title);
                        $('.content_panel').removeClass('active_window');
                        $('#content_' + activeWindow).addClass('active_window');
                        currId = data.id;
                        $('#id').val(currId);
                    }
                });   
                
            });
            
            saveReady = false;
         
        });
        
        
        
        $('.content_form').submit( function(e){
            e.preventDefault();
            save('user request');          
        
        });
        
        
        $('#new').submit( function(e){
           
            e.preventDefault();
            var $this = $(this);
            var data = "what=new" + newType + "&name=" + $('#new_name').val() + "&group=" + groupId;
            
            $.ajax({
                url: $this.attr('action'),
                dataType: 'json',
                data: data,
                type: 'post',
                success: function(){
                    loadTitles();
                    groupId = 0;
                }
            })
        })
        
        /**
         *  If saveReady is set to false we will not save document
         *
         * @param place - from where save is called
         * @param callback - method that should be triggered after save
         */
        function save(place, callback){
            
            callback = callback || '';
            
            if (!saveReady) {
                if( typeof callback === "function"){
                    callback();
                }
                return false;
            }

            place = place || "autosave";
            var data = "what=save&content=" + $('#cont_' + activeWindow).val() + "&id=" + currId;
            
            $.ajax({
                type: 'post',
                data: data,
                dataType: 'json',
                url: 'lib/ajax.php',
                success: function(data){
                    $('#messages').fadeIn().html('Message: ' + data.message + ' from ' + place).delay(3000).fadeOut();
                    if( typeof callback === "function"){
                        callback();
                    }
                }
            });
            
            saveReady = false;
            
        }
        
        
        /**
         *  Set autosave interval
         */
        setInterval(function(){
            save('autosave');
        }, 60*1000);
        
        
        
        var scale = false;
        $('#scale_1').mousedown( function(e){
            scale = true;
        });
        $(document).mouseup( function(e){
            scale = false;
        });        
        $(document).mousemove( function(e){
            if (scale && e.pageX > 205 && e.pageX < 605) {
                $('#titles').css('width', e.pageX + 'px');
                $('#panels').css('margin-left', e.pageX + 'px');
                $('#scale_1').css('left', e.pageX + 'px');
                //$('#scale_2').css('margin-left', (e.pageX + 5 )/2 + 'px');
            }
        });
    
    
        /**
         *  If text content is changed we're ready for save
         */
        $('.content_panel_text').bind('change keydown', function(){
            console.log('text changed');
            saveReady = true;
            
        });
        
        
        window.onload = function() {
            document.getElementById('titles').onselectstart = function() {return false;} // ie
            document.getElementById('titles').onmousedown = function() {return false;} // mozilla        
        }

        $('.panel_1').click( function(){
            $('#content_2').addClass('none');
            $('#content_1').addClass('whole');
        });
        
        $('.panel_2').click( function(){
            $('.content_panel').removeClass('content_panel_vertical none whole').addClass('content_panel_horizontal');
        });         
        
        $('.panel_2a').click( function(){
            $('.content_panel').removeClass('content_panel_horizontal none whole').addClass('content_panel_vertical');
        });