<?php declare(strict_types=1);

?>

<section>
  <details>
    <summary> Footer goes here </summary>
    <div style="background-color: SNOW; width:88%; margin:0 auto; font-size: small;">
      Php: <?= phpversion(); ?>
      <br>
      <?= 'upload_max_filesize() ==> ' .ini_get('upload_max_filesize'); ?>
      <?= '$page ==> ' .$page; ?>
      <br>
      whoami ==> <?= exec('whoami', $a); ?>
      <br>
      <?= 'UPLOADS ==> ' .UPLOADS ?>
      <hr>

      <?php 
        echo getcwd();
        echo getcwd() .'/assets/UPLOADS/*';
        # $aUps = glob(getcwd() .'/XYZ/*.*');
        $aUps = glob($_SESSION['srcDir'] .'*.*');
        # echo '<pre> <b> ../../ajax-uploads ==> </b>';
          fred($_SESSION, '$_SESSION');
          fred($_POST,    '$_POST');
          fred($_GET,     '$_GET');
          fred($aUps, '$aUps');
        echo '</pre>';
      ?>
    </div>  
    <br> 
  </details>
</section>
