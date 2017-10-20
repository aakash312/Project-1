<?php
//ini_set('display_errors', 'On');                            
//error_reporting(E_ALL);

echo"<center> <h1> <u> PROJECT-1 </u> </h1> </center>";
echo "<body style='background-color:#B0C4DE'>";
echo  "<center> <b>Attn: Prof. Keith Willams </b> <br> </center> ";
echo "<center> <b>TA: Ikjyot Singh Gujral </b><br></center> ";
$a= date('y-m-d',time()) ;
echo "<center><b> Date: $a </b></center>";

// echo date(' l | jS \of F Y | h:i:s A ') ;


class project {                                              


public static function autoload($class) {
include $class . '.php';
}
}
spl_autoload_register(array('project', 'autoload'));
$obj = new main();                                           
class main {
public function __construct() {
$pageRequest = 'uploadForm';
if(isset($_REQUEST['page'])) {
$pageRequest = $_REQUEST['page'];
}
$page = new $pageRequest;
if($_SERVER['REQUEST_METHOD'] == 'GET') {
$page->get();
} else {
$page->post();
}
}
}
abstract class page {
protected $html;
public function __construct() {
$this->html .= '<html>';
$this->html .= '<link rel="stylesheet" href="styles.css">';
$this->html .= '<body>';
$this->html .= '<center>';
}
public function __destruct() {
$this->html .= '</body></html> </center > ' ;
stringFunctions::printThis($this->html);
}
public function get() {
echo 'default get message';
}
public function post() {
print_r($_POST);
}
}
class stringFunctions {             
static public function printThis($inputText) {
return print($inputText);
}
}
class uploadForm extends page
{
public function get() {                          
$form =  '<center> <form action="index.php?page=uploadForm" method="POST" enctype="multipart/form-data"></center> ';
$form .= '<center> <input type="file" name="fileToUpload" id="fileToUpload"></center> ';
echo '<center> <br> </center>';
$form .= '<br> <center> <input type="submit" value="Upload file" name="submit"> </center> ';
$form .= '</form>';

$this->html .= htmlTags::headingOne('Select the file to be uploaded.');
 $this->html .= $form;
 }
 public function post() {                         
 $target_dir = "uploads/";
 $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
 $filename = $_FILES["fileToUpload"]["name"];
 if (file_exists($target_file)) {
 unlink($target_file);
 }
 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 header("Location: index.php?page=htmlTable&filename=$filename");
 }
 }
 }
 class htmlTags {                
 static public function headingOne($text) {
 return '<h1>' . $text . '</h1>';
 }
 static public function tableFormat() {
 echo "<table cellpadding='5px' border='1px' style='border-collapse: collapse'>";
 }
 static public function tableHeader($text) {
 echo '<th bgcolor="#AFEEEE " style="font-size: large">'.$text.'</th>';
 }
 static public function tableContent($text) {
 
 echo '<td bgcolor="#FFFFFF">' .$text.' </td>';
 
 
 }
 static public function breakTableRow() {
 echo '</tr>';
 }

 }
 class htmlTable extends page {                         
 public function get() {
  $csv = $_GET['filename'];
  chdir('uploads');                                     
  $file = fopen($csv,"r");
  htmlTags::tableFormat();               
  $row = 1;
  while (($data=fgetcsv($file))!== FALSE){    
  foreach($data as $value) {
  if ($row == 1) {
   htmlTags::tableHeader($value);
   }else{
   htmlTags::tableContent($value);
   }
   }
   $row++;
   htmlTags::breakTableRow();
   }
   fclose($file);
           }
	       }
	       ?>

