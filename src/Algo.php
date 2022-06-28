<?php

$sql = "";

if(isset($_GET['dbpull'])) {
	set_time_limit(0);
	$string = ''; $counter = 0; $anti_counter = 0; $matches = [];

	//First get all matching parenthesis ()
	//which represents each record separately
	//into array matches
	for($i=0; $i<strlen($sql); $i++) {
		if($sql[$i] == '(') {
			$counter++;
		}
		if($sql[$i] == ')') {
			$anti_counter++;
		}
		if($counter || $anti_counter) $string .= $sql[$i];
		if($counter == $anti_counter) {
			array_push($matches, $string);
			$string = '';
			$counter = 0;
			$anti_counter = 0;
		}
	}

	//Now go through each record get values
	//for each column...
	//$everything = 0;
	foreach($matches as $match) {
		//$everything++;
		//echo '<p style="margin-top: 1em; font-weight: 700;">'.$everything.'</p>';
		$match = substr($match, 1, -1);
		$value = ''; $lcount = 0; $rws = [];
		for($j=0; $j<strlen($match); $j++) {
			//For columns that have quotes
			//Note the number of quotes to mark beginning or end
			if($match[$j] == "'") {
				$lcount++;
			}

			//For columns that don't have quotes
			//like numbers and so on for e.g 47...
			//Once it sees a comma at the end, push to array
			//Then reset value variable
			if(!$lcount) {
				if($match[$j] == ',') {
					//Print value
					//echo $value.'<br/>';
					array_push($rws, $value);
					$value = '';
				}
			} else {
				if($match[$j] == ',') {
					//For columns with perfect string like so 'Hello World...'
					//Push to array once it sees a comma at the ending
					//Then reset value and lcount variables
					if(!($lcount%2)) {
						$value = trim(trim($value), '\'');
						//Print value
						//echo $value.'<br/>';
						array_push($rws, $value);
						$value = '';
						$lcount = 0;
					}
				}
				//Match back slashes, not sure what this does now !!!
				if($match[$j] == '\\') {
					if(strpos($value, '\\') !== false) {
						$lcount = 1;
					} else {
						$lcount = 2;
					}
				}
			}
			if($lcount == 0 && $match[$j] == ',') {
				//do nothing..
			} else {
				$value .= $match[$j];
			};
		}

		$rws_lastname = $rws[0];
  		$rws_firstname = strtoupper($rws[1]);
  		$rws_service = $rws[2];
  		$rws_person = $rws[3];
  		$rws_info = ucfirst($rws[4]);
		if($rws[5]) $rws_sources = "SOURCE 1: \n".$rws[5]."\n\n";
		if($rws[6]) $rws_sources .= "SOURCE 2: \n".$rws[6]."\n\n";
		if($rws[7]) $rws_sources .= "SOURCE 3: \n".$rws[7]."\n\n";
		if($rws[8]) $rws_sources .= "SOURCE 4: \n".$rws[8]."\n\n";
		if($rws[9]) $rws_sources .= "SOURCE 5: \n".$rws[9]."\n\n";

		$post_rws = array(
			'post_type'    => 'rws',
			'post_title'   => $rws_lastname.' '.$rws_firstname,
			'post_content' => $rws_info,
			'post_status'  => 'publish',
			'post_author'  => 1,
			'meta_input'   => array(
				'rws_lastname'		=> $rws_lastname,
				'rws_firstname'		=> $rws_firstname,
				'rws_service'		=> $rws_service,
				'rws_person'		=> $rws_person,
				'rws_info'			=> $rws_info,
				'rws_sources'		=> $rws_sources,
			),
		);
		wp_insert_post( $post_rws );
	}
}

add_filter( 'pre_get_posts' , 'cpt_sorts_posts' );
function cpt_sorts_posts($query) {
	if (is_admin()) {
		if (isset($query->query_vars['post_type'])) {
			if ($query->query_vars['post_type'] == 'slave') {
				$query->set('order', 'ASC');
				$query->set('orderby', 'meta_value');
				$query->set('meta_key', 'slave_lastname');
			}
			if ($query->query_vars['post_type'] == 'rws') {
				$query->set('order', 'ASC');
				$query->set('orderby', 'meta_value');
				$query->set('meta_key', 'rws_lastname');
			}
		}
	}
}

/*
 * HOW TO FIX SQL
 * 1 - Replace all occurences of '), with ',)
 * 2 - Replace all '\r\n occurences with non-empty space via REGEX on VSCode by searching for \r?\n
 * See more on REGEX searches here - https://docs.microsoft.com/en-us/visualstudio/ide/using-regular-expressions-in-visual-studio?view=vs-2019
 * 3 - You should have a massive SQL string. Perform dbpull tests with string to ensure there are no breakages mid-way as a result of terminating closing brackets and so on.
 * 4 - If good to go, use on production site
 */

?>
