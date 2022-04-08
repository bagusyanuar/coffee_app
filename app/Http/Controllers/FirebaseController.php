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
        $SERVER_KEY = 'AAAABjhw5Jk:APA91bHWdTCXx05ijYKH-QBsG6r2TlMalD51qxsUqU2u-jz1ry5xrWMneXlOU7X5xmRe4GCrcXeP4k6WuVu_YLqIbfYEx_1UiQMGJCEOBfEXqLUjg-6JTbGw_3ubV4nxlJvLYa9lRjUy';
        $to = 'cbgDY-Z82g7wkxLx-CKG90:APA91bEL9L06icPSxtxRnejt-V1UzcOceI7Hhc71jOrk7RyCZWoor3o9WfLWemCu1XvDbpJB00cKdnfe_3ybj9sKAE_hWpgVXmdtiaQWSZo4qmqTo95r14aDk1RMyDCeQmm8iXvI-aXh';
        $message = CloudMessage::fromArray([
            'token' => $to,
            'notification' => [
                'title' => 'Test',
                'body' => 'Cek'
            ],
        ]);

        $this->messaging->send($message);
    }
}
