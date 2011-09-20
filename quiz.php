<?

// initialize an variable for scoping
$fileContents = '';

// Here I check if there a predefined quiz was specified
// If it was specified, I will just load the quiz from the file
// Otherwise I expect that the user submitted a custom quiz
//  in the form of a file upload
$preDefined = array(
    '10_23' => 'Vocab_for_Oct_23.txt',
    '11_13' => 'Vocab_for_Nov_13.txt',
    'exam1' => 'Exam_Semester_1.txt',
    '12_15' => 'Vocab_for_Dec_15.txt',
    'feb_11' => 'Feb_11.txt',
    'mar_18' => 'March_18.txt',
    'apr_2' => 'April_2.txt',
    'exam2' => 'vocab_exam2.txt',
    '11_14' => 'vocab_quiz_nov_14.txt',
    '11_14_2' => 'vocab_nov_14_2.txt',
    '11_27' => '11_27.txt',
    'exam11_1' => 'exam11_1.txt',
    'bioex3_1' => 'bio3_1.txt',
    'aa' => 'aa.txt',
    'aa_oneletter' => 'aa_oneletter.txt',
    'genetics1' => 'genetics1.txt',
    'sugars' => 'sugars.txt'
);
   
$predef = $_GET['predef'];
$predefFile = $preDefined[$predef];
if($predef && $predefFile) {
    $filename = 'predef/' . $predefFile;
    $fileContents = file_get_contents($filename);
} else {
    // Here I am expecting that they uploaded a custom quiz in a text file
    echo '[Technical Information]<BR>';
    
    // Here I am splitting apart the uploaded filename by the period character
    //  I am attempting to figure out the file extension.
    // If the file extension is not ".txt" then I am exiting, figuring that they attempted
    //  to upload something malicious
    // TODO: Strip HTML from the inputted file, this is currently vulnerable to a HTML based XSS attack
    $file_name = explode('.', str_replace(' ', '_', basename($_FILES['fileupload']['name'])));
    $ext = array_pop($file_name);
    if($ext != 'txt') {
        die('File Extension Was Not Valid : Expecting txt');
    }
    
    // "Upload" the file by moving it from its temporary location to the "target path"
    $target_path = $_FILES['fileupload']['name'];
    if(move_uploaded_file($_FILES['fileupload']['tmp_name'], $target_path)) {
        echo 'File moved/uploaded successfully<BR>';
    } else {
        die('There was an error uploading the file, this file may be too large, please try again!<BR>[/Technical Information]');
    }
    
    // Get the contents of the file so we can build the quiz off of it
    $fileContents= file_get_contents($target_path);
    
    // Then delete the file, we don't want people's crap sitting around on the server
    if(unlink($target_path)) {
        echo 'File Deleted Successfully<BR>';
    }
    echo '[/Techincal Information]<BR>';
}

// NOTE: Word/Definition pairs are split by a semicolon ';'
// The word is split from the definition by a dash
// The program expects that the file ends with a semicolon
// Example: 'word-definition;anotherword-anotherdefinition;'

// Start Tag for HTML form that will point at the "answer" page
echo '<form action="answer.php" method="post">';

// Here I am splitting apart the quiz file by the semicolon so I get the word/definition parts
//  all separated
// NOTE: array_pop removes the last entry of an array, I am using this to remove the empty/null
// entry at the end of the array which is caused by the quiz file ending with a semicolon.
$parts = explode(';', $fileContents);
array_pop($parts);

// Here I am going to put the words and definitions into arrays
// NOTE: I am using the foreach loop to do this, but I am also keeping
//  track of the number of words so I can do some debugging.  I am lazy here
//  and hardcoded a limit on the number of words.  You'll see this catch in a couple lines
// I could probably avoid this laziness by dynamically creating the $alphabet array, but I'll do
// that another day
$wordcount = 0;
$word = array();
$def = array();
$answer = array();
foreach($parts as $part) {
    // Here I am using explode to split the string by the dash (the separator character I
    //  decided to use to separate the word and the definition)
    $tempword = explode('-', $part);
    $word[$wordcount+1] = $tempword[0];
    $def[$wordcount+1] = $tempword[1];
    $wordcount++;
}
if($wordcount > 78) { // I'm a lazyass
    die("The programmer was too lazy to write the program to accomadate more than seventy-eight words... go yell at them");
}

// $def is the definition array, I'm copying it to $tempdef so I can shuffle it 
// $word is the word array, I'm copying it to $tempword so I can shuffle it aswell
$tempdef = $def;
shuffle($tempdef);
$tempword = $word;
shuffle($tempword);

// TODO: fix $alphabet
// NOTE to readers: This is a really shitty way to define an alphabet array.
// If I were to be doing this correctly I would make the php script build the alphabet only as big
//  as is needed and would assign teh values as needed
$alphabet=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','BB','CC','DD','EE','FF','GG','HH','II','JJ','KK','LL','MM','NN','OO','PP','QQ','RR','SS','TT','UU','VV','WW','XX','YY','ZZ','AAA','BBB','CCC','DDD','EEE','FFF','GGG','HHH','III','JJJ','KKK','LLL','MMM','NNN','OOO','PPP','QQQ','RRR','SSS','TTT','UUU','VVV','WWW','XXX','YYY','ZZZ');

// Here I am looping through each of the words (After shuffling)\
for($i = 1; $i <= $wordcount; $i++) {

    // $origwordpos will find the position of the current word inside the shuffled $tempword array
    $origwordpos = array_search($tempword[($i-1)], $word);
    
    // $tempdefpos will find the position of the matching definition in the shuffled definitions
    $tempdefpos = array_keys($tempdef, $def[$origwordpos]);
    $tempdefpos = $tempdefpos[0];
    
    // Then assign the answer for that word as the corresponding letter from the temp array
    $answer[$i] = $alphabet[$tempdefpos];
}

// Now I echo out hidden inputs with the words, definitions and answers so they can get passed
//  to the answer page.  Technically someone could just cheat and look at the source code if
//  they wanted the answers.  But since this wasn't intended as a "grading" tool and as more of a
//  study tool I didn't go through the trouble of parsing the answers to either a cookie or a server-
//  side text file which would ensure the client would not be able to cheat.
for($i = 1; $i <= $wordcount; $i++) {
    echo "<input type=\"hidden\" name=\"word".($i)."\" value=\"".$tempword[$i-1]."\">";
    echo "<input type=\"hidden\" name=\"def".$alphabet[$i-1]."\" value=\"".$tempdef[$i-1]."\">";
    echo "<input type=\"hidden\" name=\"answer".$i."\" value=\"".$answer[$i]."\">";
}
?>
<table width="100%">
    <tr>
        <td><h3>Words</h3></td>
        <td><h3>Definitions</h3></td>
    </tr>

    <tr>
        <td>
<?

// Here I prepare the dropdown "option" values
// basically I have an <option> tag for each of the alphabet options that there are words for
for($j = 1; $j <= $wordcount; $j++) {
    $dropdownvalues .= "<option value=\"".$alphabet[$j-1]."\">".$alphabet[$j-1]."</option>";
}

// Now I am going to echo dropdown boxes for each of the words
$i = 0;
foreach($tempword as $theword) {
    echo "<select name=\"question".($i+1)."\">";
    echo $dropdownvalues;
    echo "</select> ";
    echo $theword."<BR>";
    $i++;
}
?>
        </td>
        <td>
<?

// Now I print out the answer options
$i = 0;
foreach($tempdef as $thedef) {
    echo $alphabet[$i].") ";
    echo $thedef."<BR>";
    $i++;
}
?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit"></td>
    </tr>
</table>
</form>