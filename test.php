<?php
include_once("./vendor/autoload.php");
use Nova\Tree\Tree;

$data = [
   			[
	            "id" => 1,
	            "uid" => 46,
	            "gw_id" => "44D1FA19F686",
	            "parent_gw_id" => 0,
	            "name" => "A"
        	],
			[
				"id" => 2,
	            "uid" => 46,
	            "gw_id" => "409027E83792",
	            "parent_gw_id" => "44D1FA19F686",
	            "name" => "B"
	        ],
	        [
	            "id" => 3,
	            "uid" => 46,
	            "gw_id" => 1,
	            "parent_gw_id" => "409027E83792",
	            "name" => "C"
            ],
            [
	            "id" => 4,
	            "uid" => 46,
	            "gw_id" => "78D38DF95E8D",
	            "parent_gw_id" => 1,
	            "name" => "D"
        	],
        	[
	            "id" => 5,
	            "uid" => 46,
	            "gw_id" => "78D38DB8ABDC",
	            "parent_gw_id" => "78D38DF95E8D",
	            "name" => "D"
            ],
            [
	            "id" => 6,
	            "uid" => 46,
	            "gw_id" => "B8975A212987",
	            "parent_gw_id" => "78D38DF95E8D",
	            "name" => "E"
        	],
        	[
            "id" => 7,
            "uid" => 46,
            "gw_id" => 2,
            "parent_gw_id" => "409027E83792",
            "name" => "F"
        	],
        	[
	            "id" => 100,
	            "gw_id" => 200,
	            "parent_gw_id" => 400,
	            "name" => "G"
      		]
      	];
$tree = new Tree($data,['root'=>['id'=>0,'gw_id'=>0,'parent_gw_id'=>-1,'name'=>'1'],'id'=>'gw_id','parent'=>'parent_gw_id','children','id',SORT_ASC]);

$rs = $tree->getNodes();



echo '<pre>';
print_r($rs);
echo '</pre>';