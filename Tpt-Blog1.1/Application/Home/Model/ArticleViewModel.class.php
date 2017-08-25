<?php
namespace Home\Model;
use Think\Model\ViewModel;
class ArticleViewModel extends ViewModel
{
	public $viewFields = array(
		'article'=>array('id','title','author','view','description','keywords','pic','commend','choice','time','open','_type'=>'LEFT'),
		'category'=>array('name','type','_on'=>'article.tid=category.id')
		);
	




























}