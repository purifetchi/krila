<HTML>
  <head>
    <title>Krila</title>
    <link rel="stylesheet" type="text/css" href="static/krila.css">
  </head>
  <body>
    <div id="boardsection"></div>
    <a href="javascript:location.reload();"><img src="static/logo.png" id="logo"></a><br>
    <div id="boardname">/krila/ - Anything & Everything</div><br>
    <div id="threadcreate">
      <form enctype="multipart/form-data"  action="post.php" method="post">
        <input type="text" name="name" id="name"><label id="threadlabel" for="name"> Name</label><br>
        <input type="text" name="title" id="title"><label id="threadlabel" for="title"> Subject</label><br>
        <textarea name="body" id="body"></textarea><label id="threadlabel" for="body"> Comment</label><br>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Post" style="float: right; margin-right: 50px;"><br><br>
      </form>
    </div>
    <hr>
    <?php
      $path = "thread/";
      if(is_dir($path))
      {
      	$threads = scandir($path,1);
      	natsort($threads);
        $threads = array_reverse($threads, false);
        for($i = 0; $i <= 10; $i++)
        {
          if(is_file($path . $threads[$i]))
          {
            $f = fopen($path . $threads[$i], 'r');
					  $metainformation = fgets($f);
            $body = fgets($f);
            $metainformation = str_replace("[", "", $metainformation);
            $metainformation = str_replace("]", "", $metainformation);
            $meta = explode(", ", $metainformation);
            $name = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('name="', '', $meta[0]))));
            $date = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('date="','', $meta[1]))));
            $title = trim(preg_replace('/\s\s+/', ' ', str_replace('"','', str_replace('title="','', $meta[2]))));
            $include = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('include="','', $meta[3]))));
            echo '<div id="main_postcontainer">';
            if(!empty($include))
            {
              echo '<span id="metadata">File: <a href="cdn/' . $include .'">' . $include .'</a></span><br>';
              echo '<a href="cdn/' . $include . '"><img id="thumb" style="vertical-align: top;" src="cdn/' . $include . '"></a>';
            }
            echo '<span id="posttitle">' . $title .'    </span><span id="name">' . $name .'    </span><span id="date">' . $date .'   </span><span id="postno">No. ' . str_replace(".txt","",$threads[$i]) . '</span><br><br>';
            echo '<span id="body">' . str_replace("#","",$body) . '</span><br>';
            echo '<a id="body" href="thread.php?=' . str_replace(".txt","",$threads[$i]) .'">Show more</a><br><br><br><br><br><br><br><br><br>';
            echo '</div><hr>';
          }
        }
      }
      else{}
    ?>
  </body>
</HTML>
