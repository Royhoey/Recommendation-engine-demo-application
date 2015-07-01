<?php

	function getContentText($pageId){
		$result = mysql_query("SELECT CONVERT(T.old_text USING utf8mb4) AS text
			FROM `ec_wikipage` P
			JOIN ec_wikirevision R ON P.page_id = R.rev_page
			JOIN ec_wikitext T ON R.rev_text_id = T.old_id
			WHERE page_namespace = 0 AND page_id = $pageId
			AND rev_text_id = 
				(SELECT MAX(rev_text_id)
				FROM `ec_wikirevision` 
				JOIN ec_wikitext T ON T.old_id = rev_text_id
				WHERE rev_page = P.page_id AND CONVERT(T.old_text USING utf8mb4) LIKE '{{Infobox%')
			AND rev_timestamp =
				(SELECT MAX(rev_timestamp)
				FROM `ec_wikirevision` 
				JOIN ec_wikitext T ON T.old_id = rev_text_id
				WHERE rev_page = P.page_id AND CONVERT(T.old_text USING utf8mb4) LIKE '{{Infobox%') ");
		$row = mysql_fetch_array($result);
		return $row[0];
	}
	
?>