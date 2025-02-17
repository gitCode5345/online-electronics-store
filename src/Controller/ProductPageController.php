<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProductPageController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Товар не знайдено.');
        }

        // Розділяємо поле `pictures`, якщо там список файлів через кому
        $pictures = explode(',', $product->getPictures());

        return $this->render('product_page/product.html.twig', [
            'product' => $product,
            'pictures' => $pictures // Передаємо масив у Twig
        ]);
    }

}
