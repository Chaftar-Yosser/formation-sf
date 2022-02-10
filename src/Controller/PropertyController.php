<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController{

    /**
     * @var PropertyRepository
     */
    private  $repository;
    public function __construct(PropertyRepository $repository , ObjectManager $em){
        $this->repository = $repository;
        $this->em =$em;
    }

    /**
     * @Route("/biens" , name="property.index")
     * @return Response
     */
    public function index(): Response
    {

        $property = $this->repository->fidAllVisible();
        dump($property);
        $this->em->flush();
        return $this->render('property/index.html.twig' ,[
            'current_menu' => 'properties'
        ]);

    }

}