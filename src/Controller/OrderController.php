<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Livraison;
use App\Entity\Item;
use App\Entity\Address;
use App\Enum\statusOrderEnum;
use App\Repository\ServiceRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(
        Request $request,
        SessionInterface $session,
        ServiceRepository $serviceRepository,
        AddressRepository $addressRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        
        if ($request->isMethod('POST')) {
            $action = $request->request->get('action');
            
            switch ($action) {
                case 'set_address':
                    $this->handleSetAddress($request, $session);
                    break;
                case 'set_delivery':
                    $this->handleSetDelivery($request, $session);
                    break;
                case 'add_service':
                    $this->handleAddService($request, $session, $serviceRepository);
                    break;
                case 'remove_service':
                    $this->handleRemoveService($request, $session);
                    break;
                case 'set_contact':
                    $this->handleSetContact($request, $session);
                    break;
                case 'confirm_order':
                    return $this->handleConfirmOrder($session, $entityManager);
            }
        }
        
        $orderData = $session->get('order_data', []);
        
        $lastAddress = null;
        if ($user->getAddresse()->count() > 0) {
            $lastAddress = $user->getAddresse()->last();
        }
        
        $services = $serviceRepository->findAll();
        
        return $this->render('order/index.html.twig', [
            'user' => $user,
            'lastAddress' => $lastAddress,
            'services' => $services,
            'orderData' => $orderData,
        ]);
    }

    private function handleSetAddress(Request $request, SessionInterface $session): void
    {
        $orderData = $session->get('order_data', []);
        $orderData['address'] = [
            'address' => $request->request->get('address'),
            'details' => $request->request->get('address_details', ''),
        ];
        $session->set('order_data', $orderData);
    }

    private function handleSetDelivery(Request $request, SessionInterface $session): void
    {
        $orderData = $session->get('order_data', []);
        $orderData['delivery'] = [
            'collect_date' => $request->request->get('collect_date'),
            'collect_time' => $request->request->get('collect_time'),
            'collect_instructions' => $request->request->get('collect_instructions'),
            'delivery_date' => $request->request->get('delivery_date'),
            'delivery_time' => $request->request->get('delivery_time'),
            'delivery_instructions' => $request->request->get('delivery_instructions'),
        ];
        $session->set('order_data', $orderData);
    }

    private function handleAddService(Request $request, SessionInterface $session, ServiceRepository $serviceRepository): void
    {
        $serviceId = $request->request->get('service_id');
        $subServiceId = $request->request->get('sub_service_id');
        $quantity = (int) $request->request->get('quantity', 1);
        
        $service = $serviceRepository->find($serviceId);
        if (!$service) {
            return;
        }
        
        $orderData = $session->get('order_data', []);
        if (!isset($orderData['services'])) {
            $orderData['services'] = [];
        }
        
        $serviceKey = $serviceId . '_' . $subServiceId;
        if (isset($orderData['services'][$serviceKey])) {
            $orderData['services'][$serviceKey]['quantity'] += $quantity;
        } else {
            $subService = null;
            $price = 0;
            foreach ($service->getCoSevices() as $coService) {
                foreach ($coService->getSubServices() as $sub) {
                    if ($sub->getId() == $subServiceId) {
                        $subService = $sub;
                        $price = $sub->getPrice();
                        break 2;
                    }
                }
            }
            
            if ($subService) {
                $orderData['services'][$serviceKey] = [
                    'service_id' => $serviceId,
                    'service_name' => $service->getName(),
                    'sub_service_id' => $subServiceId,
                    'sub_service_name' => $subService->getName(),
                    'price' => $price,
                    'quantity' => $quantity,
                ];
            }
        }
        
        $session->set('order_data', $orderData);
    }

    private function handleRemoveService(Request $request, SessionInterface $session): void
    {
        $serviceKey = $request->request->get('service_key');
        
        $orderData = $session->get('order_data', []);
        if (isset($orderData['services'][$serviceKey])) {
            unset($orderData['services'][$serviceKey]);
        }
        
        $session->set('order_data', $orderData);
    }

    private function handleSetContact(Request $request, SessionInterface $session): void
    {
        $orderData = $session->get('order_data', []);
        $orderData['contact'] = [
            'first_name' => $request->request->get('first_name'),
            'last_name' => $request->request->get('last_name'),
            'phone' => $request->request->get('phone'),
            'email' => $request->request->get('email'),
        ];
        $session->set('order_data', $orderData);
    }

    private function handleConfirmOrder(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $orderData = $session->get('order_data', []);
        $user = $this->getUser();
        
        if (empty($orderData)) {
            $this->addFlash('error', 'Aucune donnée de commande trouvée.');
            return $this->redirectToRoute('app_order');
        }
        
        try {
            $order = new Order();
            $order->setUsere($user);
            $order->setStatus(statusOrderEnum::CREATED);
            
            $totalPrice = 0;
            
            if (isset($orderData['services'])) {
                foreach ($orderData['services'] as $serviceData) {
                    $item = new Item();
                    $item->setName($serviceData['service_name'] . ' - ' . $serviceData['sub_service_name']);
                    $item->setPrice($serviceData['price']);
                    $item->setQuantity($serviceData['quantity']);
                    $item->setDescription('Service: ' . $serviceData['service_name']);
                    $item->setImage('');
                    $item->setOrdere($order);
                    
                    $totalPrice += $serviceData['price'] * $serviceData['quantity'];
                    
                    $entityManager->persist($item);
                }
            }
            
            $order->setPriceTotal($totalPrice);
            $entityManager->persist($order);
            
            if (isset($orderData['delivery']) && isset($orderData['contact'])) {
                $livraison = new Livraison();
                $livraison->setFullName($orderData['contact']['first_name'] . ' ' . $orderData['contact']['last_name']);
                
                $fullAddress = isset($orderData['address']) ? 
                    $orderData['address']['address'] . ' ' . $orderData['address']['details'] : '';
                $livraison->setFullAddress($fullAddress);
                
                $collectDateTime = new \DateTime($orderData['delivery']['collect_date'] . ' ' . $orderData['delivery']['collect_time']);
                $deliveryDateTime = new \DateTime($orderData['delivery']['delivery_date'] . ' ' . $orderData['delivery']['delivery_time']);
                
                $livraison->setCollectedAt($collectDateTime);
                $livraison->setLivredAt($deliveryDateTime);
                
                $instructions = 'Collecte: ' . ($orderData['delivery']['collect_instructions'] ?? '') . 
                               '\nLivraison: ' . ($orderData['delivery']['delivery_instructions'] ?? '');
                $livraison->setInstructions($instructions);
                $livraison->setOrdere($order);
                
                $entityManager->persist($livraison);
            }
            
            $entityManager->flush();
            
            $session->remove('order_data');
            
            $this->addFlash('success', 'Votre commande a été créée avec succès !');
            return $this->redirectToRoute('app_profile');
            
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de la création de la commande.');
            return $this->redirectToRoute('app_order');
        }
    }
}
