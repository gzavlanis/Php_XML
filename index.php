<?php
echo "<h1> XML handling with PHP</h1>";

$myXMLData= 
"<?xml version= '1.0' encoding= 'UTF-8'?>
<note>
<to>George</to>
<from>John</from>
<heading>Reminder</heading>
<body>Don't forget me tomorrow!</body>
</note> ";

$xml= simplexml_load_string($myXMLData) or die("Error! Can't create object");
print_r($xml);

/*  Load an xml content from xml file */
$xml1= simplexml_load_file('note.xml') or die("Error! Can't find the xml file");
print_r($xml1);

/* Get node values */
$xml3= simplexml_load_file('note.xml') or die("Error! Can't find  the xml file");
echo $xml3->to. "<br>";
echo $xml3->from. "<br>";
echo $xml3->heading. "<br>";
echo $xml3->body. "<br>";

$xml4= simplexml_load_file('books.xml') or die("Error: Can't find file!");
echo $xml4->book[0]->title. "<br>";
echo $xml4->book[1]->title. "<br>";

/* Get node values in loop */
foreach($xml4->children() as $books){
    echo $books->title. ", ";
    echo $books->author.'', '';
    echo $books->year.", ";
    echo $books->price."<br>";
}

/*  Get attribute values */
echo $xml4->book[0]['category']. "<br>";
echo $xml4->book[1]->title['lang']. "<br>";
foreach($xml4->children() as $books){
    echo $books->title['lang'];
    echo "<br>";
}

//  Initialize the XML parser
$parser= xml_parser_create();

// Function to use at the start of the element
function start($parser, $element_name, $element_attrs){
    switch ($element_name){
        case "NOTE":
            echo "-- Note -- <br>";
            break;
        case "TO":
            echo "To: ";
            break;
        case "FROM":
            echo "From: ";
            break;
        case "HEADING":
            echo "Heading: ";
            break;
        case "BODY":
            echo "Message: ";
    }
}

// Function to use at the end of an element
function stop($parser, $element_name){
    echo "<br>";
}

// Function to use when finding character data
function char($parser, $data){
    echo $data;
}

xml_set_element_handler($parser, "start", "stop"); // Specify element handler
xml_set_character_data_handler($parser,  "char"); // Specify data handler
$fp= fopen("note.xml", "r"); // open XML file

// Read data
while($data= fread($fp, 4096)){
    xml_parse($parser, $data, feof($fp)) or die(sprintf("XML Error: %s at line %d", xml_error_string(xml_get_error_code($parser)), 
                            xml_get_current_line_number($parser)));
}
xml_parser_free($parser); // Free XML parser

// PHP XML Dom parser
$xmlDoc= new DOMDocument();
$xmlDoc->load("note.xml");
print $xmlDoc->saveXML();

//Looping through XML
$x= $xmlDoc->documentElement;
foreach($x->childNodes AS $item){
    print $item->nodeName. " = ". $item->nodeValue. "<br>";
}

echo "<h2> Another example </h2>";
$xmldata= simplexml_load_file("employees.xml") or die("Failed to load");
echo $xmldata->employee[0]->firstname. "<\n>";
echo $xmldata->employee[1]->firstname."<br>";

//Read XML elements in a loop
foreach($xmldata->children() as $empl){
    echo $empl->firstname. ", ";
    echo $empl->lastname.", ";
    echo $empl->designation.", ";
    echo $empl->salary."<br>";
}

echo "<h1> Create an XML file using PHP </h1>";
$dom= new DOMDocument();
$dom->encoding= 'utf-8';
$dom->xmlVersion= '1.0';
$dom->formatOutput= true;
$xml_file_name= 'movies_list.xml';
$root= $dom->createElement('Movies');
$movie_node= $dom->createElement('Movies');
$attr_movie_id= new DOMAttr('movie_id', '5467');
$movie_node->setAttributeNode($attr_movie_id);
$child_node_title= $dom->createElement('Title', 'The Campaign');
$movie_node->appendChild($child_node_title);
$child_node_year= $dom->createElement('Year', 2012);
$movie_node->appendChild($child_node_year);
$child_node_genre= $dom->createElement('Genre', 'The campaign');
$movie_node->appendChild($child_node_genre);
$child_node_ratings= $dom->createElement('Ratings', 6.2);
$movie_node->appendChild($child_node_ratings);
$root->appendChild($movie_node);
$dom->appendChild($root);
$dom->save($xml_file_name);
echo "$xml_file_name has been Successfully created!";
?>
 <a href="movies_list.xml"> See your XML file</a>";