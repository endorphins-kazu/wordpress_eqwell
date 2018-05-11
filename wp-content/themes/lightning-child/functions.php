<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style')
);
}

function getCatItems($atts, $content = null) {
	extract(shortcode_atts(array(
	  "num" => '4',
	  "cat" => '9'
	), $atts));
	// 処理中のpost変数をoldpost変数に退避
	global $post;
	$oldpost = $post;
	// カテゴリーの記事データ取得
	$myposts = get_posts('numberposts='.$num.'&order=DESC&orderby=post_date&category='.$cat);
	if($myposts) {
		// 記事がある場合↓
		$retHtml = '<div class="getPostDispArea">';
		// 取得した記事の個数分繰り返す
		foreach($myposts as $post) :
			// 投稿ごとの区切りのdiv
			$retHtml .= '<div class="getPost"><a href="' . get_permalink() . '">';
			// 記事オブジェクトの整形
			setup_postdata($post);
			// サムネイルの有無チェック
			if ( has_post_thumbnail() ) {
				// サムネイルがある場合↓
				$retHtml .= '<div class="getPostImgArea">' . get_the_post_thumbnail($page->ID, 'midle') . '</div>';
			} else {
				// サムネイルがない場合↓※何も表示しない
				$retHtml .= '';
			}
			// 文章のみのエリアをdivで囲う
			$retHtml .= '<div class="getPostStringArea">';
			// 投稿年月日を取得
			$year = get_the_time('Y');	// 年
			$month = get_the_time('n');	// 月
			$day = get_the_time('j');	// 日
      $retHtml .= '<span class="published entry-meta_items">' . $year . '.' . $month . '.' . $day . '</span>';

			// タイトル設定(リンクも設定する)
			$retHtml.= '<div class="getPostTitle">' . the_title("","",false) . '</div>';
			//$retHtml.= '<a href="' . get_permalink() . '">' . the_title("","",false) . '</a>';
			//$retHtml.= '</div>';

			$retHtml.= '</div></a></div>'; 
		endforeach;
		$retHtml.= '</div>';
	} else {
		// 記事がない場合↓
		$retHtml='<p>記事がありません。</p>';
	}
	// oldpost変数をpost変数に戻す
	$post = $oldpost;
	return $retHtml;
}
// 呼び出しの指定
add_shortcode("getCategoryArticle", "getCatItems");


?>
