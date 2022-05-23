<?php

namespace App\Controller;

use App\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\countOf;

class SiteController extends AbstractController
{
    #[Route('/', name: 'site_index')]
    public function index(Driver $driver): Response
    {
        $data = $driver->callApi("2022/drivers");
        $i = 0;

        foreach ($data['MRData']['DriverTable']['Drivers'] as $pilote) {
            $pilote = new Driver();
            $results[] =
                $pilote
                    ->setDriverId($data['MRData']['DriverTable']['Drivers'][$i]['driverId'])
                    ->setFirstName($data['MRData']['DriverTable']['Drivers'][$i]['givenName'])
                    ->setLastName($data['MRData']['DriverTable']['Drivers'][$i]['familyName'])
                    ->setCode($data['MRData']['DriverTable']['Drivers'][$i]['code'])
                    ->setPermanentNumber($data['MRData']['DriverTable']['Drivers'][$i]['permanentNumber'])
                    ->setDateOfBirth($data['MRData']['DriverTable']['Drivers'][$i]['dateOfBirth'])
                    ->setNationality($data['MRData']['DriverTable']['Drivers'][$i]['nationality'])
            ;
            $i++;
        }

        return $this->render('site/index.html.twig', [
            'drivers' => $results,
    ]);
    }

}
