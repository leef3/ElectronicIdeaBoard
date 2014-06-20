<?php  
$doc = new DOMDocument();
$doc->load("data/data.xml");
$itemList = $doc->getElementsByTagName('document')->item(0);


//User entered or retrieved input information
$owner = $_POST["owner"];
$type = $_POST["type"];
$text = $_POST["text"];
$description = $_POST["description"];
$timestamp = $_POST["timestamp"];

updateXml($itemList, $doc, $owner, $text, $type, $description, $timestamp);

//Add later -- Function from manual entry form cause vars wont initiate properly when SMTP executes

function updateXml($itemListIn, $docIn, $ownerIn, $textIn, $typeIn, $descriptionIn, $timestampIn)
{
    $newItem = $docIn->createDocumentFragment();
    $newItem->appendXML("\r\n\t <item> \r\n\t\t <owner>".$ownerIn."</owner> \r\n\t\t <type>".$typeIn."</type> \r\n\t\t <text>".$textIn."</text> \r\n\t\t <description>".$descriptionIn."</description> \r\n\t\t <timestamp>".$timestampIn."</timestamp> \r\n\t </item> \r\n");
    $itemListIn->appendChild($newItem);
    $docIn->save("data/data.xml");
}

?>

<html>
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    
    <script>
        $(document).ready(function () {
            updateTime();
        });

        //Problem with user leaving idea update window open need to refresh current time for accurate add
        function updateTime() {
            $("#timestamp2").val(new Date($.now()).getTime());
            setTimeout(updateTime, 1000);
        }
    </script>

<style>
table,th,td
{
border:1px solid black;
border-collapse:collapse;
}
th,td
{
padding:5px;
}
</style>
</head>
<body>   
<div class="content">
    <form action="databaseTransaction.php" method="POST">
        <label>Owner: </label>
        <input name="owner" type="text" size="30" /><br>

        <label>Type: </label><br>
        <input name="type" type="radio" value="IDEA">Idea<br>
		<input name="type" type="radio" value="INPROGRESS">Work In Progress<br>
		<input name="type" type="radio" value="COMPLETED">Completed<br>
		<input name="type" type="radio" value="NEWS">News Item<br>

        <label>Text: </label>
        <input name="text" type="text" size="100" /><br>

        <label>Description: </label>
        <input name="description" type="text" size="120" /><br>

        <label>Timestamp: </label>
        <input name="timestamp" type="text" size="50" id="timestamp2"><br>

        <input name="mySubmit" type="submit" value="Add Entry" />
    </form>
</div><br>

<div class="lastadded">
<h2><b>Entry Added Successfully</b></h2><br>
<table style="width:300px">
<tr>
  <th>Owner</th>
  <th>Type</th> 
  <th>Text</th>
  <th>Description</th>
  <th>Timestamp</th>
</tr>
<tr>
  <td><?php echo $owner?></td>
  <td><?php echo $type?></td> 
  <td><?php echo $text?></td>
  <td><?php echo $description?></td>
  <td><?php echo $timestamp?></td>
</tr>
</table>
</div>

</body>
</html>