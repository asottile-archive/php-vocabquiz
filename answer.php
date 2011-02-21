<?// Collect stuff that was sent in post
$post = $_POST;// Here I am going to parse each post value into its corresponding array// Post fields in the form "answerXXX" go to $answer[XXX]// Post fields in the form "defXXX" go to $def[XXX]// Post fields in the form "questionXXX" go to $userchoice[XXX]// Post fields in the form "wordXXX" go to $word[XXX]
foreach($post as $key => $value) {
    if(substr($key, 0, 6)=="answer") {
        $answer[substr($key,6)]=$value;
    } elseif (substr($key,0,3)=="def") {
        $def[substr($key,3)]=$value;
    } elseif (substr($key,0,8)=="question"){
        $userchoice[substr($key,8)]=$value;
    } elseif(substr($key,0,4)=="word") {
        $word[substr($key,4)]=$value;
    }
}// Print out the users choices
echo"Your Choices:<BR><BR>";
foreach ($userchoice as $questionnum => $theanswer) {
    echo $questionnum.") ".$word[$questionnum]." - ".$theanswer.") ".$def[$theanswer];    // If the user did not answer correctly then tell them they screwed up and    //  tell them the correct answer in red
    if($theanswer != $answer[$questionnum]) {
        echo "&nbsp;<span style=\"background-color:#f00;\"><b>INCORRECT ANSWER</b> correct answer was ".$answer[$questionnum]." -> ".$def[$answer[$questionnum]]."</span>";    }
    echo "<BR>";
}// Print out the correct answers for convenience
echo"<BR><BR>Correct Answers:<BR><BR>";
foreach ($answer as $questionnum => $theanswer) {
    echo $questionnum.") ".$word[$questionnum]." - ".$theanswer.") ".$def[$theanswer]."<BR>";
}
?>
<a href="javascript:history.go(-1);">Back</a>