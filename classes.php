<?php
class item {
	function item() {
		global $hostname, $webroot;
		$arg=func_get_args();
		if(is_array($arg[0]))
		{
			while(list($key, $value)=each($arg[0]))
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
				$this->url="http://$hostname/" . ereg_replace('^/', '', $file);
			}
		}
		$this->hostname=ereg_replace('/.*', '', ereg_replace('^[a-z]*://', '', $this->url));
		$this->directory=ereg_replace('^/', '', dirname(ereg_replace('^[a-z]*://[^/]*/', '', $file)));
		$this->filename=basename(ereg_replace('^[a-z]*://[^/]*/', '', $file));
		$this->localfile=urldecode("$webroot/$this->directory/$this->filename");
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
		while(list($key, $value)=each($array))
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
		while(list($key, $value)=each($info))
		{
			if($value)
			{
				$return .= "<div class=info_$key>" 
				. ereg_replace("\n", "</div><div class=info_$key>", $value)
				. "</div>";
			}
		}
		$return="<div class=description>$return</div>";		
		return $return;
	}
}

?>