<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Suppliers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EditCategoriesSuppliersController extends AbstractController
{
    #[Route('/edit-entity', name: 'edit_entity', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categories::class)->findAll();
        $suppliers = $entityManager->getRepository(Suppliers::class)->findAll();

        $type = $request->request->get('type');
        $entityId = $request->request->get('entity');
        $entity = null;

        if ($type === 'category' && $entityId) {
            $entity = $entityManager->getRepository(Categories::class)->find($entityId);
        } elseif ($type === 'supplier' && $entityId) {
            $entity = $entityManager->getRepository(Suppliers::class)->find($entityId);
        }

        if ($entity && $request->isMethod('POST') && $request->request->has('save')) {
            $name = $request->request->get('name');
            if ($type === 'category') {
                $slug = $request->request->get('slug');
                if ($name && $slug) {
                    $entity->setName($name);
                    $entity->setSlug($slug);
                }
            } elseif ($type === 'supplier') {
                $address = $request->request->get('address');
                $contact = $request->request->get('contact');
                if ($name && $address && $contact) {
                    $entity->setName($name);
                    $entity->setAddress($address);
                    $entity->setContact($contact);
                }
            }
            $entityManager->flush();
            $this->addFlash('success', ucfirst($type) . ' оновлено!');
            return $this->redirectToRoute('edit_entity');
        }

        return $this->render('edit_entity_page/edit_entity.html.twig', [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'selectedEntity' => $entity,
            'selectedType' => $type,
        ]);
    }
}
