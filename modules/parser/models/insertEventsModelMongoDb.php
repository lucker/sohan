<?php
namespace app\modules\parser\models;

class insertEventsModelMongoDb extends insertEvents
{
    protected $mongo;
    protected $bulk;
    function __construct(){
        parent::__construct();
        $this->mongo = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        $this->bulk = new \MongoDB\Driver\BulkWrite;
    }
    function __destruct(){
        parent::__destruct();
    }
    public function insertOneRow()
    {
        $doc = [
            '_id' => new \MongoDB\BSON\ObjectID,     #Generate MongoID
            'name'    => 'rewrewrewrew',
            'age'     => 14,
            'roll_no' => 1,
            'POLE HERNNI' => 'HENY'
        ];

        $this->bulk->insert($doc);
        $this->mongo->executeBulkWrite('sohan.events', $this->bulk);
    }
    public function getDataMongoDb($namespace, $query) {
        $search = new \MongoDB\Driver\Query($query);
        $cursor = $this->mongo->executeQuery($namespace, $search);
        $array = $cursor->toArray();
        /*foreach ($array as $key => $value) {
            $array[$key] = (array)$value;
        }
        echo '<pre>';
        print_r($array);
        echo '</pre>';*/
        return $array;
    }
    public function insertEvents($matchId, $parametr, $nameId, $odd, $bukid) {
        $data = $this->getDataMongoDb('sohan.events', [
            'matches_id' => $matchId,
            'name_id' => $nameId,
            'parametr' => $parametr,
            'bukid' => $bukid
        ]);
        $doc = [
            ''
        ];
    }

}