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
LARGEDISABLED=yes

PGM=`basename "$0" .sh`
TMP=$PGM.$$

for param
do
	check=`echo ".$param" | grep "^\.-" | sed "s/^\.-//"`
	if [  "$check" != "" -a "$check" = "`echo "$check" | grep -v "[^0-9]"`" ]
		then
		THUMBBEGIN=$check
#		echo "THUMBBEGIN=$check"
	elif [ "$check" = "f" ]
		then
		FORCE=yes
#		echo "FORCE=yes"
	elif [ "$check" = "l" ]
		then
		USELASTIMAGE=yes
	elif [ "$check" = "w" ]
		then
		THUMBSIZE=$THUMBSIZEWIDE
		LARGESIZE=$LARGESIZEWIDE
		WIDE=yes
	elif [ -f "$param" ]
		then
		echo "$param" >> $TMP.movies
	else
		echo "$param ignored" >&2
	fi
done

if [ ! -f "$TMP.movies" ]
	then
	exit
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
		if [ -f "$large" -a "$FORCE" != "yop" ]
			then
			continue
		fi
	fi
	thumbpos=$THUMBBEGIN
	if [ ! -f "$thumb" -o "$FORCE" = "yes" ]
		then
		if [ "$USELASTIMAGE" = "yes" ]
			then
			# movielength=$(qt_info "$movie" | grep duration | sed "s/.*duration : //" | cut -d "(" -f 1 | cut -d "." -f 1 | sort -n | tail -1 | sed "s/[^0-9]*//g")
			movielength=$(movietime "$movie"  | head -1 | cut -d " " -f 3)
			# baselength=$(date -j "+%s" 198001010000)
			# movielength=$(date -j +"%s" 19800101`ffmpeg -i "$movie" 2>&1 | grep Duration | sed "s/.*Duration: //" | cut -d "," -f 1 | cut -d "." -f 1 | sed "s/://" | sed "s/:/./"`)
			# movielength=`qt_info "$movie" |grep "track duration"|head -1|cut -d ":" -f 2|cut -d "." -f 1|sed "s/ //g"`
			if [ $movielength ]
				then
				# movielength=$(expr $movielength - $baselength)
				thumbpos=`expr $movielength - $THUMBBEGIN`
				duration="$thumbpos,`expr $thumbpos + 1`"
				echo "use last image: $duration"
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
	printf "$shortname "
	ln -s "$movie" "$TMP.$extension"
	if [ ! $? -eq 0 ] 
		then
		rm -f "$TMP.$extension"
		continue
	fi

		exportcommand="ffmpeg -i "
		exportparams="-y -ss $thumbpos -t 0.1 -f mjpeg"
		tmpimage=

	# echo $exportcommand "$TMP.$extension" $exportparams "$dir/$TMP.jpg"
	# $exportcommand "$TMP.$extension" -s "THUMBSIZE" $exportparams "$dir/$TMP-thumb.jpg" >/dev/null 2>/dev/null
	# 
	# if [ $? -eq 0 ] 
	# 	then
	# 	printf "." 
	# else
	# 	rm -f "$dir/$TMP.jpg"
	# 	continue
	# fi
	# 
	# rm -f "$TMP.$extension"
	if [ ! -f "$thumb" -o "$FORCE" = "yes" ]
		then
#		jpgresult=$(convert -resize ${THUMBSIZE}\! -border $THUMBSIZE -bordercolor black -crop $THUMBSIZE+0+0 -gravity center "$dir/$TMP.jpg" "$dir/$TMP-thumb.jpg" 2>&1 1>/dev/null)
		# jpgresult=$(convert -geometry ${THUMBSIZE}\! "$dir/$TMP.jpg" "$dir/$TMP-thumb.jpg" 2>&1 1>/dev/null)
#		jpgresult=$(convert -geometry $THUMBSIZE "$dir/$TMP.jpg" "$dir/$TMP-thumb.jpg" 2>&1 1>/dev/null)


		# if [ "$jpgresult" ] 
		# then
		# 	echo "ImageMagick convert error, using tmp file instead"
		# 	# echo "$jpgresult" | sed "s/^/    /"
		# 	mv "$dir/$TMP.jpg" "$dir/$TMP-thumb.jpg"
		# 	LARGEDISABLED="yes"
		# fi
		# printf "."
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
	
	if [ "$LARGEDISABLED" = "yes" ]
		then
		rm -f "$TMP.$extension" "$dir/$TMP.jpg" && echo
		continue
	fi
	
	if [ ! -f "$large" -o "$FORCE" = "yes" ]
		then
		# jpgresult=$(convert -geometry ${LARGESIZE}\! "$dir/$TMP.jpg" "$dir/$TMP-large.jpg" 2>&1 1>/dev/null)
		# if [ "$jpgresult" ] 
		# then
		# 	echo "ImageMagick convert error, skipping large"
		# 	# echo "$jpgresult"
		# 	rm -f "$dir/$TMP.jpg"
		# 	rm -f "$dir/$TMP-large.jpg"
		# 	continue
		# fi
		# printf "."
		$exportcommand "$TMP.$extension" $exportparams "$dir/$TMP-large.jpg" >/dev/null 2>/dev/null
		if [ $? -eq 0 ]
			then
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