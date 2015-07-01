<?php

	function getRecommendations($pageId, $algorithm, $hideAI, $hideLinked, $hideRelated){
		$sql  = "
			SELECT PX.page_title AS titleX, PY.page_title AS titleY, PY.page_id AS page_id_Y, REC.score,
			CASE WHEN EXISTS 
				(SELECT * FROM ec_wikipagelinks WHERE pl_from = $pageId AND pl_title = PY.page_title) 
				THEN 'Link in article' ELSE 'None' END AS link
			FROM `demo_recommendations` REC
			JOIN ec_wikipage PX ON PX.page_id = REC.page_id_X
			JOIN ec_wikipage PY ON PY.page_id = REC.page_id_Y
			WHERE algorithm = '$algorithm' AND REC.page_id_X = $pageId
		";
		if($hideLinked and $hideRelated){
			$sql .= " AND NOT EXISTS (SELECT * FROM ec_wikipagelinks WHERE pl_from = $pageId AND pl_title = PY.page_title) ";
		}
		$result = mysql_query($sql) or die(mysql_error());
		return $result;
	}
	
?>