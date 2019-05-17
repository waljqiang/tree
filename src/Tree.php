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
	private function build($data){
		if (!is_array($data)) {
            throw new InvalidException('Data must be an array');
        }

        $ids = array_column($data,$this->idKey);
        if(array_flip(array_flip($ids)) != $ids){
        	throw new InvalidException('Id key must be different');
        }

    	$data = array_combine(array_column($data,$this->idKey),$data);
	    $this->nodes = [];
	    if(!empty($data)){
	        foreach($data as $node){
	            if(isset($data[$node[$this->parentKey]])){
	                $data[$node[$this->parentKey]][$this->subKey][] = &$data[$node[$this->idKey]];
	            }else{
	                $this->nodes[] = &$data[$node[$this->idKey]];
	            }
	        }
	    }
	    unset($data);

        if(!empty($this->root)){
        	$nodes = $this->root;
        	foreach ($this->nodes as $node) {
        		if($this->modifyParent)
        			$node[$this->parentKey] = $this->root[$this->idKey];
        		$nodes[$this->subKey][] = $node;
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