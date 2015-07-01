<?php

	include('getContentText.php');
 
	function getRelatedArticles($pageId){
		$text = getContentText($pageId);
		$relatedArticles = array();
		
		$strpos = strpos($text, 'Related Articles');
		$related_articles_string = substr($text, $strpos);
		
		$delimiterpos = strpos($related_articles_string, '=='); //first == delimiter (== Related Articles ==)
		$related_articles_string = substr($related_articles_string, $delimiterpos+2);
		
		$delimiterpos = strpos($related_articles_string, '=='); //until next == delimiter 
		if($delimiterpos != ''){
			$related_articles_string = substr($related_articles_string, 0, $delimiterpos);
		} else {
			$related_articles_string = substr($related_articles_string, 0);
		}
		
		while(strpos($related_articles_string, '[[') !== false){ 
			$startlink = strpos($related_articles_string, '[[');
			$endlink = strpos($related_articles_string, ']]');
			$link = substr($related_articles_string, $startlink + 2, ($endlink - $startlink)-2);
			$related_articles_string = substr($related_articles_string, $endlink+2);
			$page_title = str_replace(' ', '_', $link);
			$verticallinepos = strpos($page_title, '|'); //some links contain an |
			if($verticallinepos !== false){
				$page_title = substr($page_title, $verticallinepos+1);
			}
			$relatedArticlePageId = getPageId($page_title);
			if($relatedArticlePageId !== false){
				array_push($relatedArticles, $relatedArticlePageId);
			}
		}
		return $relatedArticles;
	}

?>