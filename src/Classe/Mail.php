<?php


namespace App\Classe;


use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    //Clés apis de Mailjet
    private $api_key = '315e9b1f5f1708ec6b9825de766ed166';
    private $api_secret_key = '5a9ca7979c873a3988fcc56890cc2bf2';

    //Fonction d'envoi d'email
    public function send($to_user_email, $to_user_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_secret_key, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mymomsbox7@gmail.com",
                        'Name' => "My Mom's Box"
                    ],
                    'To' => [
                        [
                            'Email' => $to_user_email,
                            'Name' => $to_user_name
                        ]
                    ],
                    'TemplateID' => 2108553,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content, //Variable créer dans Mailjet sur le template 'model'
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}