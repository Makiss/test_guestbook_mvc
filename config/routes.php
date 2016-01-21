<?php

return array(
    'news/([0-9]+)' => 'news/view/$1', //actionView in NewsController
    'news' => 'news/index',  // actionIndex in NewsController
    'products' => 'products/list' // actionList in ProductController
);

?>