<?php declare(strict_types=1);
 
ini_set('upload_max_filesize', '22M');

define('LOCALHOST', 'localhost'===$_SERVER['SERVER_NAME']);
# define('UPLOADS',   '/var/www/anetizer.com/fred/public_html/shrinker/ABR/');
define('UPLOADS',   '/var/www/anetizer.com/fred/ABR/');

$title = 'ImageMagick Conversions';
$forum = 'https://www.codingforum.net/forum/client-side-development/graphics-and-multimedia-discussions/2435458-imagemagick-great-program-maybe-but-lousy-execution-in-usage-deployment';
$online = 'https://fred.anetizer.com/shrinker/index.php';
$RSYNC  = LOCALHOST 
        ?   '<li> <a href="RSYNC.php">RSYNC</a></li>'      
        : NULL;
$DEBUG  = LOCALHOST 
        ?   '<li> <a href="index.php?page=reset"> DEBUG </a></li>'      
        : NULL;



# IMAGE DEFAU:T VALUES
  $width   = $_SESSION['width']   ?? 222;
  $quality = $_SESSION['quality'] ??  42;

# OBJ Class
  require 'incs/C_ajax_upload.php';
  $obj  = New C_ajax_upload();
  $page = $obj->getPage(); 
  $obj->setConstants($page);


# =================================================================
# =================================================================
?><!DOCTYPE HTML><html lang="en-GB">
<head>
<link rel="stylesheet" type="text/css" href="incs/style.css">  
<title> <?= $title ?> </title>
</head>
<body>
  <header>
  	<h1> <a href="<?=$online?>"> <?= $title ?> </a> </h1>
    <ul>
      <li> <a href="?page=upload"> Upload      </a> </li>
      <li> <a href="?page=show">Show images</a></li>      
      <?= $RSYNC ?>
      <?= $DEBUG ?>
    </ul>
  </header>

  <main>
    <?php 
      if( empty($page) || 'upload'===$page || 'reset'===$page) : ?>
        <section>
          <h2> Please Upload an Image </h2>

          <!-- (A) UPLOAD FORM -->
          <form id="upform" onsubmit="return ajaxup.add();">

            <label> Step: 1 </label>
              <input 
                id     = "upfile" 
                type   = "file" 
                accept = ".png,.gif,.jpg,.webp" 
                multiple required
              >
              <i> Select an image </i>
              <br><br>

            <label for="quality"> Step: 2  </label>
              <input
                id    = "quality"
                name  = "quality" 
                type  = "number" min="1" max="100"
                value = "<?= $quality ?>"
              >
              <i> $_POST['quality'] NOT WORKING </i>
              <!-- i> Quality (range 1..100) </i -->
              <br><br>

            <label for="width"> Step: 3 </label>
              <input 
                id   = "width"
                name = "width" 
                type = "number"  min="10" max="4200"
                value = "<?= $width ?>"
              >
              <i> $_POST['width'] NOT WORKING</i>
              <!-- i> Width (height scaled automatically) </i -->
              <br><br>

            <!-- label for="upfile">Choose an image file:</label -->

            <label> Step: 4 </label>
              <input type="submit" value="Convert">
              <!-- AJAX MESSAGE -->  
              <!-- i> images to above parameters -->
          </form>

          <!-- (B) UPLOAD STATUS -->
          <div id="upstat"></div>
        </section>

    <?php 
      elseif('show'===$page) :
        echo '<section>';
          if( isset($_SESSION['srcUrl']) ):
            echo '<h2> Shrunken images go here: </h2>';
            echo '<div id="table">';
              echo $obj->getTable($obj);
            echo '</div>';  
          else:
            echo '<h2>
              <a href="?page=upload">&nbsp; Please upload an image  </a>
            </h2>';
          endif;  
        echo '</section>';
      endif;
    ?>      
  </main>

  <footer>
    <?php 
      if(1 || isset($_GET['kevin']) ) :
        require 'incs/footer.php'; 
      endif; 
    ?>
  </footer>

  <script src="ajax-upload.js"></script>

</body>
</html><?php 
/*
  <aside>
    <b> Links </b>
    <ul> 
      <li> <a href="?page=upload"> Upload      </a> </li>
      <?php 
        if(isset($_SESSION['srcDir'], $_SESSION['srcImg']) ) :
          if(file_exists($_SESSION['srcDir'] .$_SESSION['srcImg'])) :
            echo '<li><a href="?page=show">Show images</a></li>';
          endif;  
        endif;  
      ?>
      <li> <a href="?page=reset">  <br> RESET  </a> </li>
      <li> <a href="?"> NO QUERY   </a> </li>
    </ul>
  </aside>


          <form style="display:none;" action="?" id="extras" method="post">
            <!-- label for="QWEupfile"> and choose image file</label -->
            <label for="quality"> Step: 1  </label>
            <input
              type = "number" min="1" max="100"
              name = "quality" 
              value = "<?= $quality ?>"
            >
            <i> Quality (range 1..100) </i>
            <br><br>

            <label for="width"> Step: 2 </label>
            <input 
              type="number"  min="10" max="4200"
              name = "width" 
              value = "<?= $width ?>"
            >
            <i> Width (height scaled automatically) </i>
            <br><br>
              <input 
                style="color: RED;"
                type="submit" 
                value="GOOD_Convert"
              >
          </form>

*/
