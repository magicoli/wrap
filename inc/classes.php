<?php
if ( ! defined( 'WRAP_INC' ) ) die ;

class item {
	function item() {
		global $hostname, $protocol;
		$arg=func_get_args();
		if(is_array($arg[0]))
		{
			foreach ($arg[0] as $key => $value)
			{
				$this->$key=$value;
			}
		}
		else
		{
			$file=$arg[0];
			if(is_external($path))
			{
				$this->url=$path;
			}
			else
			{
				$this->url="$protocol://$hostname/" . preg_replace('#^/#', '', $file);
			}
		}
		$this->hostname=preg_replace('#/.*#', '', preg_replace('#^[a-z]*://#', '', $this->url));
		$this->directory=preg_replace('#^/#', '', dirname(preg_replace('#^[a-z]*://[^/]*/#', '', $file)));
		$this->filename=basename(preg_replace('#^[a-z]*://[^/]*/#', '', $file));
		$this->localfile=urldecode(DOCUMENT_ROOT . "/$this->directory/$this->filename");
		$this->name=generateFileName($file);
		$atoms=parseAtom($this->localfile);
		$this->description=firstValidValue($atoms["desc"], $atoms["@cmt"], $atoms["comment"]);
		$this->longdesc=firstValidValue($atoms["©lyr"], $this->description, $atoms["comment"]);
		$this->author=firstValidValue($atoms["©wrt"], $atoms["cprt"], $atoms["writer"]);
		$this->artist=firstValidValue($atoms["©ART"], $atoms["aART"], $atoms["artist"]);
		$this->name=firstValidValue($atoms["©nam"], $atoms["name"], $this->name);
		$this->album=firstValidValue($atoms["album"]);
		$this->title=$this->name;
		if($this->name && $this->artist)
		{
			$this->title="$this->artist: $this->name";
		}
		else
		{
			$this->title=trim($this->artist. $this->name);
		}
	}

	function buildTagsView()
	{
		$array=get_object_vars($this);
		foreach ($array as $key => $value)
		{
			$result.="$key: $value<br>";
		}
		return $result;
	}

	function buildItemInfo()
	{
		$info=array(
			"title" => $this->title,
			"description" => $this->longdesc,
			"author" => $this->author
		);
		foreach ($info as $key => $value)
		{
			if($value)
			{
				$return .= "<div class=info_$key>"
				. preg_replace("#\n#", "</div><div class=info_$key>", $value)
				. "</div>";
			}
		}
		$return="<div class=description>$return</div>";
		return $return;
	}
}

?>
