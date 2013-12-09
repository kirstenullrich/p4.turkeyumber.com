<?php

class Post {
	
	public static function get_posts_by_user($user_id) {
	
		$q = 'SELECT *
			FROM posts
			WHERE user_id = '.$user_id;
		
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		return $posts;
		
	}

}
?>