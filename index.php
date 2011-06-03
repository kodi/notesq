<!DOCTYPE html>
<html>
    <head>

        <script src="resources/js/jquery-1.4.2.min.js"></script>
        <script src="resources/js/script.js"></script>
        
        <link type="text/css" rel="stylesheet" media="all" href="resources/css/style.css" /> 
        
    </head>
    <body>

   
   
   
    <div id="new_account_holder" class="form_holder">
        <span id="new_account_messages"></span>
        <form id="new_account" name="new_account" action="" method="post">
            <label for="username">Username</label><input type="text" name="username" id="username" />
            <label for="password">Password</label><input type="password" name="password" id="password" />
            <label for="password2">Retype password</label><input type="password" name="password2" id="password2" />
            <label for="email">E-mail</label><input type="email" name="email" id="email" />
            <input type="submit" />
        </form>   
    </div>
    
    
        <script>
            
            $('#new_account').submit( function(e){
                e.preventDefault();
                var data = "what=newuser&username=" + $('#username').val() + "&password=" + $('#password').val() + "&password2=" + $('#password2').val() + "&email=" + $('#email').val();
                
                $('#new_account_messages').html('');
                
                $.ajax({
                    data: data,
                    url: "lib/ajax.php",
                    type: 'post',
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        for(var i in data.error){
                            $('#new_account_messages').append("<span class='error'>" + data.error[i] + "</span>");
                        }
                        
                        if (data.success){
                            $('#new_account_messages').append("<span class='success'>" + data.success + "</span>");
                            $('#new_account').hide();
                        }
                    }
                })
                
            });
        
        </script>
    
    
    </body>
</html>