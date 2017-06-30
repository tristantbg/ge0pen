<?php if(!defined('KIRBY')) exit ?>

title: Project
files: true
pages: false
files:
  fields:
    videolink:
      label: Video ID
      type: text
      icon: code
      help: Youtube ID or Vimeo ID
    videoexternal:
      label: Video external file link
      type: url
    videofile:
      label: Video File
      type: select
      options: videos
fields:
  prevnext: prevnext
  title:
    label: Title
    type:  text
    width: 1/2
  subtitle:
    label: Subtitle
    type: text
    width: 1/2
  jobtitle:
    label: Job title
    type: text
    width: 1/2
  featured:
    label: Featured image
    type: image
    help: Required to display project
    width: 1/4
  position:
    label: Position
    type: select
    width: 1/4
    columns: 1
    default: pos-random
    options:
      pos-top: Top
      pos-middle: Middle
      pos-bottom: Bottom
      pos-random: Random
  medias: 
    label: Images
    type: images
  text:
    label: Description (SEO)
    type: textarea
    help: For search engines
