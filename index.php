<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Vocab Quiz</title>
</head>
<body>
This page is for testing yourself on the Vocabulary...<br><br>

To start your quiz you must first have a text document saved on your computer somewhere<br><br>

The file must be in the format:<br><br>

word-definition;word-definition;word-definition;word-definition;word-definition;word-definition;
<br><br>

<b>IMPORTANT: No spaces between - or ;</b> (there may be spaces in the definition though, dashes in words or definition are to be represented as #, semicolons in definition are to be represented as ,)<br><br>

The file may contain as many words as you want (don't be rediculous though)<br><br>

Example:<br><br>

asdf.txt<br>
Abate-to lessen;square#root-two and only two identical factors of a specific number;Contentions-quarrelsome;
<br><br>


The resulting page will be matching...

<form action="quiz.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="500000">
  <input name="fileupload" type="file"><br>
  <input type="submit">
</form>


<a href="quiz.php?predef=10_23">Quiz for October 23</a><br>
<a href="quiz.php?predef=11_13">Study Words Given on November 13 for a Future Date</a><br>
<a href="quiz.php?predef=12_15">Quiz for December 15</a><br>
<a href="quiz.php?predef=exam1">Exam for Semester 1</a><br>
<a href="quiz.php?predef=feb_11">Huck Finn Words (February 11)</a><br>
<a href="quiz.php?predef=mar_18">Mockingbird Words (March 18)</a><br>
<a href="quiz.php?predef=apr_2">Mockingbird Words (April 2)</a><br>
<a href="quiz.php?predef=exam2">Exam for Semester 2</a><br>
<a href="quiz.php?predef=11_14">Vocab Packets 1-5 DEFINITION MATCHING ONLY</a><br>
<a href="quiz.php?predef=11_27">Gawain/Arthur vocab</a><br>
<a href="quiz.php?predef=exam11_1">Exam vocab</a><br><br>
<a href="quiz.php?predef=bioex3_1">Biology exam Lectures 21-29</a><br><br>
<a href="quiz.php?predef=aa">Amino Acids BIOLCHEM 415</a><br>
<a href="quiz.php?predef=aa_oneletter">Amino Acids BIOLCHEM 415 - One Letter</a><br><br>
<a href="quiz.php?predef=genetics1">Genetics List 1</a><br><br>
<a href="quiz.php?predef=sugars">Sugars</a><br><br>
<a href="quiz.php?predef=chem303_01">CHEM 303 - Metal Enzymes and Such</a><br>
<a href="quiz.php?predef=chem303_02">CHEM 303 - Point Groups, Symmetry Operations, Ligand Field</a><br>
<a href="quiz.php?predef=chem303_03">CHEM 303 - Roles of Iron</a><br>
</body>
</html>