#!/bin/bash

i=1;
for vid in trump_yt/*; do
	# ffmpeg -i "$vid" ad_$i.mp4;
	$new_title = echo $vid | grep -Eo "^([A-Za-z0-9 '.,'\!’]+)";
	$suffix = echo $vid | grep -Eo "\.[a-z0-9]+$";
	cp $vid $new_title$suffix;
	((i=i+1));
done;
