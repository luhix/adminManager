<?php
return array(
'DB_CHARSET'=> 'utf8',
'URL_HTML_SUFFIX'=>'html',
'LOAD_EXT_CONFIG' => 'db,webconf',
'URL_ROUTER_ON' => TRUE,
'URL_MODEL'=>'0',
'TMPL_FILE_DEPR'=>'_',
'TMPL_EXCEPTION_FILE'  => APP_DEBUG ? THINK_PATH.'Tpl/think_exception.tpl' : './Public/404.html',
'URL_ROUTE_RULES'=>array(     
'/^index\/(\d+)$/' => 'Home/index/category?id=:1',
'/^article\/(\d+)$/' => 'Home/index/article?id=:1',
'/^search/' => 'Home/index/search',
'/^tags/' => 'Home/index/tags',
),
'TMPL_PARSE_STRING'=> array(
'__ADMIN__' => __ROOT__.'/Public',
),
);