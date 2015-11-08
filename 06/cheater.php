<!DOCTYPE html>
<html>
	<head>
		<title>Grade Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php
		//print_r($_POST);
		$names = array("cse326", "cse107", "cse603", "cin870");
		?>
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		$flag = true;
		$tmp = $_POST['name'];
		$tmp = trim($tmp);

		if (!isset($_POST['name']) || strlen($tmp) == 0)
			$flag = false;

		$tmp = $_POST['id'];
		$tmp = trim($tmp);
		if (!isset($_POST['id']) || strlen($tmp) == 0)
			$flag = false;

		if (!isset($_POST['grade']))
			$flag = false;

		$tmp = $_POST['card'];
		$tmp = trim($tmp);
		if (!isset($_POST['card']) || strlen($tmp) == 0)
			$flag = false;

		$check_card = false;
		if (!isset($_POST['card_var']))
			$flag = false;
		else {
			if (isset($_POST['card']) || strlen($_POST['card']) != 0)	 {
				if(!strcmp($_POST['card_var'], "visa") && preg_match("/4\\d{15}/", $_POST['card'])) {
					$check_card = true;
				}
				else if (!strcmp($_POST['card_var'], "mastercard") && preg_match("/5\\d{15}/", $_POST['card']))
					$check_card = true;
			}
		}
		if (strlen(processCheckbox($names)) == 0)
			$flag = false;
		if (!$flag){
		?>

		<!-- Ex 4 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. Try again?</p>
		-->
		<h1>Sorry</h1>
		<p>You didn't fill out the form completely. <a href="gradestore.html">Try again?</a></p>

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
	
		} elseif (!preg_match("/[a-zA-Z\\s-]+/", $_POST['name']) || preg_match("/((\\s.*\\s)+|-.*-)+/", $_POST['name'])) { 
		?>

		<!-- Ex 5 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. Try again?</p>
		--> 
		<h1>Sorry</h1>
		
		<p>You didn't provide a valid name. <a href="gradestore.html">Try again?</a></p>
		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		} elseif (!preg_match("/\\d{16}/", $_POST['card']) || !$check_card) {
		?>

		<!-- Ex 5 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. Try again?</p>
		--> 
		<h1>Sorry</h1>
		<p>You didn't provide a valid credit card number. <a href="gradestore.html">Try again?</a></p>

		<?php
		# if all the validation and check are passed 
		} else {
		?>

		<h1>Thanks, looser!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<ul> 
			<li>Name: <?= $_POST['name']?></li>
			<li>ID: <?= $_POST['id']?></li>
			<!-- use the 'processCheckbox' function to display selected courses -->
			<li>Course: <?= processCheckbox($names)?></li>
			<li>Grade: <?= $_POST['grade']?></li>
			<li>Credit <?= $_POST['card']?> (<?= $_POST['card_var']?>)</li>
		</ul>
		
		<!-- Ex 3 : 
			<p>Here are all the loosers who have submitted here:</p> -->
		<?php
			$filename = "loosers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'loosers.txt' in the format of : "name;id;cardnumber;cardtype".
			 * For example, "Scott Lee;20110115238;4300523877775238;visa"
			 */
			$str = $_POST['name'].';'.$_POST['id'].';'.$_POST['card'].';'.$_POST['card_var']."\n";
			file_put_contents($filename, $str, FILE_APPEND);
		?>
		
		<!-- Ex 3: Show the complete contents of "loosers.txt".
			 Place the file contents into an HTML <pre> element to preserve whitespace -->
			<pre>
				<?= file_get_contents($filename)?>
			</pre>
		<?php
		}
		?>
		
		<?php
			/* Ex 2: 
			 * Assume that the argument to this function is array of names for the checkboxes ("cse326", "cse107", "cse603", "cin870")
			 * 
			 * The function checks whether the checkbox is selected or not and 
			 * collects all the selected checkboxes into a single string with comma seperation.
			 * For example, "cse326, cse603, cin870"
			 */
			function processCheckbox($names){ 
				$cources = "";
				foreach ($names as $key => $value) {
					if (isset($_POST[$value])) {
						if (strlen($cources) != 0)
							$cources = $cources.", ";
						$cources = $cources.strtoupper(strtoupper($value));
					}
				}

				return $cources;
			}
		?>
		
	</body>
</html>
