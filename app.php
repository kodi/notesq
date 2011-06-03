<!DOCTYPE html>
<html>
    <head>

        <script src="resources/js/jquery-1.4.2.min.js"></script>
        
        
        <link type="text/css" rel="stylesheet" media="all" href="resources/css/style.css" /> 
        
    </head>
    <body>

        <div id="messages"></div>

            <div class="menu">
                <ul>
                    <li>NECTAR SaaS</li>
                    <li title="new document"><a href="#" id="add_new_document" class="add_new" rel="document">N</a></li>
                    <li title="new group"><a href="#" id="add_new_group" class="add_new" rel="group">G</a></li>
                    <li>L</li>
                </ul>
            </div>


 
        <fieldset id="titles">

        </fieldset>
        
        <div class="scale" id="scale_1"></div>
        

        
        <fieldset id="panels">
            
            <div class="menu">
                <ul>
                    <li class="menu_panels"><a href="#" class="panel_1"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_2"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_2a"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_3"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_3a"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_4"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_4a"></a></li>
                    <li class="menu_panels"><a href="#" class="panel_5"></a></li>
                </ul>
            </div>
            
            
            <fieldset id="content_1" class="content_panel content_panel_horizontal" rel=1>
                <div class="content_holder">
                    <div id="content_1_title" class="content_title"></div>
                    <form id="content_1_form" class="content_form" action="lib/ajax.php?what=save" method="post">
                        <textarea id="cont_1" class="content_panel_text"></textarea>
                        <input type="hidden" name="id" id="id" />
                        <input type="submit" name="submit" class="form_submit"/>
                    </form>
                </div>
            </fieldset>
            
           <div class="scale_horizontal" id="scale_2"></div>
            
            <fieldset id="content_2" class="content_panel content_panel_horizontal" rel=2>
                <div class="content_holder">
                    <div id="content_2_title" class="content_title"></div>
                    <form id="content_2_form" class="content_form" action="lib/ajax.php?what=save" method="post">
                        <textarea id="cont_2" class="content_panel_text"></textarea>
                        <input type="hidden" name="id" id="id" />
                        <input type="submit" name="submit" class="form_submit" />
                    </form>
                </div>
            </fieldset>        
        </fieldset>
        
        
        <div id="overlay_back"></div>
        <div id="overlay">
            <form id="new" class="add_new_form" action="lib/ajax.php" method="post">
                <label for="new">Name of new <span id="overlay_new_what"></span></label>
                <input type="text" name="name" id="new_name" />
                <input type="submit" />
            </form>
            
        </div>
        
        
        
        
    <script src="resources/js/script.js"></script>

    
    
    </body>
</html>