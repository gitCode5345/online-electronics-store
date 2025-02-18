<?php

namespace App\Controller;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddCategoriesController extends AbstractController
{
    #[Route('/categories/add', name: 'add_categories', methods: ['GET', 'POST'])]
    public function addCategory(Request $req, EntityManagerInterface $manager): Response
    {
        if ($req->isMethod('POST')) {
            $name = $req->request->get('name');
            $slug = $req->request->get('slug');

            if (!$name || !$slug) {
                $this->addFlash('error', 'Please, input all field');
                return $this->redirectToRoute('add_categories');
            }
    
            $category = new Categories();
            $category->setName($name);
            $category->setSlug($slug);
    
            $manager->persist($category);
            $manager->flush();
    
            $this->addFlash('success', 'Successfully add!');
            return $this->redirectToRoute('add_categories');
        }

        return $this->render('add_categories_page/categories.html.twig', [
            'controller_name' => 'AddCategoriesController',
        ]);
    }
}
