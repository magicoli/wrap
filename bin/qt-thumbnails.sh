#!/bin/sh
#

CACHEDIR=.browsercache
SHORTLENGHT=50
THUMBSIZE=240x180
THUMBSIZEWIDE=224x126
LARGESIZE=768x576
LARGESIZEWIDE=1024x576
THUMBBEGIN=5
FORCE=no
WIDE=no
PORTRAIT=no

PGM=`basename "$0" .sh`
TMP=$PGM.$$

for app in avconv ffmpeg
do
    which $app | grep -q $app && vconv=$app && break
done

[ ! "$vconv" ] && echo "no video encoder found" && exit 1

for param
do
	check=`echo ".$param" | grep "^\.-" | sed "s/^\.-//"`
	if [  "$check" != "" -a "$check" = "`echo "$check" | grep -v "[^0-9\.]"`" ]
		then
		THUMBBEGIN=$check
#		echo "THUMBBEGIN=$check"
	elif [ "$check" = "f" ]
		then
		FORCE=yes
#		echo "FORCE=yes"
	elif [ "$check" = "e" ]
		then
		USELASTIMAGE=yes
  elif [ "$check" = "l" ]
		then
		LARGEENABLED=yes
  elif [ "$check" = "p" ]
		then
		PORTRAIT=yes
	elif [ "$check" = "w" ]
		then
		THUMBSIZE=$THUMBSIZEWIDE
		LARGESIZE=$LARGESIZEWIDE
		WIDE=yes
	elif [ -f "$param" ]
		then
		echo "$param" >> $TMP.movies
	elif [ "$param" ]
    then
		echo "$param ignored" >&2
	fi
done

if [ ! -f "$TMP.movies" ]
	then
	exit
fi

if [ "$PORTRAIT" = "yes" ]
then
  echo "PORTRAIT MODE" >&2
  THUMBSIZE=$(echo $THUMBSIZE | cut -d "x" -f 2)x$(echo $THUMBSIZE | cut -d "x" -f 1)
  LARGESIZE=$(echo $LARGESIZE | cut -d "x" -f 2)x$(echo $THUMBSIZE | cut -d "x" -f 1)
fi

cat "$TMP.movies" | while read movie
do
	dir="`dirname "$movie"`/$CACHEDIR"
	dir=`echo "$dir" | sed "s/\/$//"`
	if [ ! -d "$dir" ]
	then
		mkdir -p "$dir" || (echo could not create $CACHEDIR for $movie; continue)
	fi
	extension=`echo "$movie" | sed "s/.*\.//g"`
	name=`basename "$movie" ".$extension" | sed "s/-large$//"`
	for suffix in .mov .dv .mpg .mpeg .m4v .mp4 .avi .flv -original
	do
		name=`basename "$name" "$suffix"`
	done
	thumb="$dir/$name-thumb.jpg"
	large="$dir/$name-large.jpg"
	if [ -f "$thumb" -a "$FORCE" != "yes" ]
	then
		if [ -f "$large" -a "$FORCE" != "yep" ]
			then
			continue
		fi
	fi
	thumbpos=$THUMBBEGIN
	missinglarge=
	if [ "$LARGEENABLED" = "yes" -a ! -f "$large" ]
		then
		missinglarge=yes
	fi
	if [ ! -f "$thumb" -o "$missinglarge" = "yes" -o "$FORCE" = "yes" ]
		then
		if [ "$USELASTIMAGE" = "yes" ]
			then
			movielength=$(movietime "$movie"  | head -1 | cut -d " " -f 3)
			if [ $movielength ]
				then
				thumbpos=`expr $movielength - $THUMBBEGIN`
				duration="$thumbpos,`expr $thumbpos + 1`"
			else
				duration=0,1
			fi
		fi
	fi
	shortname=`echo "$name" | cut -c -$SHORTLENGHT`
	if [ "$shortname" != "$name" ]
	then
		shortname="$shortname(...)"
	fi
	printf "$shortname ($thumbpos) "
	ln -s "$movie" "$TMP.$extension"
	if [ ! $? -eq 0 ]
		then
		rm -f "$TMP.$extension"
		continue
	fi

	exportcommand="$vconv -i "
	exportparams="-y -ss $thumbpos -t 0.1 -f mjpeg"
	tmpimage=

	if [ ! -f "$thumb" -o "$FORCE" = "yes" ]
		then
		$exportcommand "$TMP.$extension" -s $THUMBSIZE $exportparams "$dir/$TMP-thumb.jpg" >/dev/null 2>/dev/null
		if [ $? -eq 0 ]
			then
			mv "$dir/$TMP-thumb.jpg" "$thumb" \
				&& printf "T"
		else
			echo " error making thumb"
			rm "$TMP.$extension" "$dir/$TMP-thumb.jpg"
			continue
		fi
	else
		printf "t"
	fi

	if [ "$LARGEENABLED" != "yes" ]
		then
		rm -f "$TMP.$extension" "$dir/$TMP.jpg" && echo
		continue
	fi

	originalsize=$($vconv -i $TMP.$extension 2>&1 | egrep "Video:.*[0-9]*x[0-9]*" | head -1 | sed "s/^.* \([0-9]*x[0-9]*\)[, ].*$/\\1/")
	resizeparam=
	x=$(echo $originalsize | cut -d "x" -f 1)
	if [ "$WIDE" = "yes" ]
		then
		y=$(($x * 9 / 16))
	else
		y=$(($x * 3 / 4))
	fi
	if [ "$originalsize" != "${x}x${y}" ]
	then
	    resizeparam="-s ${x}x${y}"
	fi
	if [ ! -f "$large" -o "$FORCE" = "yes" ]
		then
		$exportcommand "$TMP.$extension" $resizeparam $exportparams "$dir/$TMP-large.jpg" >/dev/null 2>/dev/null
		if [ $? -eq 0 ]
			then
        # Watermark
        # convert .browsercache/$large  -fill "#ccc" -undercolor "#0008" -gravity south -pointsize 48 -annotate +0+24  "$nr - $name" .browsercache/$watermark
			mv "$dir/$TMP-large.jpg" "$large" \
				&& printf "L"
		else
			echo "error making large"
			rm "$TMP.$extension" "$dir/$TMP-thumb.jpg"
			continue
		fi
	else
		printf "l"
	fi


	rm -f "$TMP.$extension" "$dir/$TMP.jpg"
	echo
done

rm -f "$TMP.movies"
