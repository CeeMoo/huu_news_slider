<?php

function temizle($haber) {
     $strs=explode('<',$haber);
     $res=$strs[0];
     for($i=1;$i<count($strs);$i++)
     {
         if(!strpos($strs[$i],'>'))
             $res = $res.'&lt;'.$strs[$i];
         else
             $res = $res.'<'.$strs[$i];
     }
     return strip_tags($res);   
 }

function huu_news_slider($bolumler = array(1), $kisa=255, $limit = 10){
	global $smcFunc, $context, $settings, $options, $txt, $scripturl, $modSettings;

	echo '
	<link rel="stylesheet" type="text/css" href="'.$settings['theme_url'].'/huu_news_slider/slick.css">
	<link rel="stylesheet" type="text/css" href="'.$settings['theme_url'].'/huu_news_slider/slick_custom.css">
	<!--<script type="text/javascript" src="'.$settings['theme_url'].'/huu_news_slider/jquery-1.11.0.min.js"></script>-->
	<script type="text/javascript" src="'.$settings['theme_url'].'/huu_news_slider/jquery-migrate-1.2.1.min.js"></script>

	<script type="text/javascript" src="'.$settings['theme_url'].'/huu_news_slider/slick.min.js"></script>
		
	<script>
		$(document).ready(function(){
			$(".haber-slide").slick({
				dots: true,
				infinite: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				variableWidth: true,
			});
		});
	</script>';

	$boards=$bolumler;

		$request = $smcFunc['db_query']('', '
		  SELECT t.id_topic, m.subject, m.body, b.id_board, b.name AS board_name, m.poster_time, c.name
		  FROM {db_prefix}topics AS t
		     INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_first_msg)
		     LEFT JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
		     LEFT JOIN {db_prefix}categories AS c ON (b.id_cat = c.id_cat)
		  WHERE t.id_board IN ({array_int:boards})
		  ORDER BY t.id_topic DESC
		  LIMIT {int:limit}',
		  array(
		    'boards' => $boards,
		    'limit' => $limit,
		  )
		);

		$topics = array();
		while ($row = $smcFunc['db_fetch_assoc']($request)){

		  $topics[] = array(
		     'id_topic' => $row['id_topic'],
		     'subject' => $row['subject'],
		     'body' => temizle(parse_bbc($smcFunc['substr']($row['body'], 0, $kisa))),
		     'board_name' => $row['board_name'],
		     'poster_time' => $row['poster_time'],
		     'name' => $row['name'],
		     'id_board' => $row['id_board'],
		     'first_image'  => preg_match_all('~\[img.*?\]([^\]]+)\[\/img\]~i', $row['body'],  $images) ? '<img src="' . $images[1][0] . '" alt="' .  $row['subject'] . '"/>' : '<img src="'.$settings['theme_url'].'/huu_news_slider/resimyok.jpg" alt="' .  $row['subject'] . '"/>',
		  );
		}

		$smcFunc['db_free_result']($request);

		echo '
		<article id="vrpg-footer01">
			<div class="vrpg-ftalan">
				<div class="temizle"></div>
				<div class="sliderCss-haber active-demo">
					<div class="haber-slide">';

				foreach ($topics as $topic){				
						echo '<div class="slidehaberblock">
							<div class="panel panel-warning panel-border top slidehaberblockA">
								<div class="panel-body">
								<a class="media-vendetta" href="'.$scripturl.'?topic='.$topic['id_topic'].'.0">'.$topic['first_image'].'</a>
								<h5><a href="'.$scripturl.'?topic='.$topic['id_topic'].'.0">'.$topic['subject'].'</a></h5>
								<div class="vendetta-haber-detay">'.$topic['body'].'</div>
								<div class="vendetta-haber-alt">
									<small><span class="label bg-warning mr10 pull-right vendetta-haber-label-fix">'.$topic['name'].'</span><span class="label bg-warning mr10 pull-right vendetta-haber-label-fix">'.$topic['board_name'].'</span>
										<i class="fa fa-clock-o icon-muted"></i> '.date('d-m-Y', $topic['poster_time']).'</small>
									</div>
								</div>
							</div>
						</div>';
				}

					echo '				
					</div>
				</div>
			</div>
		</article>';

		echo '<br class="clear" />';


}
?>