<?php
	
	require_once('config.php');
	include('lib/php/getRecommendations.php');
	include('lib/php/getRelatedArticles.php');
	include('lib/php/getAlgorithmExplanation.php');
	
	//initialize variables
	$showresults = false;
	$hideAI = false;
	$hideLinked = false;
	$hideRelated = false;
	$checked = '';
	$checkedLinked = '';
	$checkedRelated = '';
	
	//change variables according to POST variables
	if(isset($_POST['routine']) && $_POST['routine'] == 'selectform'){
		$selectPageId = $_POST['selectpageId'];
		$algorithm = $_POST['selectAlgorithm'];
		
		$hideLinked = isset($_POST['hideLinked']) ? true : false;
		$hideRelated = isset($_POST['hideRelated']) ? true : false;
		
		$checkedLinked = $hideLinked ? ' checked="checked" ' : '';
		$checkedRelated = $hideRelated ? ' checked="checked" ' : '';
		
		if($selectPageId != '' and $algorithm != ''){
			$showresults = true;
			$recommendations = getRecommendations($selectPageId, $algorithm, $hideAI, $hideLinked, $hideRelated);
			$relatedArticles = getRelatedArticles($selectPageId);
			$algorithmExplanation = getAlgorithmExplanation($algorithm); 
		}

	}
	
?>
<html>
	<head>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="lib/js/DataTables-1.10.7/DataTables-1.10.7/media/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="lib/js/DataTables-1.10.7/DataTables-1.10.7/media/js/jquery.js"></script>
		<script type='text/javascript' src='lib/js/lib.js?version="<?php echo filemtime('lib/js/lib.js'); ?>"'></script>
		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="lib/js/DataTables-1.10.7/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
		<title>Recommendation engine demo</title>
	</head>
	<body>
		<div class="header"></div>
		<div class="content">
			<h2>Recommendation engine demo</h2>
			<p>
				Welcome to the recommendation engine demo. <br/> 
				Choose an article that you want to show recommendations for. 
			</p>
			<form action="" method="post">
				<input type="hidden" name="routine" value="selectform"/>
				<label class="formlabel"><b>Article: </b></label>
				<select name="selectpageId" onchange="this.form.submit()"> 
					<option value="">-</option>
					<?php 
						$articles = getArticles();
						while($row = mysql_fetch_array($articles)){ 
							$selected = $row['page_id'] == $selectPageId ? ' selected="selected" ' : ''; ?>
							<option value="<?php echo $row['page_id']; ?>"<?php echo $selected; ?>><?php echo removeUnderscores($row['page_title']);?></option>
					<?php } ?>
				</select>
				<br/>
				<label class="formlabel"><b>Algorithm: </b></label>
				<select name="selectAlgorithm" onchange="this.form.submit()">
					<option value="">-</option>
					<option value="user-navigation-based"<?php if(isset($algorithm) and $algorithm=='user-navigation-based'){echo ' selected="selected" ';} ?>>User-navigation based</option>
					<option value="content-based"<?php if(isset($algorithm) and $algorithm=='content-based'){echo ' selected="selected" ';} ?>>Content based</option>
					<option value="hybrid"<?php if(isset($algorithm) and $algorithm=='hybrid'){echo ' selected="selected" ';} ?>>Hybrid</option>
				</select>
				<h4>Apply filters:</h4>
				<input type="checkbox" name="hideLinked" onchange="this.form.submit()" <?php echo $checkedLinked;?>>Hide recommended articles that are linked in the text
				<br/><input type="checkbox" name="hideRelated" onchange="this.form.submit()" <?php echo $checkedRelated;?>>Hide recommended articles that are in the Related Links section
			</form>
			<hr/>
			<?php if($showresults){?>
				<h3> 
					<?php echo 'Recommendations for article: ' . removeUnderscores(getPageTitle($selectPageId));?>
					(<a target="blank" href="<?php echo getURL(getPageTitle($selectPageId));?>">link</a>)
				</h3>
				<p><?php echo $algorithmExplanation;?></p>
				<table class="rec-table">
					<thead>
						<th>Recommended article</th>
						<th>URL</th>
						<th>Place in article</th>
						<th>Score</th>
					</thead>
					<tbody>
						<?php while($row = mysql_fetch_assoc($recommendations)){
								$placeInArticle = in_array($row['page_id_Y'], $relatedArticles) ? 'Related Links' : $row['link'];
								if($placeInArticle == 'Link in article' and ($hideLinked)){ continue; }
								if($placeInArticle == 'Related Links' and ($hideRelated)){ continue; } ?>
								<tr>
									<td><?php echo removeUnderscores($row['titleY']);?></td>
									<td><a target="blank" href="<?php echo getUrl($row['titleY']);?>">link</a></td>
									<td><?php echo $placeInArticle;?></td>
									<td><?php echo $row['score'];?></td>
								</tr>
								<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</body>
</html>