<?php if(!defined('KIRBY')) exit ?>

title: Category
files: false
pages:
  template: project
  limit: 50
deletable: false
fields:
  title:
    label: Title
    type:  text
  sortable:
    label: Index sorting
    type:  sortable
    layout:  base
    variant: null
    limit: false
    parent: null
    prefix: null
    options:
      limit: false