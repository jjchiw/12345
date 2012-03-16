<?php

class DataProvider extends CActiveDataProvider
{
        //Will fire the ActiveFinder together() method when true
        public $joinAll=false;
        
        /**
         * Fetches the data from the persistent data storage.
         * @return array list of data items
         */
        protected function fetchData()
        {
                $criteria=clone $this->getCriteria();
                if(($pagination=$this->getPagination())!==false)
                {
                        $pagination->setItemCount($this->getTotalItemCount());
                        $pagination->applyLimit($criteria);
                }
                if(($sort=$this->getSort())!==false)
                        $sort->applyOrder($criteria);
                
                //Use together() for query?
                if ($this->joinAll) 
                { 
                        return CActiveRecord::model($this->modelClass)->with($criteria->with)->together()->findAll($criteria);
                }
                else
                {
                        return CActiveRecord::model($this->modelClass)->findAll($criteria);
                }
        }
        
}