<?php

/**
 * DB Controller for scrollider_settings.
 *
 * @author Hopefighter
 */
class settingsController extends Database {
    
    function getSettings() {
        
        $query = $this->_db->prepare("SELECT * FROM scrolldier_settings ORDER BY id DESC");
        
        $settings = $this->getResultArray($query);
        
        return $settings;
    }
    
    function getSettingsByType($type) {
        $query = $this->_db->prepare("SELECT * FROM scrolldier_settings WHERE type=:type ORDER BY id DESC");
        
        $params = array(
            "type" => $type
        );
        
        $this->arrayBinder($query, $params);
        
        $settings = $this->getResultArray($query);
        
        return $settings;
    }
    
    function getSettingsAdvanced($query) {
        
        $settings = $this->getResultArray($query);
        
        return $settings;
    }
    
    function newSetting($name, $value_int, $value_var, $type) {
        $query = $this->_db->prepare("INSERT INTO scrolldier_settings (name, value_int, value_var, type) "
                . "VALUES (:name, :value_int, :value_var, :type");
        
        $params = array(
            "name" => $name,
            "value_int" => $value_int,
            "value_var" => $value_var,
            "type" => $type
        );
        
        $this->arrayBinder($query, $params);
        
        return $query->execute() ? true : false;
    }
    
    function removeSetting($id) {
        
        $query = $this->_db->prepare("DELETE FROM scrolldier_settings WHERE id=:id");
        
        $params = array(
            "id" => $id
        );
        
        $this->arrayBinder($query,$params);
        
        return $query->execute() ? true : false;
    }
    
    function updateSetting($id, $name, $value_int, $value_var, $type) {
        
        $query = $this->_db->prepare("UPDATE scrolldier_settings SET "
                . "name=:name, "
                . "value_int=:value_int, "
                . "value_var=:value_var, "
                . "type=:type "
                . "WHERE id=:id");
        
        $params = array(
            "id" => $id,
            "name" => $name,
            "value_int" => $value_int,
            "value_var" => $value_var,
            "type" => $type
        );
        
        $this->arrayBinder($query, $params);
        
        return $query->execute() ? true : false;
    }
    
    private function getResultArray($query) {
        
        if ($query->execute()) {
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $settings = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "value_int" => $row['value_int'],
                    "value_var" => $row['value_var'],
                    "type" => $row['type']
                );
            }
            return $settings;
        }
    }
}