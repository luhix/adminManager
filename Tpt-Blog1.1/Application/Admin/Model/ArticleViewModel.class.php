<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class ArticleViewModel extends ViewModel
{
	public $viewFields = array(
		'article'=>array('id','title','pic','commend','choice','time','open','tid','_type'=>'LEFT'),
		'category'=>array('name','type','_on'=>'article.tid=category.id')
		);
	




























}