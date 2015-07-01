<?php

	function getAlgorithmExplanation($algorithm){
		$algorithmExplanation = '';
		switch ($algorithm){
			case 'user-navigation-based':
				$algorithmExplanation = 'The user-navigation based algorithm recommends articles that are popular with users.';
				break;
			case 'content-based':
				$algorithmExplanation = 'The content based algorithm recommends articles based on the similarity between the article texts.';
				break;
			case 'hybrid':
				$algorithmExplanation = 'The hybrid algorithm combines the user-navigation based algorithm and the content based algorithm.<br/>
					It looks at content similarity and then adjusts the ranking by the popularity of the articles.';
				break;
		}
		return $algorithmExplanation;
	}
	
?>