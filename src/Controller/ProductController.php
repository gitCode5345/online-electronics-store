<?php
namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Suppliers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;

class ProductController extends AbstractController
{
    #[Route('/product/add', name: 'product_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $price = $request->request->get('price');
            $mainImage = $request->request->get('mainimage');
            $image = $request->request->get('image');
            $stock = $request->request->get('stock');
            $categoryId = $request->request->get('category');
            $supplierId = $request->request->get('supplier');

            if (!$name || !$description || !$price || !$categoryId || !$supplierId) {
                $this->addFlash('error', 'Fill all inputs!');
                return $this->redirectToRoute('product_add');
            }

            $category = $entityManager->getRepository(Categories::class)->find($categoryId);
            $supplier = $entityManager->getRepository(Suppliers::class)->find($supplierId);

            if (!$category || !$supplier) {
                $this->addFlash('error', 'Cant find.');
                return $this->redirectToRoute('product_add');
            }

            $product = new Products();
            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);
            $product->setPictures($image);
            $product->setmain_picture($mainImage);
            $product->setStock($stock);
            $product->setCategory($category);
            $product->setSupplier($supplier);

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Succesfully create!');
            return $this->redirectToRoute('product_add');
        }

        $categories = $entityManager->getRepository(Categories::class)->findAll();
        $suppliers = $entityManager->getRepository(Suppliers::class)->findAll();

        return $this->render('add_product_page/add.html.twig', [
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }
}
