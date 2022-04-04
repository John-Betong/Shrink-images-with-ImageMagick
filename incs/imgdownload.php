<?php declare(strict_types=1);

  if(isset($_GET['img']) ) :
    $_IMG = htmlspecialchars($_GET['img']);
  else:
    header('Location: index.php?page=upload');
  endif;  

session_start();
        
# OBJ Class
  require 'C_ajax_upload.php';
  $obj  = New C_ajax_upload();
  $page = $obj->getPage(); 

  $dims = getimagesize($_SESSION['srcDir'].$_IMG) ;

?>
<!DOCTYPE HTML><html lang="en-GB">
<head>
<link rel="stylesheet" type="text/css" href="style.css">  
<title> ImageMagick Conversions </title>
</head>
<body>
  <header>
    <h1> 
      <a href="https://fred.anetizer.com/shrinker/index-001.php"> 
        ImageMagick  Conversions 
      </a> 
    </h1>
    <ul>
      <li> <a href="?page=upload"> Upload      </a> </li>
      <li> <a href="?page=show">Show images</a></li>      
    </ul>
  </header>

  <main>
    <section>
      <h2> Image name: <?= htmlspecialchars($_GET['img']) ?> </h2>
      <p>
        <details>
          <summary> Image dimensions: </summary>
          <?php fred($dims, 'Dimensions'); ?>
        </details>

    	  <img 
          src   = "<?= $_SESSION['srcUrl'] .$_IMG ?>" 
          <?= $dims[3] ?>
          alt="#"
        >
        <br> 
        <h3> 
          Right click image and select 
          <br>
          "Save Image as " 
        </h3>
        <br>  
      </p>

    </section>
  </main>	

  <?php require 'footer.php'; ?>
</body>
</html>