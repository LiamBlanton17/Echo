<?php

return new class extends EchoModel {

    public function getAllUsers(EchoRequest $req, EchoResponse $res) {
        // Fake CPU-intensive task
        $data = $req->cache->find('Data', FALSE);
        if(isset($data['sum'])){
            $sum = $data['sum'];
        } else{
            $sum = 0;
            for ($i = 0; $i < 2000000; $i++) {
                $sum += sqrt($i);
            }
            $req->cache->put('Data', ['sum' => $sum], new EchoDataCacheTTL(), FALSE);
        }
        $res->status(200)->json([
            'message' => 'Getting all users!',
            'Sum!' => $sum
        ]);
    }

};