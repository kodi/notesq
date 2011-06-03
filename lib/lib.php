<?php
/**
 * Access to database
 */
class Data {

    private static $connected = false;

    /**
     * Connect to database only once
     */
    function __construct(){
        
        if( self::$connected ) {
            return true;
        }

        $con = mysql_connect("localhost","root","");
        
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        
        mysql_select_db("nectar", $con);
        
        self::$connected = true;
    }
    


    /**
     *  Return titles 
     */
    function getTitles(){
        
        $query = "SELECT groups.id AS groupId, groups.title AS groupTitle, content.* FROM groups RIGHT JOIN content ON groups.id=content.idGroup
            UNION SELECT groups.id AS groupId, groups.title AS groupTitle, content.* FROM groups LEFT JOIN content ON groups.id=content.idGroup";
        $result = mysql_query($query);
        
        $temp = '';
        
        while($row = mysql_fetch_array($result))
        {
            $id = $row['id'];
            $idGroup = $row['groupId'] ? $row['groupId'] : 0;
            $temp[$idGroup]['data'][$id]['title']   = $row['title'];
            $temp[$idGroup]['data'][$id]['id']      = $id;
            $temp[$idGroup]['groupTitle']           = $row['groupTitle'];
            //var_dump($row);
        }        
        
        $json = json_encode($temp);
        
        echo $json;       
    }
    
    /**
     *  Return content for id
     *
     *  @param $id
     */
    function getContent($id){
        
        $query = "SELECT * FROM content WHERE id=".$id;
        $result = mysql_query($query);
        
        $temp = '';
        
        while($row = mysql_fetch_array($result))
        {
            $temp['content']   = $row['content'];
            $temp['title']     = $row['title'];
            $temp['id']        = $row['id'];
        }        
        
        $json = json_encode($temp);
        
        echo $json;       
    }
    
    function save($content, $id){
  
        $query = "UPDATE content SET content='" . $content . "' WHERE id=" . $id;
        $result = mysql_query($query);

        $msg['message'] = "success";
        
        echo json_encode($msg);
        
    }
    
    function newDoc($name, $group = 0){
        $query = "INSERT INTO content (title, idGroup) VALUES ('$name',$group)";
        $result = mysql_query($query);
        
        $msg['message'] = 'success';
        
        echo json_encode($msg);  
        
    }
    
    
    function newGroup($name){
        $query = "INSERT INTO groups (title) VALUES ('$name')";
        $result = mysql_query($query);
        
        $msg['message'] = 'success '.$name;
        
        echo json_encode($msg);    
        
    }
    
    /**
     *
     */
    function newUser( $username, $password, $password2, $email){
        
        if( strlen($username) < 4 ){
            $msg['error'][] = "Username must be at least 4 characters long";
        }
        
        if( strlen($password) < 8 ){
            $msg['error'][] = "Password must be at least 8 characters long";
        }
        
        if( $password !== $password2 ){
            $msg['error'][] = "Password must be the same in both fields";
        }
        
        if( strlen($email) < 4 ){
            $msg['error'][] = "Email must be at least 4 characters long";
        }
        
        if( count($msg) == 0){
            $password = md5($password);
            $query = "INSERT INTO users (username, password, email) VALUES ('$username','$password','$email')";
            $result = mysql_query($query);
            $msg['success'] = "You're open your account successfully. Please check your email to confirm your address";
        }
        
        
        echo json_encode($msg);
        
    }
    
    

}