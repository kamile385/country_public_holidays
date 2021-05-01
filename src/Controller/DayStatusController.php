<?php


namespace App\Controller;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DayStatusController
{
//    #[Route('/{date}/{country}', name: 'day_status')]
//    public function dayStatus($date, $country)
//    {
////        &date=05-07-2022&country=svk
//        $client = HttpClient::create();
//        $contentHoliday = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=isPublicHoliday',
//            [
//                'headers' => [
//                    'Cache-Control' => 'no-cache',
//                    'Connection' => 'keep-alive'
//                ],
//                'query' => [
//                    'date' => $date,
//                    'country' => $country
//                ]
//            ]);
//
//        $contentWorkDay = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=isWorkDay',
//            [
//                'headers' => [
//                    'Cache-Control' => 'no-cache',
//                    'Connection' => 'keep-alive'
//                ],
//                'query' => [
//                    'date' => $date,
//                    'country' => $country
//                ]
//            ]);
//
//        $contentHoliday = json_decode($contentHoliday->getContent(), true);
//        $contentWorkDay = json_decode($contentWorkDay->getContent(), true);
//
//dump($contentWorkDay);
//        $response = new Response();
//        $response->setContent(json_encode($contentWorkDay));
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;
//    }

}