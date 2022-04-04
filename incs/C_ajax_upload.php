<?php declare(strict_types=1);

define('jj', "<br>\n");
  
touch('/var/www/anetizer.com/fred/ABR');
chmod('/var/www/anetizer.com/fred/ABR', 0777);

exec('ln -s /var/www/anetizer.com/fred/ABR  XYZ');

//================================================================
Class C_ajax_upload
{ 

//================================================================
public function setConstants(string $page) : string
{
# $_SESSION = [];
  session_start();

  # $_SESSION = [];
  if('reset'===$page) :
    $page = 'upload';
    unset($_SESSION['srcDir']) ;
    $_SESSION = [];
  endif; 

  if('upload'=== $page) :
    # SET DIRECTORY ALL WITH A TRAILING SLASH
      $_SESSION['time'] = $_SESSION['time'] ?? date('y_m_d_H_i_s/');
      $_SESSION['time'] = '22_04_04_11_44_46/';
    # IMAGE URL
      $tmp = 'https://fred.anetizer.com/ABR/';
      if(LOCALHOST) :
        $tmp = 'http://localhost/anetizer.com/fred/ABR/';
      endif;
      $_SESSION['srcUrl'] = $tmp .$_SESSION['time'] ;

    # IMAGE PATH
      $tmp  = UPLOADS .$_SESSION['time'] .'/';
      $_SESSION['srcDir']  = str_replace('//', '/', $tmp);

    # SET UPLOADS PERMISSIONS  
      $tmp = $_SESSION['srcDir'];
      if( is_dir($tmp) ) :
        // allow user to add more files
      else:  
        if(is_dir(UPLOADS)) :
          fred(UPLOADS, 'UPLOADS');
        else:
          fred('NO DIRECTORY ==> '.UPLOADS);
        endif;  
        @chmod(UPLOADS, 0777);
        @mkdir(UPLOADS, 0777, TRUE);
        mkdir($tmp, 0777, TRUE);
      endif;
      $ok = chmod($tmp, 0777);
  endif;

  return 'Hoping everything is Hunky Dory :)';
}//

//================================================================
public function getPage() : string
{
  $result = ''; // 'reset';
  if( isset($_GET['page']) ) :
    $result = htmlspecialchars($_GET['page']);  
  endif;  

  return $result;
}//

//================================================================
private function getThumb
(
  string $imgSource,
  string $imgResized,
  string $bgColour = 'SNOW' //'SNOW'
)
: string 
{
  if(strpos($imgResized, $bgColour) ) :
    $bgColour = '#dfd';
  else:  
    $bgColour = 'SNOW';
  endif;
  $dims   = getimagesize($_SESSION['srcDir'] .$imgResized);

  $iImg = filesize($_SESSION['srcDir'] .$_SESSION['srcImg']) ;
  $iDim = filesize($_SESSION['srcDir'] .$imgResized);
  $perc = number_format(100*$iDim/$iImg) .'%';

  $size  = number_format((float) filesize( $_SESSION['srcDir'].$imgResized) );

  $url    = $_SESSION['srcUrl'] .$imgResized;     
  $ONLINE = 'https://fred.anetizer.com/ABR/999999/jb-in-shorts.jpg';
  $url    = 'XYZ/' .$_SESSION['time'] .$imgResized;     

  $img  = <<< ____EOT
    <a href="$url" download> 
      <img 
        src="$url" 
        width="42"  
        alt="#"
      >
      <!-- a href="$url"> Download </a --> 
    </a>
____EOT;

  $dims     = getimagesize($_SESSION['srcDir'] .$imgResized);
  $tmpDims  = $dims[0] .'x' . $dims[1] .'px';
  $imgSource = $_SESSION['srcUrl'] .$imgResized;

  $result = <<< ____EOT
      <tr style="background-color: $bgColour;">
        <td> $imgResized </td>
        <td  class="hvr"> $img </td>
        <td> $perc </td>
        <td> $size bytes </td>
        <td> $tmpDims </td>
      </tr>
____EOT;

  return $result;
}//

//================================================================
public function getTable
(
  Object $obj, 
  string $imgSource  = '$_SESSION["srcImg"]',
  string $imgResized = 'SPECIFIC THUMB NAME'
): string 
{
  $result = <<< ____EOT
    <table>
      <tr>
        <th> Filename   </th>
        <th> Thumbs     </th>
        <th> Difference </th>
        <th> Filesize   </th>
        <th> Dimensions </th>
      </tr>
____EOT;

# GET MINUMUM FILESIZE
  $aImgs = ['jpg','png','gif','webp'];
  $min = 11111111111111111111110;
  $SHRUNK = $_SESSION['dims'] .'.';
  foreach($aImgs as $key => $type) :
    # echo '<br>',
    # $iSize = filesize($_SESSION['srcDir'].'SHRUNK.'.$type);
    $iSize = filesize($_SESSION['srcDir'].$SHRUNK .$type);
    if($iSize < $min) :
      $min = $iSize;
      $bgColor = $type;
    endif;
  endforeach;
     
  # $new = '123x456';   
  # $thb = 'New-' .$new;   
  $imgSource  = $_SESSION['imgSrc'];
    $result .= $this->getThumb($imgSource, $_SESSION['srcImg']);
    $tmp     = $_SESSION['dims'];

    $result .= $this->getThumb($imgSource, $tmp .'.jpg',  $bgColor);
    $result .= $this->getThumb($imgSource, $tmp .'.gif',  $bgColor);
    $result .= $this->getThumb($imgSource, $tmp .'.png',  $bgColor);
    $result .= $this->getThumb($imgSource, $tmp .'.webp', $bgColor);

  $result .= '</table>'
           . '<h3 class="tac"> Click thumbnail to download </h3>'
           ;

  return $result;
}//

}///

# ================================================================
function delTree($dir)
{
  $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) :
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    endforeach;
    return rmdir($dir);
}//

# ================================================================
function fred($val, string $title='No title')
{
  $val = print_r($val, TRUE);

  echo '';
    echo $tmp = <<< ___EOT
      <pre style="width:88%; margin:1rem auto; background:AQUA;color:#000; text-align:left"
        >$title ==> $val
      </pre>
___EOT;
}//

# ================================================================
function vd($val, string $title='No title')
{
  $val = var_dump($val, TRUE);

  echo '';
    echo $tmp = <<< ___EOT
      <pre style="width:88%; margin:1rem auto; background:AQUA;color:#000; text-align:left"
        >$title ==> $val
      </pre>
___EOT;
}//
