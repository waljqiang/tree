<?php
namespace Nova\Tree;
use Nova\Tree\Exceptions\InvalidException;
use Nova\Tree\Node\Node;

class Tree{

	private $root;

	private $idKey = 'id';

	private $parentKey = 'parentid';

	private $subKey = 'children';

	private $sortKey = 'id';

	private $sort = SORT_ASC;

	private $modifyParent = true;

	//树结构
	private $nodes;
	/**
	 *
	 * @param mixed $data    数据
	 * @param array  $options 设置项
	 */
	public function __construct($data,$options=[]){
		if(isset($options['root'])){
			$this->root = $options['root'];
		}

		if(isset($options['id'])){
			$this->idKey = $options['id'];
		}

		if(isset($options['parent']))
			$this->parentKey = $options['parent'];

		if(isset($options['sub'])){
			$this->subKey = $options['sub'];
		}

		if(isset($options['sortKey'])){
			$this->sortKey = $options['sortKey'];
		}

		if(isset($options['sort'])){
			$this->sort = $options['sort'];
		}

		if(isset($options['modifyParent'])){
			$this->modifyParent = $options['modifyParent'];
		}

		$this->build($data);
	}

	/**
	 * to tree 
	 *
	 * @param  array $data 数据
	 * @return array
	 */
	private function build($datas){
		if (!is_array($datas)) {
            throw new InvalidException('Data must be an array');
        }

        $ids = array_column($datas,$this->idKey);
        if(array_flip(array_flip($ids)) != $ids){
        	throw new InvalidException('Id key must be different');
        }

    	$datas = array_combine(array_column($datas,$this->idKey),$datas);

	    $nodes = [];
	    if(!empty($datas)){
	        foreach($datas as $data){
	            if(isset($datas[$data[$this->parentKey]])){
	            	$datas[$data[$this->idKey]][$this->subKey] = [];
	                $datas[$data[$this->parentKey]][$this->subKey][] = &$datas[$data[$this->idKey]];
	            }else{
	            	$datas[$data[$this->idKey]][$this->subKey] = [];
	                $nodes[] = &$datas[$data[$this->idKey]];
	            }
	        }
	    }
	    $this->nodes = $nodes;
	    unset($datas);
	    unset($nodes);

        if(!empty($this->root)){
        	$nodes = $this->root;
        	if(!empty($this->nodes)){
	        	foreach ($this->nodes as $node) {
	        		if($this->modifyParent)
	        			$node[$this->parentKey] = $this->root[$this->idKey];
	        		$nodes[$this->subKey][] = $node;
	        	}
	        }
        	$this->nodes = $nodes;
        }
	}

	public function getNodes(){
		return $this->nodes;
	}

	private function pr($var){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}


}