<?php
	$id = str_replace("=","",$_SERVER['QUERY_STRING']);
?>
<HTML>
  <head>
    <link rel="stylesheet" type="text/css" href="static/krila.css">
  </head>
  <body>
    <div id="boardsection"></div>
    <a href="index.php"><img src="static/logo.png" id="logo"></a><br>
    <div id="threadcreate">
      <form enctype="multipart/form-data"  action="postcomment.php" method="post">
        <input type="text" name="name" id="name"><label id="threadlabel" for="name"> Name</label><br>
        <input type="text" name="title" id="title"><label id="threadlabel" for="title"> Subject</label><br>
        <textarea name="body" id="body"></textarea><label id="threadlabel" for="body"> Comment</label><br>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Post" style="float: right; margin-right: 50px;"><br><br>
      </form>
    </div>
    <hr>
    <?php
      $threadlink = "thread/" . $id . ".txt";
      $thread = fopen($threadlink, "r");
			$cnt = 0;
			$pastinclude = 0;
			$firsttitle = 0;
      while(!feof($thread)){
				$cnt = $cnt + 1;
				$line = fgets($thread);
        if(substr($line, 0, 1) === "[")
        {
					if($cnt === 1) {	}
					else
					{
						if($pastinclude == 1)
						{
							echo '<br><br><br><br><br><br><br><br><br></div>';
						}
						else
						{
								echo '<br></div>';
						}
					}
					$metainformation = str_replace("[", "", $line);
					$metainformation = str_replace("]", "", $metainformation);
					$meta = explode(", ", $metainformation);
					$name = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('name="', '', $meta[0]))));
					$date = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('date="','', $meta[1]))));
					$title = trim(preg_replace('/\s\s+/', ' ', str_replace('"','', str_replace('title="','', $meta[2]))));
					$include = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', str_replace('include="','', $meta[3]))));
					echo '<div id="postcontainer">';
					if(!empty($include))
					{
						echo '<span id="metadata">File: <a href="cdn/' . $include .'">' . $include .'</a></span><br>';
						echo '<a href="cdn/' . $include . '"><img id="thumb" style="vertical-align: top;" src="cdn/' . $include . '"></a>';
						$pastinclude = 1;
					}
					else
					{
						$pastinclude = 0;
					}
					echo '<span id="posttitle">' . $title .'    </span><span id="name">' . $name .'    </span><span id="date">' . $date .'   </span>     <br><br>';
        }
				else if(substr($line, 0, 1) === "#")
				{
					if(substr(str_replace("#","",$line), 0 , 1) === ">")
					{
						echo '<span id="body"><span id="greentext">' . str_replace("#","",$line) . '</span></span><br>';
						if($firsttitle === 0)
						{
							echo '<title>/krila/ - ' . str_replace("#","",$line) . '</title>';
							$firsttitle = 1;
						}
					}
					else
					{
						$arr = explode(">", $line, 2);
						if(count($arr) > 1)
						{
							$arr[0] = str_replace("#","",$line);
							$arr[1] = '<span id="greentext">>' . $arr[1] . '</span>';
							$res = implode(" ", $arr);
							echo '<span id=body>' . $res . '</span><br>';
							if($firsttitle === 0)
							{
								echo '<title>/krila/ - ' . $res . '</title>';
								$firsttitle = 1;
							}
						}
						else
						{
							echo '<span id="body">' . str_replace("#","",$line) . '</span><br>';
							if($firsttitle === 0)
							{
								echo '<title>/krila/ - ' . str_replace("#","",$line) . '</title>';
								$firsttitle = 1;
							}
						}
					}
				}
				else
				{
					if(substr($line, 0 , 1) === ">")
					{
						echo '<span id="body"><span id="greentext">' . $line . '</span></span><br>';
					}
					else
					{
						$arr = explode(">", $line, 2);
						if(count($arr) > 1)
						{
							$arr[1] = '<span id="greentext">>' . $arr[1] . '</span>';
							$res = implode(" ", $arr);
							echo '<span id=body>' . $res . '</span>';
						}
						else
						{
							echo '<span id="body">' . $line . '</span><br>';
						}
					}
				}
      }
    ?>
  </body>
</HTML>
