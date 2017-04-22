<?php
  $referer = $_SERVER['HTTP_REFERER'];
  $arr = explode("=", $referer, 2);
  $id = $arr[1];
  if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

      $expensions= array("jpeg","jpg","png","gif");

      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a picture file.";
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"cdn/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
   else {
     echo 'kys off fam';
   }
   if(!isset($_POST['name']))
   {
     $name = "Anonymous";
   }
   else
   {
     $name = strip_tags($_POST['name']);
     $arr = explode("#", $name, 2);
     if(count($arr) > 1)
     {
       $tripcode = crypt(crypt($arr[1], crypt("your", "own")), crypt(phpversion(), "hash"));
       $name = $arr[0] . "!" . $tripcode;
     }
   }
   $title = strip_tags($_POST['title']);
   $body = strip_tags($_POST['body']);
   $date = date('m/d/y (D) H:i:s');
   $metainfo = '[name="' . $name . '", date="' . $date . '", title="' . $title . '", include="' . $file_name .'"]';


   $filepath = "thread/" . $id . ".txt";
   $newthread_file = fopen($filepath,"a");

   fwrite($newthread_file, $metainfo . "\n");
 	 fwrite($newthread_file, "#" . $body . "\n");
 	 fclose($newthread_file);

   header("Location: thread.php?=" . $id);
   die();
?>
