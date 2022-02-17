<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController{

    /**
     * @var PropertyRepository
     */
    private  $repository;
    public function __construct(PropertyRepository $repository , EntityManagerInterface $em){
        $this->repository = $repository;
        $this->em =$em;
    }

    /**
     * @Route("/biens" , name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12 /*limit per page*/

        );
        return $this->render('property/index.html.twig' , [
            'current_menu' => 'images' ,
            'properties' => $properties ,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/biens/{slug}-{id}" , name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function show(property $property , string $slug, Request $request ,ContactNotification $notification) : Response
    {

        if($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show' , [
               'id' => $property->getId() ,
                'slug' => $property->getSlug()
            ], 301);
        }
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request); //gére la requette

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success' , 'votre emeil a bien été envoyé');
            return $this->redirectToRoute('property.show' , [
                'id' => $property->getId() ,
                'slug' => $property->getSlug()
            ]);

        }

       return $this->render('property/show.html.twig' ,[
            'property' => $property,
            'current_menu' => 'images',
           'form' => $form->createView()
        ]);

    }

}