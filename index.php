<?php
if (isset($_REQUEST['song'])) { $searchQuery = rawurlencode($_REQUEST['song']); } else { $searchQuery = ''; }
if (isset($_REQUEST['start'])) { $start = $_REQUEST['start']; } else { $start = 0; }

$Appid = "Yn9gKxfV34FT8RJU8ssxWxhv2Drqfuki9PkVhgAfxQvoyVzgf2nh_EDHUAwrZS0.f.ix";   ///////    Add your Appid here, its that easy
$Site="+site:youtube.com";   /////// Make this empty if you are building a generic web search, add your URL for site search
$video_key = '';
if(!empty($searchQuery)) {
  $results = new SimpleXMLElement('http://boss.yahooapis.com/ysearch/web/v1/'.$searchQuery.$Site.'?appid='.$Appid.'&count=10&start='.$start.'&format=xml',NULL,TRUE);
  foreach ($results->resultset_web->result as $result) {
    if (stristr($result->url,'/watch?v=')) {
      $video_title = preg_replace('/<\/?b>/','',str_replace('YouTube - ','',$result->title));
      $video_key = preg_replace('/.+\?v\=/','',$result->url);
      $video_key = preg_replace('/&.*$/','',$video_key);
      break;
    }
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title><?= $video_title ?></title>
  <link rel="stylesheet" href="../style.css" type="text/css" />
  <style type="text/css" media="screen">
    h1, #container, #ft { width: 425px; }
    #search-form { border: 1px solid #ccc; border-width: 1px 0; padding: 10px; background-color: #8cc6d6; }
  </style>
</head>
<body>
<h1><a href="http://jeremyhubert.com/playground">Jeremy Hubert's Playground</a></h1>
<div id="container">
<? if (empty($video_key)) { ?>
  <? if (!empty($searchQuery)) { echo '<div class="alert">We couldn\'t find anything that matched that query. Please try a different one.</div>'; } ?>
  <h2>Music Video Search</h2>
  <p>This is a simple Music Video Search tool I built with <a href="http://developer.yahoo.com/search/boss/">Yahoo! BOSS</a> and <a href="http://youtube.com">YouTube</a>. All you need to do is type in a band or song name and it will start playing the first music video it finds.</p>
  <div id="search-form">
   <form name="b" action="" method="get" style="margin:0px">
      Search For: <input type="text" name="song" />
      <input type="button" value="Find The Video" />
   </form> 
  </div>
  <p>Sometimes when I'm really bored, I also just start typing in random words to see what comes up. A few of my favorites are <a href="http://illanti.com/mvs.php?song=banana">Banana</a>, <a href="http://illanti.com/mvs.php?song=pizza">Pizza</a> and <a href="http://illanti.com/mvs.php?song=science">Science</a>.</p>
  <h3>Integration with iTunes</h3>
  <p>I have also written an AppleScript that will find a music video based on the currently playing or selected track.</p>
  <p>You can download it here: <a href="http://gist.github.com/75457">http://gist.github.com/75457</a>. I've set it up so that the file can be triggered by Quicksilver, which is pretty straight forward.</p>
  <p>Of course, this was all done very quickly. If you have suggestions or want to expand on it, by all means please do. :)</p>
<? } else { ?>
  <object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/<?=$video_key?>&hl=en&fs=1&autoplay=1"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/<?=$video_key?>&hl=en&fs=1&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" width="425" height="344"></embed></object>
  <p>If this video doesn't work, <a href="?song=<?=$searchQuery?>&start=<?= ++$start ?>">try the next one</a></p>
<? } ?>
</div>
<div id="ft">
  &copy; 2009 <a href="http://jeremyhubert.com">Jeremy Hubert</a>, although I'd probably let you use it if you just ask me.
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-195712-2";
urchinTracker();
</script>
</body>
</html>