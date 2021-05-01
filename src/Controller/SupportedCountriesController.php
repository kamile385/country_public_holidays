<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SupportedCountries;

class SupportedCountriesController extends AbstractController
{
    #[Route('/countries', name: 'countries')]
    public function createSupportedCountries(): Response
    {
        $client = HttpClient::create();
        $responseSupportedCountries = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries');

        $contentSupportedCountries = json_decode($responseSupportedCountries->getContent(), true);

        foreach($contentSupportedCountries as $val)
        {
            $entityManager = $this->getDoctrine()->getManager();

            $countries = new SupportedCountries();
            $countries->setCountryCode($val['countryCode']);
            $countries->setRegions($val['regions']);
            $countries->setHolidayTypes($val['holidayTypes']);
            $countries->setFullName($val['fullName']);
            $countries->setFromDate($val['fromDate']);
            $countries->setToDate($val['toDate']);

            $entityManager->persist($countries);

            $entityManager->flush();
        }
        return new Response('Saved new product with id '.$countries->getId());
    }
}
