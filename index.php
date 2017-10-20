 <?php
 //ini_set('display_errors', 'On');                            
 //error_reporting(E_ALL);

 echo"<center> <h1> <u> PROJECT-1 </u> </h1> </center>";  // Displays PROJECT-1 in center in bold with underline 
 echo "<body style='background-color:#B0C4DE'>"; // Sets background color 
 echo  "<center> <b>Attn: Prof. Keith Willams </b> <br> </center> "; // Displays Prof. Keith Williams in center in bold 
 echo "<center> <b>TA: Ikjyot Singh Gujral </b><br></center> "; // Displays Ikjyot... in center in bold
 $a= date('y-m-d',time()) ; // s variable which stores current date 
 echo "<center><b> Date: $a </b></center>"; // displays date in center in bold 

 // echo date(' l | jS \of F Y | h:i:s A ') ;

 //Class to load classes it finds the file when the program starts to fail for calling a missing class
 class project {                                              
 public static function autoload($class) {
 //any file name or folder can be put here 
 include $class . '.php';
 }
 }
 spl_autoload_register(array('project', 'autoload'));
 $object = new main();  // instantiating                                          
 class main {
 public function __construct() 
 {
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
 stringfun::printThis($this->html);
 }
 public function get() {
 echo 'Defaut GET  message';
 }
 public function post() {
 print_r($_POST);
 }
 }
 class stringfun {             
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

 $this->html .= format::headingOne('Select the file to be uploaded.');
 $this->html .= $form;
 }
 public function post()// function in which the target directory is
 // specified
 {                          
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
 class format  {                
 static public function headingOne($text) {
 return '<h1>' . $text . '</h1>';
 }
 static public function  alignment($text ) //function for alignment of data 
 {
 echo '<th text-align: right >' .$text.'</th> ';
 }
 static public function formattingtable() // function for formatting the table 
 {
 echo "<table cellpadding='7px' border='1px' style='border-collapse: collapse'>";
 }
 static public function headerintable($text) // function for header in the table with a blue color  
 {
 echo '<th bgcolor="#AFEEEE " style="font-size: large">'.$text.'</th>'; 
 }
 static public function contentintable($text) //function for displaying content in the table with white background 
 {
 echo '<td bgcolor="#FFFFFF">' .$text.' </td>';
 }
 static public function breakT() //function to end <tr > 
 {
 echo '</tr>';
 }

 }
 class htmlTable extends page {                         
 public function get() {
 $csv = $_GET['filename'];
 chdir('uploads');                                     
 $file = fopen($csv,"r");
 format::formattingtable();               
 $rows= 1;
 while (($data=fgetcsv($file))!== FALSE){    
 foreach($data as $val) {
 if ($rows == 1) {
 format::headerintable($val);
 }else{
 format::contentintable($val);
 }
 }
 $rows++;
 format::breakT();
 }
 fclose($file);
 }
 }
 ?>

