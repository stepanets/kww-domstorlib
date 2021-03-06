<?php

/**
 * Description of SaleAnnotation
 *
 * @author pahhan
 */
abstract class Ds_Detail_Block_Flat_SupplyAnnotationBlock extends Ds_Detail_Block_AbstractBlock
{

    protected function getSquare()
    {
        $data = $this->getData();
        return sprintf('%s/%s/%s', $data->isSetAnd('square_house') ? $data->square_house : '-', $data->isSetAnd('square_living') ? $data->square_living : '-', $data->isSetAnd('square_kitchen') ? $data->square_kitchen : '-'
        );
    }

    protected function getFloors()
    {
        $data = $this->getData();
        return sprintf('%s/%s', $data->isSetAnd('object_floor') ? $data->object_floor : '-', $data->isSetAnd('building_floor') ? $data->building_floor : '-'
        );
    }

    protected function getAddress()
    {
        $data = $this->getData();
        $out = '';
        if (!($data->isSetAndArray('Street') or $data->Street->name))
            return;

        $out.= ($data->Street->isSetAnd('abbr') ? $data->Street->abbr . ' ' : '') . $data->Street->name;
        if ($data->isSetAnd('building_num'))
            $out.= ', ' . $data->building_num;
        if ($data->isSetAnd('corpus'))
            $out.= (is_numeric($data->corpus) ? '/' : '') . $data->corpus;

        return $out;
    }

    protected function getDistrict()
    {
        $data = $this->getData();
    }

    abstract public function getCost();

    public function render(array $params = array())
    {
        $data = $this->getData();
        $out = '';
        if ($data->isSetAnd('room_count'))
            $out.= sprintf('%d комн.', $data->room_count);
        if ($data->isSetAnd('flat_type'))
            $out.= ', ' . $data->flat_type;
        if ($rooms = $this->getSquare())
            $out.= ', ' . $rooms;
        if ($floors = $this->getFloors())
            $out.= ', ' . $floors;
        if ($address = $this->getAddress())
            $out.= ', ' . $address;
        if ($data->isSetAndArray('District') and $dist = $data->District->name)
            $out.= ', ' . $dist;
        if ($data->isSetAndArray('City') and $city = $data->City->name)
            $out.= ', ' . $city;
        if ($price = $this->getCost())
            $out.= ', ' . $price;
        if ($data->isSetAnd('note_addition'))
            $out.= ', ' . $data->note_addition;
        return $out;
    }

}
