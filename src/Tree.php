<?php
namespace Nova\Tree;
use Nova\Tree\Exceptions\InvalidException;
use Nova\Tree\Node\Node;

class Tree{

	private $_root;

	private $_idKey = 'id';

	private $_parentKey = 'parentid';

	private $_subKey = 'children';

	private $_sortKey = 'id';

	private $_sort = SORT_ASC;

	private $_modifyParent = true;

	//树结构
	private $_nodes;
	/**
	 *
	 * @param mixed $data    数据
	 * @param array  $options 设置项
	 */
	public function __construct($data,$options=[]){
		if(isset($options['root'])){
			$this->_root = $options['root'];
		}

		if(isset($options['id'])){
			$this->_idKey = $options['id'];
		}

		if(isset($options['parent']))
			$this->_parentKey = $options['parent'];

		if(isset($options['sub'])){
			$this->_subKey = $options['sub'];
		}

		if(isset($options['sortKey'])){
			$this->_sortKey = $options['sortKey'];
		}

		if(isset($options['sort'])){
			$this->_sort = $options['sort'];
		}

		if(isset($options['modifyParent'])){
			$this->_modifyParent = $options['modifyParent'];
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

    	$data = array_combine(array_column($data,$this->_idKey),$data);
	    $this->_nodes = [];
	    if(!empty($data)){
	        foreach($data as $node){
	            if(isset($data[$node[$this->_parentKey]])){
	                $data[$node[$this->_parentKey]][$this->_subKey][] = &$data[$node[$this->_idKey]];
	            }else{
	                $this->_nodes[] = &$data[$node[$this->_idKey]];
	            }
	        }
	    }
	    unset($data);

        if(!empty($this->_root)){
        	$nodes = $this->_root;
        	foreach ($this->_nodes as $node) {
        		if($this->_modifyParent)
        			$node[$this->_parentKey] = $this->_root[$this->_idKey];
        		$nodes[$this->_subKey][] = $node;
        	}
        	$this->_nodes = $nodes;
        }
	}

	public function getNodes(){
		return $this->_nodes;
	}

	private function pr($var){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}


}