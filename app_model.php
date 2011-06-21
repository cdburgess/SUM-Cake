<?php
/**
* App model class.
*
* @link http://github.com/cdburgess/SUM-Cake
* @package cake
* @subpackage app
* @license http://creativecommons.org/licenses/by-sa/3.0/
*/
class AppModel extends Model {
    
    /**
    * Var User id
    *
    * Used because the session data is not available to the model.
    *
    * @var string $user_id;
    * @access public
    */
    var $user_id;
    
    /**
     * beforeFind
     *
     * If the user_id is set, limit the data by the user_id
     *
     * @param array $queryData The query data that is headed to the model
     * @return array $queryData Pass the updated queryData back to caller
     * @access public
     */
    function beforeFind($queryData) {
        if($this->user_id = Configure::read('user_id')) {
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
    function beforeSave() {
        if($this->user_id = Configure::read('user_id')) {
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
    function getEnumValues($columnName = null) {
        if ($columnName == null) { return array(); } //no field specified

        //Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tableName = $db->fullTableName($this, false);

        //Get the values for the specified column (database and version specific, needs testing)
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'");

        //figure out where in the result our Types are (this varies between mysql versions)
        $types = null;
        if     ( isset( $result[0]['COLUMNS']['Type'] ) ) { $types = $result[0]['COLUMNS']['Type']; } //MySQL 5
        elseif ( isset( $result[0][0]['Type'] ) )         { $types = $result[0][0]['Type'];         } //MySQL 4
        else   { return array(); } //types return not accounted for

        //Get the values
        $values = explode("','", preg_replace("/(enum)\('(.+?)'\)/","\\2", $types) );

        //explode doesn't do assoc arrays, but cake needs an assoc to assign values
        $options = array();
        foreach ( $values as $value ) {
            //leave the call to humanize if you want it to look pretty
            $options[$value] = Inflector::humanize($value);
        }
        return $options;
    }
}