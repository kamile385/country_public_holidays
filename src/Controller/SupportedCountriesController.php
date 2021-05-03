<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SupportedCountries;

class SupportedCountriesController extends AbstractController
{
    #[Route('/', name: 'countries')]
    public function getCountriesList(Request $request)
    {
        $repositoryCountries = $this->getDoctrine()->getRepository(SupportedCountries::class);
        $countries = $repositoryCountries->findAll();

        if (!$countries) {
            $client = HttpClient::create();
            $contentCountries = $client->request('GET', 'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries');
            $contentCountries = json_decode($contentCountries->getContent(), true);

            foreach ($contentCountries as $val) {
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

                $countryFullName[] = $val['fullName'];
            }
        } else {
            for ($i = 0; $i < count($countries); $i++) {
                $countryFullName[] = $countries[$i]->getFullName();
            }
        }
        $response = new Response();
        $response->setContent(json_encode($countryFullName));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}