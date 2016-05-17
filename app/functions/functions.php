<?php require 'database.php'; 

/*
*
*
* Functions 
*
*
*/

/* ###### Get all posts ###### */

function get_posts(){
	
	// Get Firebase JSON
	$json = file_get_contents(FIREBASE_URL.'/posts.json');
	// Decode JSON
	$obj = json_decode($json);
	// Convert to array
	$array = (array) $obj;
	// Empty posts array
	$the_posts = [];
	// Get Params
	$url_params = $_GET;
	
	if(!empty($url_params)){	
		// Push each param to array
		foreach ($url_params as $param => $value) {
			$params[] = $value;
		}
		// Loop through Firebase Array
		foreach ($array as $id => $post) {
			// Push properties of post to array
			$post_values = [];

			foreach ($post as $key => $value) {
				$post_values[] = $value;
			}
			// Compare params array to post_values array. If all params in post_values, push to the_posts
			if (!array_diff( $params, $post_values )){
				$the_posts[$id] = $array[$id];
			}
		}
	} else {
		$the_posts = $array;
	}
	

	// Return filtered posts
	return array_reverse($the_posts);

}


/* ###### Get Single Post ###### */

function get_single_post(){
	
	$url = parseUrl();

	if(isset($url[1])){
		$post_id = $url[1];
		// Get Firebase JSON of single post
		$json = file_get_contents(FIREBASE_URL.'/posts/p'.$post_id.'.json');
		// Decode JSON
		$obj = json_decode($json);
		// Return data
		if(!empty($obj)){
			return $obj;
		} else {
			return false;
		}		
	}	
}


/* ###### Submit Lost Pet ###### */

function submit_lost(){
	$post_id = $_SERVER['REQUEST_TIME'];
	header('Location:http://localhost/pet-details.php?pet='.$post_id);
	$post_params = $_POST;
	$post_params['time'] = $post_id;
	$post_params['status'] = 'lost';

	// CURL stuff
	$url = FIREBASE_URL.'/posts/p'.$post_id.'.json';    
	$data = json_encode($post_params);
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

	$response = curl_exec($ch);

	if(!$response) {
		print_r('No response from server');
		return false;
	}
}

	// Cross Reference with Found Pets? Think the 'does this answer your question' feature on Stack Overflow

/* ###### Submit Found Pet ###### */

	/* Fields
	- Type
	- Breed
	- Size
	- Colour
	- Chipped?
	- Collar? (colour)
	- Picture(s)
	- Found Location - Post Code/Geo Location
	- Found Date
	- Any Other Notes
	*/

	// Cross Reference with Lost Pets? Think the 'does this answer your question' feature on Stack Overflow

/* ###### Claim Found Pet ('That's mine!') ###### */

	// How do users get in touch?

/* ###### Find Lost Pet ('I Found it') ###### */

/* ###### Search/Filter ###### */

/* ###### Helper Functions ###### */

function print_tag($var, $default = '&mdash;') {
	echo isset($var) ? $var : $default;
}

function parseUrl() {
// Trim URL, Sanitize and explode to array at each /
	return $url = explode('/pet-details/', filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
}
