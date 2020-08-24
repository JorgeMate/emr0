<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Entity\Type;
use App\Entity\Treatment;

use App\Form\TypeType;
use App\Form\TreatmentType;

use App\Repository\TypeRepository;
use App\Repository\TreatmentRepository;

use Knp\Component\Pager\PaginatorInterface;

/**
 * Controller used to manage current center.
 *
 * @Route("/center")
 * @Security("is_granted('ROLE_ADMIN')")
 *
 */
class TreatmentController extends AbstractController
{
    /**
     * @Route("/{slug}/treatment-types", methods={"GET"}, name="types_index")
     * @param TypeRepository $repository
     * @param Request $request
     * @param $slug
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexType(TypeRepository $repository, Request $request, $slug, PaginatorInterface $paginator): Response
    {

        $center = $this->getUser()->getCenter();
        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);
        
        #$types = $center->getTypes();
        #$em = $this->getDoctrine()->getManager();
        #$repository = $em->getRepository(Type::class);
        #$types = $repository->findBy(['center' => $center->getId()], ['name' => 'ASC']);

        $q = $request->query->get('q');
        $queryBuilder = $repository->findAllWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder,                      /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            10                                  /*limit per page*/
        );
        

        return $this->render('entity/type_trat/index.html.twig', [

            #'types' => $types,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{slug}/treatment-type/new", methods={"GET", "POST"}, name="type_new")
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function newType(Request $request, $slug): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);
        
        $type = new Type();
        $type->setCenter($center);

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');
            return $this->redirectToRoute('types_index', ['slug' => $slug] );
        }

        return $this->render('entity/type_trat/edit.html.twig', [

            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/treatment-type/{id}/edit", methods={"GET", "POST"}, name="type_edit")
     * @param Request $request
     * @param $slug
     * @param Type $type
     * @return Response
     */
    public function editType(Request $request, $slug, Type $type): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);        

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');
            return $this->redirectToRoute('types_index', ['slug' => $slug] );
        }

        return $this->render('entity/type_trat/edit.html.twig', [

            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/type/{id}/treatments", methods={"GET"}, name="treats_index")
     * @param TreatmentRepository $repository
     * @param Request $request
     * @param $slug
     * @param Type $type
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexTreat(TreatmentRepository $repository, Request $request, $slug, Type $type, PaginatorInterface $paginator): Response
    {
        $center = $this->getUser()->getCenter();
        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        #$em = $this->getDoctrine()->getManager();
        #$repository = $em->getRepository(Treatment::class);
        #$treatments = $repository->findBy(['type' => $type->getId()], ['name' => 'ASC']);

        $q = $request->query->get('q');
        $t = $type->getId();
        $queryBuilder = $repository->findAllWithSearchQueryBuilder($q, $t);

        $pagination = $paginator->paginate(
            $queryBuilder,                      /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            10                                  /*limit per page*/
        );


        return $this->render('entity/type_trat/trat_index.html.twig', [

            'type' => $type,
            #'treatments' => $treatments,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{slug}/type/{id}/treatment/new", methods={"GET", "POST"}, name="treatment_new")
     * @param Request $request
     * @param $slug
     * @param Type $type
     * @return Response
     */
    public function newTreatment(Request $request, $slug, Type $type): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center); 

        $treatment = new Treatment();
        $treatment->setType($type);

        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($treatment);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');
            return $this->redirectToRoute('treats_index', [ 'id' => $type->getId(), 'slug' => $slug] );
        }

        return $this->render('entity/type_trat/trat_edit.html.twig', [

            'treatment' => $treatment,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{slug}/treatment/{id}/edit", methods={"GET", "POST"}, name="treatment_edit")
     * @param Request $request
     * @param $slug
     * @param Treatment $treatment
     * @return Response
     */
    public function editTreatment(Request $request, $slug, Treatment $treatment): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);        

        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('treats_index', ['slug' => $slug, 'id' => $treatment->getType()->getId()] );
        }

        return $this->render('entity/type_trat/trat_edit.html.twig', [

            'treatment' => $treatment,
            'form' => $form->createView(),
        ]);

    }







}
