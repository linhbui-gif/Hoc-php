<?php
class NormalizeData {
    public function normalData($dataRelation,$dataMain,$oneToMany){
        // class riêng để chuẩn hóa data output
        $dataRelationGroup = [];
        list($tableRelation, $foreignKey) = array_values($oneToMany);
        foreach($dataRelation as $dataRelationItem) {
            $key = $dataRelationItem->$foreignKey;
            $dataRelationGroup[$key][] = $dataRelationItem;
        }
        foreach($dataMain as $dataMainItem) {
            $dataMainItem->$tableRelation = $dataRelationGroup[$dataMainItem->id];
        }
        return $dataMain;
    }
}