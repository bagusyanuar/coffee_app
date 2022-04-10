<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseController extends CustomController
{

    private Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        parent::__construct();
        $this->messaging = $messaging;
    }

    public function index()
    {
//        $SERVER_KEY = 'AAAABjhw5Jk:APA91bHWdTCXx05ijYKH-QBsG6r2TlMalD51qxsUqU2u-jz1ry5xrWMneXlOU7X5xmRe4GCrcXeP4k6WuVu_YLqIbfYEx_1UiQMGJCEOBfEXqLUjg-6JTbGw_3ubV4nxlJvLYa9lRjUy';
        $to = 'f1sZWCMYD6nj2cx34Uvuk8:APA91bEf_eRaKgV1bzoAXntRSEgjWmQkXZ2gh9qw_8X8qvjT1VhYWHasnu0tKpKHL658f5vkjg7eHbOkL7yUejTchnGRnf9LIRY-XS0eF-PLgLj4qW8TS9bbdXnWrF20YOoyiTskA-Th';
        $data['title'] = "Pesanan Baru";
        $data['body'] = "Mendapatkan Pesanan Baru";
        $message = CloudMessage::fromArray([
            'token' => $to,
            'data'  => $data,
            'webpush' => [
                'headers' => [
                    'Urgency' => 'normal',
                ],
            ],

        ]);

        $this->messaging->send($message);
        return $this->jsonResponse("oke", 200);
    }
}
