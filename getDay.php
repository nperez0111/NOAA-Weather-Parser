<?php
	//$_GET["loc"]=isset'amz670.txt';
	$url='http://weather.noaa.gov/cgi-bin/fmtbltn.pl?file=forecasts/marine/coastal/am/'.$_GET["loc"].".txt";
	include 'simple_html_dom.php';
	$html=file_get_html($url);
//echo $html;
$arr=[];
$titles=[];
$html=str_get_html($html->find('pre')[0]);
$html=str_get_html(explode($html->find('b',1)->outertext,str_replace(($html->find('b',0)->outertext),"",$html->outertext),2)[1]);
$other=$html;
$str="";
$first=true;
for($i=0,$l=(count(($html->find('b')))/2);($i<$l);$i++){
	if(count($html->find('b'))<2){
		$temper=[explode($html->find('b',0),$html,2)[1],$html];
		//echo $html;
	}
	else{
		$t=$html->find('b',1)->outertext;
		$temper=explode($t,str_replace(($html->find('b',0)->outertext),"",$html->outertext));
		$temper[1]=$t.$temper[1];
	}
	$str=$temper[0];
	$temp=explode("  ",$str);
	$cur=strtolower($html->find('b',0)->plaintext);
	echo "<h2".((strpos($cur,"caution")!==FALSE) ? " class='alert'" : (strposer($cur,["tonight","today"]) ? " class='today'" : "" )).">".($html->find('b',0)->plaintext)."</h2>";
	array_push($titles,($html->find('b',0)->plaintext));

	/*if(strposer(strtolower($html->find('b',0)->plaintext),["tonight","today"])){
		//if it contains today extract the location from the previous section
		//print_r($arr[count($arr)-1]);
	}*/
	if(count($temp)>1){
		for($c=0;$c<count($temp);$c++){
			if(substr_count($temp[$c],"-")>1){
				if($first){
				echo "<div class='top'><h1>".$temp[$c]."</h1>";
				$first=false;
				}
				else{
					echo "</div><div class='top'><h1>".$temp[$c]."</h1>";
				}
			}
			else{
			echo capitalizeSentences("<p>".$temp[$c]."</p>");
		}
		}
		array_push($arr, $temp);
	}
	else{
		echo capitalizeSentences("<div>".$str."</div>");
		array_push($arr,$str);
	}
	if(count($html->find('b'))==2){
	$html= str_get_html($html->find('b',1)->outertext."".$temper[1]);
	}
	else{
		//echo $temper[1];
		$html= str_get_html($temper[1]);
	}
}

//echo $html;
//echo$html->find('b',0)->outertext;
//$arr[0]=explode($html->find('b',0)->outertext,$html->outertext,2);
//array_push($arr,$html->find('b',0)->nextSibling()->innertext);
//print_r($arr);
function strposer($var,$arr){
	for($i=0;$i<count($arr);$i++){
		if(strpos($var,$arr[$i])!==FALSE){
			return true;
		}
	}
	return false;
}
function capitalizeSentences($str){
//first we make everything lowercase, and 
//then make the first letter if the entire string capitalized
//ucfirst(strtolower($str));
//now capitalize every letter after a . ? and ! followed by space
return  preg_replace_callback('/[.!?] .*?\w/', 
  create_function('$matches', 'return strtoupper($matches[0]);'), ucfirst(strtolower($str)));
}
?>