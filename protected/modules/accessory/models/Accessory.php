<?php

/**
 * This is the model class for table "module".
 *
 * The followings are the available columns in table 'module':
 * @property integer $id
 * @property string  $name
 * @property string  $db_prefix
 * @property string  $description
 */

/**
 * TODO: везде сделать исключения в случае ошибок
 */
class Accessory extends CActiveRecord {
	public $generalTable = 'accessory';
	/**
	 * ID текущего модуля в таблице module
	 */
	public $moduleId = 240;
	/**
	 * @return string the associated database table name
	 */
	public function tableName () {
		return 'accessory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules () {
		return array ();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations () {
		return array ();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels () {
		return array (
			'id'        => 'ID',
			'parent_id' => 'ID родительского объекта',
			'object_id' => 'ID дополнительных свойств объекта',
			'type_id'   => 'ID типа объекта',
			'name'      => 'Имя объекта',
			'rights'    => 'Права для объекта',
			'path'      => 'Путь до объекта',
			'sort'      => '',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search () {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		return new CActiveDataProvider($this, array (
													'criteria' => $criteria,
											  ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Module the static model class
	 */
	public static function model ($className = __CLASS__) {
		return parent::model($className);
	}

	public function getList ($id) {
		try{
			$db  = $this->getDb();
			$arr = $db->createCommand()->select('m.can_delete, m.id id, m.name name, mmt.name type_name, mh.child_id_type child_type, m.sort')
					  ->from($this->generalTable.' m')
					  ->leftJoin('module_type mt', 'm.type_id=mt.id')
					  ->leftJoin('module mmt','mt.id=mmt.object_id and mmt.type_id=4')
					  ->leftJoin($this->generalTable.'_hierarchy mh', 'm.type_id=mh.parent_id_type')
					  ->where('m.parent_id=:id',array (':id' => $id))
					  ->order('m.sort asc, m.name asc')->queryAll();
			return !$arr
				?array ()
				:$arr;
		} catch (Exception $e){
			throw new Exception('Не удалось получить список.');
		}
	}

	public function getDetail ($id) {
		try {
			$db = $this->getDb();
			$result= $db->createCommand()->select('m.object_id id, mt.table_name')
				->from('module_type mt')
				->join($this->generalTable.' m','m.type_id = mt.id')
				->where('m.id = :id',array(':id'=>$id))->queryRow();
			return $db->createCommand()
				->select('*')
				->from($this->generalTable.' m')
				->join($result['table_name'].' ext','m.object_id = ext.id')
				->where('m.id = :id',array(':id'=>$id))->queryRow();
		} catch (Exception $e){
			throw new Exception("Не удалось получить данные записи.");
		}
	}

	public function getFields ($id) {
		try {
			$db       = $this->getDb();
			$query    = $db->createCommand()->select(
							 'tab.id tab_id, tab.name tab_name, mod_p.table param_table, mod_p.field param_field, mod_p.type field_type, param.name field_name, mod_p.exp exp, mod_p.exp_description, mod_p.description field_description'
			)              	->from($this->generalTable.' obj') // извлекаем сам объект
							 ->join('module typ', 'typ.object_id = obj.type_id and typ.type_id=4') // извлекаем закладки типа объекта
							 ->join('module tab', 'typ.id = tab.parent_id and tab.type_id=2') // извлекаем тип объекта
							 ->join('module param', 'param.parent_id = tab.id and param.type_id=3') // извлекаем параметры объекта
							 ->join('module_param mod_p', 'mod_p.id = param.object_id')->where('(mod_p.visible&2>0) AND obj.id='.$id)->order(
							 'tab.sort asc, param.sort asc'
				);
			//echo "<pre>";print_r($query->text);echo "</pre>";die();
			$queryAll = $query->queryAll();
			return $queryAll;
		} catch (Exception $e){
			throw new Exception('Не удалось получить данные записи (1).');
		}
	}
	public function getFieldsForType ($id) {
		try {
			$db       = $this->getDb();
			$query    = $db->createCommand()->select(
						   'tab.id tab_id, tab.name tab_name, mod_p.table param_table, mod_p.field param_field, mod_p.type field_type, param.name field_name, mod_p.exp exp, mod_p.exp_description, mod_p.description field_description')
						   ->from('module typ') // извлекаем закладки типа объекта
						   ->join('module tab', 'typ.id = tab.parent_id and tab.type_id=2') // извлекаем тип объекта
						   ->join('module param', 'param.parent_id = tab.id and param.type_id=3') // извлекаем параметры объекта
						   ->join('module_param mod_p', 'mod_p.id = param.object_id')->where('mod_p.visible&1>0 AND typ.object_id='.$id)->order(
						   'tab.sort asc, param.sort asc'
				);
			//echo "<pre>";print_r($query->text);echo "</pre>";die();
			$queryAll = $query->queryAll();
			return $queryAll;
		} catch (Exception $e){
			throw new Exception("Не удалось получить список полей для новой записи.");
		}
	}

	public function getHierarchy ($id) {
		try {
			$db = $this->getDb();
			if ($id > 0) {
				return $db->createCommand()->select('mt.name name, mt.object_id id')->from($this->generalTable.' m')->join(
						  $this->generalTable.'_hierarchy mh',
						  'mh.parent_id_type = m.type_id'
				)     ->join('module mt', 'mt.object_id = mh.child_id_type and mt.type_id=4')->where(
						  'm.id=:id',
						  array (':id' => $id)
					)     ->queryAll();
			} else {
				return $db->createCommand()->select('m.name name, m.object_id id')->from('module m')->join(
						$this->generalTable.'_hierarchy mh',
					  	'mh.child_id_type = m.object_id'
					)     ->where('mh.parent_id_type=0 and mh.module_id='.$this->moduleId.' and m.type_id=4')->queryAll();
			}
		} catch (Exception $e){
			throw new Exception("Не удалось получить данные о наследуемых объектах.");
		}
	}

	/**
	 * @return mixed
	 */
	protected function getDb () {
		/**
		 * @var $db CDbConnection
		 */
		$db = Yii::app()->db;
		return $db;
	}

	/**
	 * TODO: сделать роллбэк
	 */
	public function setElementFull ($data, $new = false) {
		$db = $this->getDb();
		$transaction = $db->beginTransaction();
		try{
			foreach($data as $table_name=>$values) {
				if($table_name!=$this->generalTable){
					if (!$db->createCommand()->insert($table_name,$values)) {
						throw new Exception('Не удалось записать дополнительные свойства.');
					}
				}
			}
			$data[$this->generalTable]['object_id'] = $db->getLastInsertId();
			if (!$db->createCommand()->insert($this->generalTable,$data[$this->generalTable])) {
				throw new Exception('Не удалось создать.');
			}
			$transaction->commit();
		} catch (Exception $e){
			$transaction->rollback();
			throw new Exception($e->getMessage());
		}

	}

	public function getData ($id, $tables, $fields){
		try {
			sizeof($tables)>1
				&& ($ext = $tables[0]!=$this->generalTable?$tables[0]:$tables[1])
				|| $ext=false;
			$query = $this->getDb()->createCommand()->select(implode(', ', $fields))->from($this->generalTable)->where(
																											   $this->generalTable.'.id=:id',
						  array (':id' => $id)
				);
			$ext && $query->join($ext,"$ext.id = ".$this->generalTable.".object_id");
			return $query->queryRow();
		} catch (Exception $e){
			throw new Exception("Не удалось получить данные записи (2).");
		}
	}

	/**
	 * @param $data   Массив данных для обновления в виде
	 *                table=>array(
	 *                field=>value
	 *                ...
	 *                field=>value
	 *                )
	 *                ...
	 *                table=>array(
	 *                field=>value
	 *                ...
	 *                field=>value
	 *                )
	 * @throws Exception
	 */
	public function updateDate ($data){
		try {
			$db = $this->getDb();
			$id = $data[$this->generalTable]['id'];
			if(!$id){
				throw new Exception();
			}
			unset($data[$this->generalTable]['id']);
			$art = $db->createCommand()->select('*')->from($this->generalTable)->where('id=:id',array(':id'=>$id))->queryRow();

			if(!$art){
				throw new Exception();
			}
			foreach($data as $table_name=>$values) {
				$condition_id = $table_name==$this->generalTable
					?$art['id']
					:$art['object_id'];
				$db->createCommand()->update($table_name, $values, 'id=:id', array(':id'=>$condition_id));
			}
		} catch (Exception $e){
			throw new Exception("Не удалось обновить данные.");
		}
	}

	public function deleteModule ($id){
		try {
			$db = $this->getDb();
			$result= $db->createCommand()->select('m.can_delete, m.object_id id, mt.table_name')
				->from('module_type mt')
				->join($this->generalTable.' m','m.type_id = mt.id')
				->where('m.id = :id',array(':id'=>$id))->queryRow();
			if($result['can_delete']==0){
				throw new Exception('Данную запись нельзя удалить.');
			}
			$db->createCommand()->delete($this->generalTable,'id=:id',array(':id'=>$id));
			$db->createCommand()->delete($result['table_name'],'id=:id',array(':id'=>$result['id']));
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function getBreadcrumbs ($id){
		try {
			$db = $this->getDb();
			$query = $db->createCommand()->select('bc.id, bc.name')->from($this->generalTable.' m')->join(
					   	$this->generalTable.' bc',
						'FIND_IN_SET(bc.id, m.path) OR bc.id = m.id'
			)       ->where('m.id=:id', array (':id' => $id))->order('m.path asc');
			return $query->queryAll();
		} catch (Exception $e){
			throw new Exception("Не удалось получить данные о навигации.");
		}


	}

	/**
	 * @param $id
	 * @internal param $data
	 * @internal param $db
	 * @return mixed
	 */
	public function getElement ($id) {
		$db = $this->getDb();
		return $db->createCommand()->select('*')->from('module m')->join('module_type mt', 'mt.id = m.type_id')
					 ->where('m.id=:id', array (':id' => $id))->queryRow();
	}

	/**
	 * @param $table_name
	 * @param $id
	 * @internal param $tab_name
	 * @return mixed
	 */
	public  function getElementExt ($table_name, $id) {
		$db = $this->getDb();
		return $db->createCommand()->select('*')->from($table_name)->where(
						'id=:id',
						array (':id' => $id)
			)           ->queryAll();

	}
}
