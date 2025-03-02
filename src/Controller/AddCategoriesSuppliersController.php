<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Suppliers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddCategoriesSuppliersController extends AbstractController
{
    #[Route('/add-entity', name: 'add_entity', methods: ['GET', 'POST'])]
    public function addEntity(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $entityType = $request->request->get('entity_type');

            if ($entityType === 'category') {
                $category = new Categories();
                $category->setName($request->request->get('category_name'));
                $category->setSlug($request->request->get('category_slug'));

                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash('success', 'Category added successfully!');
            } elseif ($entityType === 'supplier') {
                $supplier = new Suppliers();
                $supplier->setName($request->request->get('supplier_name'));
                $supplier->setAddress($request->request->get('supplier_address'));
                $supplier->setContact($request->request->get('supplier_contact'));

                $entityManager->persist($supplier);
                $entityManager->flush();

                $this->addFlash('success', 'Supplier added successfully!');
            } else {
                if ($entityType !== null) {
                    $this->addFlash('error', 'Invalid entity type selected.');
                }
            }

            return $this->redirectToRoute('add_entity');
        }

        return $this->render('add_entity_page/add_entity.html.twig');
    }
}
