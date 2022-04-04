<?php declare(strict_typeS=1);

# OBJ Class
  require 'incs/C_ajax_upload.php';
  $obj  = New C_ajax_upload();

session_start();

//================================================================
function fnConvert
(
  string $_SOURCE, 
  string $resized
): bool 
{
  $tmpResized = '/var/www/anetizer.com/fred/ABR/' .$_SESSION['time'] .$resized;
  $ok = touch($tmpResized);
  if(file_exists($tmpResized) ) :
    unlink($tmpResized);
  endif;  
  $ok = touch($tmpResized);
  
  $tmp  = "convert $_SOURCE  -scale 420  -quality 42 $tmpResized";
  exec($tmp, $a, $r);
  usleep(42);

  if($r) :
    echo '<hr>',
      fred($a, 'convert(...) problem $result ==> ' .$r); 
      echo '<h2> Please try again </h2>';
    echo '<hr>'; 
  else:
    echo '.'; # echo '<br>converted file => ' .$resized;  
  endif;

  return (bool) $r;    
}//===================    


// (A) UPLOAD FILE CHECK
$result = "";
if (!isset($_FILES["upfile"]["tmp_name"])) {
  $result = " No file uploaded.";
}

# (B) IS THIS A VALID IMAGE?
  if ($result=="")
  {
    $allowed = ["bmp", "gif", "jpg", "jpeg", "png", "webp"];
    $ext = strtolower(pathinfo($_FILES["upfile"]["name"], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed))
    {
      $result = "$ext file type not allowed - " . $_FILES["upfile"]["name"];
    }
  }

# (C) OPTIONAL - DO NOT OVERRIDE FILE ON SERVER
  if($result=="") :
    $tmpSource   = $_FILES["upfile"]["tmp_name"];
    $tmpSource   = str_replace(' ', '-', $tmpSource);

    $destination = $_FILES["upfile"]["name"];
    $destination = str_replace(' ', '-', $destination);
  endif;

# (D) MOVE UPLOADED FILE OUT OF TEMP FOLDER
  if ($result=="") :

    $_SESSION['srcImg'] = $destination;
  if(file_exists($_SESSION['srcDir'] .$destination) ) :
    unlink($_SESSION['srcDir'] .$destination);
    # fred('GONE', $_SESSION['srcDir'] .$destination);
  endif;  
  $ok = chmod($_SESSION['srcDir'], 0777);
  var_dump($ok);

    if (move_uploaded_file($tmpSource, $_SESSION['srcDir'] .$destination)) :
      if(file_exists($_SESSION['srcDir'] .$destination)) :
        # echo '<br>'.__line__;
      else:
        echo '<br>CANNOT SAVE IMAGE??? ==> line: '.__line__;
      endif;
      # $source = $_SESSION['srcDir'] .$destination;
      $_SESSION['imgSrc'] = $destination;
      # /var/www/anetizer.com/fred/ABR/22_04_04_11_44_46/jb-in-shorts.jpg

      # RESUZE and RENAME ALL THUMBS 
        $olddDir = getcwd();
        chdir($_SESSION['srcDir']); 
          # $tmpName = pvChangeName($destination) ;

          # CHANGE SOURCE IMAGE FILE NAME TEMPORARILY and RESIZE
# echo '<br> Before: '.__line__  ;            
            fnConvert($_SESSION['srcDir'].$_SESSION['srcImg'], 'DIMS.jpg'); 
# echo '<br> After: '.__line__  ;            
          $tmp = getimagesize($_SESSION['srcDir'] .'DIMS.jpg');
          $_SESSION['dims'] = 'thb-' .$tmp[0] .'x' .$tmp[1];
  #        $new = str_replace('tmpName', $_SESSION['dims'], 'tmpName.jpg');
  #        rename($tmpName, $new);

          $source   = $_SESSION['srcDir'] .$_SESSION['imgSrc'];
          $thb_dims = $_SESSION['dims'];
            fnConvert($source, $thb_dims .'.jpg'); 
            fnConvert($source, $thb_dims .'.gif'); 
            fnConvert($source, $thb_dims .'.png'); 
            fnConvert($source, $thb_dims .'.webp');
      chdir($olddDir);

      echo '<p id="show"> <a id="shake" href="?page=show"> Show Conversions </a> </p>';
    else:  
      $result = "Failed to save to $destination";
      echo '<hr><hr>';
    endif;
  endif;

# (E) SERVER RESPONSE
  echo $result=="" ? "" : $result ;
