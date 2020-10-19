#!/bin/bash

i=1
for vid in *.mp4; do
	ffmpeg -i "$vid" ad_$i.webm
	((i=i+1))
done
