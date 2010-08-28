<?php
class AppModel extends Model {
    
    // set the user_id so it is available in any of the models as needed
    var $user_id;
    
    /**
     * beforeFind
     *
     * If the user_id is set, be sure to limit the data by the user_id
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
     * USAGE: $this->set('name', $this->Model->getEnumValues('db_enum_field_name'));
     */ 
    function getEnumValues($columnName = null)
    {
        if ($columnName==null) { return array(); } //no field specified

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
        $assoc_values = array();
        foreach ( $values as $value ) {
            //leave the call to humanize if you want it to look pretty
            $assoc_values[$value] = Inflector::humanize($value);
        }

        return $assoc_values;

    } //end getEnumValues
}
?>