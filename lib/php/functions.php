<?php

	function getArticles(){ 
		$result = mysql_query("SELECT P.page_id, P.page_title
			FROM `demo_recommendations` REC
			JOIN ec_wikipage P ON P.page_id = REC.page_id_X
			GROUP BY REC.page_id_X
			ORDER BY P.page_title ASC");
		return $result;
	}

	function removeUnderscores($string){
		return str_replace('_', ' ', $string);
	}
	
	function getUrl($pageTitle){
		return ROOT . '/index.php/' .  $pageTitle;
	}
	
	function getPageId($pageTitle){
		$sql = "
			SELECT page_id
			FROM `ec_wikipage`
			WHERE page_title = \"{$pageTitle}\"";
		$result = mysql_query($sql);		
		if(mysql_num_rows($result)){
			$row = mysql_fetch_array($result);
			return $row['page_id'];
		} else {
			return false;
		}
	}
	
	function getPageTitle($pageId){
		$result = mysql_query("
			SELECT page_title
			FROM `ec_wikipage`
			WHERE page_id = {$pageId}");
		$row = mysql_fetch_array($result);
		return $row['page_title'];
	}
	
	function isLinked($pageId, $recPageId){
		$recPageTitle = mysql_real_escape_string(getPageTitle($recPageId));
		$result = mysql_query("SELECT * FROM ec_wikipagelinks WHERE pl_from = $pageId AND pl_title = \"$recPageTitle\"");
		return mysql_num_rows($result);
	}
	
?>