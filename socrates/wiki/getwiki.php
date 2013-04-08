<?php 
require_once('../xanthippe/includes/sql-jperetz.php');
$selectterms = $mysqli->query("select term from term , definition where term = term_term order by term");
while ($term = $selectterms->fetch_object()) {
	$terms[$term->term] = $term;
    if ($selectdefinitions = $mysqli->query('select  term_term, definition_id ,definition, first_name, email ,  updated from definition , student where student_email = email and term_term="'.$term->term.'" order by definition_id desc')) {
         while ($definition = $selectdefinitions->fetch_object())
            {		
			  $terms[$term->term]->definition[$definition->definition_id] = $definition;
 			}
	}
}
$mysqli->close();	
require_once('../xanthippe/includes/JSON.php');
$json = new Services_JSON;
$termList = $json->encode($terms);
echo $termList;