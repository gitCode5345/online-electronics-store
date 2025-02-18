<?php

namespace App\Controller;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EditCategoriesController extends AbstractController
{
    #[Route('/categories/edit', name: 'edit_categories', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categories::class)->findAll();
        $category = null;

        if ($request->isMethod('POST')) {
            $categoryId = $request->request->get('category');

            if ($categoryId) {
                $category = $entityManager->getRepository(Categories::class)->find($categoryId);
            }

            if ($category) {
                $name = $request->request->get('name');
                $slug = $request->request->get('slug');

                if ($name && $slug) {
                    $category->setName($name);
                    $category->setSlug($slug);
                    $entityManager->flush();
                    $this->addFlash('success', 'Категорія оновлена!');
                    return $this->redirectToRoute('edit_categories');
                }
            }
        }

        return $this->render('edit_categories/edit_categories.html.twig', [
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }
}
