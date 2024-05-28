<?php

namespace App\Controllers;

class Gameprovider_control extends BaseController
{
    protected function reorderGameProviderAgentList()
    {
        $lng = strtoupper($_SESSION['lang']);

        $payload = [
            'userid' => $_SESSION['token']
        ];
        $res = $this->gameprovider_model->selectAllAgentGameProvider($payload);
        if( $res['code']==1 && $res['data']!=[] ):
            switch( $this->request->getPost('params')['category'] ):
                case 33: $category = 3; break;
                default:
                    $category = $this->request->getPost('params')['category'];
            endswitch;

            $data = [];
            foreach( $res['data'] as $g ):
                foreach( $g['type'] as $key=>$gtype ):
                    if( $gtype['type']==$category ):
                        if( $gtype['type']==3 ):
                            if( $g['code']!='RCB' && $this->request->getPost('params')['category']==3 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                $row['category'] = $gtype['type'];
                                $data[] = $row;
                            elseif( $g['code']=='RCB' && $this->request->getPost('params')['category']==33 ):
                                $row = [];
                                $row['status'] = $g['status'];
                                $row['code'] = $g['code'];
                                $row['name'] = $g['name'][$lng];
                                $row['order'] = $g['order'];
                                $row['category'] = $gtype['type'];
                                $data[] = $row;
                            endif;
                        else:
                            $row = [];
                            $row['status'] = $g['status'];
                            $row['code'] = $g['code'];
                            $row['name'] = $g['name'][$lng];
                            $row['order'] = $g['order'];
                            $row['category'] = $gtype['type'];
                            $data[] = $row;
                        endif;
                    endif;
                endforeach;
            endforeach;
            $games['data'] = $data;
            $result = array_merge(['code'=>$res['code'], 'message'=>$res['message']],$games);
        else:
            $result = ['code'=>$res['code'], 'message'=>$res['message']];
        endif;
        return $result;
    }

    public function gameProviderAgentList()
    {
        if( !session()->get('logged_in') ): return false; endif;

        $res = $this->reorderGameProviderAgentList();
        $keys = array_column($res['data'], 'order');
        array_multisort($keys, SORT_ASC, $res['data']);

        if( $res['code']==1 && $res['data']!=[] ):
            $data = [];
            foreach( $res['data'] as $g ):
                if( $g['status']!=3 ):
                    $row = [];
                    $row['status'] = $g['status'];
                    $row['code'] = $g['code'];
                    $row['name'] = $g['name'];
                    $row['order'] = $g['order'];
                    $row['category'] = $g['category'];
                    $data[] = $row;
                endif;
            endforeach;
            echo json_encode(['code'=>$res['code'], 'message'=>$res['message'],'data'=>$data]);
        else:
            echo json_encode($res);
        endif;
    }

    public function gameProviderList()
    {
        $res = $this->gameprovider_model->selectAllGameProviders([]);
        echo json_encode($res);
    }
}