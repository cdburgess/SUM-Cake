<?php
/**
* App model class.
*
* @link http://github.com/cdburgess/SUM-Cake
* @package cake
* @subpackage app
* @license http://creativecommons.org/licenses/by-sa/3.0/
*/
App::uses('Model', 'Model');
class AppModel extends Model {

/**
* Var User id
*
* Used because the session data is not available to the model.
*
* @var string $user_id;
* @access public
*/
    public $user_id;

/**
* Filter fields
*
* Search fields for filtering model results.
* @var array $searchFields
* @access public
*/
	public $searchFields = array();

/**
 * beforeFind
 *
 * If the user_id is set, limit the data by the user_id
 *
 * @param array $queryData The query data that is headed to the model
 * @return array $queryData Pass the updated queryData back to caller
 * @access public
 */
    public function beforeFind($queryData) {
		$this->user_id = Configure::read('user_id');
    	if($this->user_id) {
            // all records associated to a user use user_id as the foreign key
            if(isset($this->_schema['user_id'])) {
                if(isset($this->user_id)) {
                    $queryData['conditions'][$this->name.'.user_id'] = $this->user_id;
                }
            }
            // if this is the user model, then the user_id is actually id
            if($this->name == 'User') {
                $queryData['conditions'][$this->name.'.id'] = $this->user_id;
            }
        }
        return $queryData;
    }

/**
 * beforeSave
 *
 * Make sure the user_id is set correctly for users trying to save their data.
 *
 * @return true
 * @access public
 */
    public function beforeSave($options = Array()) {
		$this->user_id = Configure::read('user_id');
        if($this->user_id) {
            if(isset($this->_schema['user_id'])) {
                $this->data[$this->name]['user_id'] = $this->user_id;
            }
        }
        return true;
    }

/**
 * Get Enum Values
 *
 * Get the enum values for any column that have ENUM values.
 *
 * @param string $columnName The name of the column in the model that is the enum (MySQL Specific)
 * @return array $options The options of all enum items
 * @example $this->set('name', $this->Model->getEnumValues('db_enum_field_name'));
 * @access public
 */
    public function getEnumValues($columnName = null) {
		return $this->actsAs['Enum']['fields'][$columnName];
    }

/**
* Build Filter Conditions
*
* Return conditions based on searchable fields and filter for the model to use in the conditions.
*
* @param string $filter The string to search for.
* @return array $conditions The conditions to use in the SQL
* @access public
*/
	public function build_filter_conditions($filter = null){
		$conditions = array();
		if($filter){
			foreach($this->searchFields as $field){
				$conditions['OR']["$field LIKE"] = '%' . $filter . '%';
			}
		}
		return $conditions;
	}
}