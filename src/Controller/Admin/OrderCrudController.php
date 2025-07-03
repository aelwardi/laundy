<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Enum\statusOrderEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_ADMIN')]
class OrderCrudController extends AbstractCrudController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
            ->setSearchFields(['id', 'usere.firstName', 'usere.lastName', 'usere.email'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Gérer');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id', 'N° Commande')->onlyOnIndex(),
            
            NumberField::new('priceTotal', 'Prix Total')
                ->setNumDecimals(2)
                ->formatValue(function ($value) {
                    return number_format($value, 2, ',', ' ') . ' €';
                })
                ->setColumns(3),
                
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Créée' => statusOrderEnum::CREATED,
                    'Confirmée' => statusOrderEnum::CONFIRMED,
                    'Annulée' => statusOrderEnum::CANCELED,
                    'Collectée' => statusOrderEnum::COLLECTED,
                    'Payée' => statusOrderEnum::PAYED,
                    'Livrée' => statusOrderEnum::DELIVERED,
                    'Terminée' => statusOrderEnum::COMPLETED,
                ])
                ->renderAsBadges([
                    statusOrderEnum::CREATED->value => 'secondary',
                    statusOrderEnum::CONFIRMED->value => 'info',
                    statusOrderEnum::CANCELED->value => 'danger',
                    statusOrderEnum::COLLECTED->value => 'warning',
                    statusOrderEnum::PAYED->value => 'primary',
                    statusOrderEnum::DELIVERED->value => 'success',
                    statusOrderEnum::COMPLETED->value => 'dark',
                ])
                ->setColumns(3),
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = AssociationField::new('usere', 'Client')
                ->setColumns(4)
                ->formatValue(function ($value) {
                    if ($value) {
                        return $value->getFirstName() . ' ' . $value->getLastName() . ' (' . $value->getEmail() . ')';
                    }
                    return '';
                });
        }

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = TextField::new('usere.firstName', 'Prénom du client')
                ->setColumns(3)
                ->setFormTypeOption('disabled', true);
            
            $fields[] = TextField::new('usere.lastName', 'Nom du client')
                ->setColumns(3)
                ->setFormTypeOption('disabled', true);
            
            $fields[] = TextField::new('usere.email', 'Email du client')
                ->setColumns(3)
                ->setFormTypeOption('disabled', true);
            
            $fields[] = TextField::new('usere.phone', 'Téléphone')
                ->setColumns(3)
                ->setFormTypeOption('disabled', true);

            $fields[] = AssociationField::new('livraison', 'Livraison associée')
                ->setColumns(12)
                ->setFormTypeOption('disabled', true)
                ->formatValue(function ($value) {
                    if (!$value) {
                        return '<span class="badge bg-secondary">Aucune livraison</span>';
                    }
                    return '<span class="badge bg-success">Livraison #' . $value->getId() . '</span> - ' . $value->getFullName();
                });

            $fields[] = TextField::new('livraison_info', 'Informations de livraison')
                ->setColumns(12)
                ->setFormTypeOption('disabled', true)
                ->setFormTypeOption('mapped', false)
                ->formatValue(function ($value, $entity) {
                    if (!$entity) {
                        return '<div class="alert alert-danger">Entité Order non trouvée</div>';
                    }
                    
                    $livraison = $entity->getLivraison();
                    
                    if (!$livraison) {
                        $livraison = $this->entityManager->getRepository(\App\Entity\Livraison::class)->findOneBy(['ordere' => $entity]);
                    }
                    
                    if (!$livraison) {
                        return '<div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Aucune information de livraison</h6>
                            <p>Cette commande n\'a pas encore d\'informations de livraison associées.</p>
                            <small>ID Commande: ' . $entity->getId() . '</small>
                        </div>';
                    }
                    
                    $html = '<div class="livraison-info border rounded p-3">';
                    $html .= '<h6 class="mb-3"><i class="fas fa-truck text-primary"></i> Informations de livraison</h6>';
                    $html .= '<div class="row">';
                    $html .= '<div class="col-md-6">';
                    $html .= '<div class="mb-2">';
                    $html .= '<strong><i class="fas fa-user"></i> Nom complet:</strong><br>';
                    $html .= '<span class="text-muted">' . htmlspecialchars($livraison->getFullName() ?? 'Non renseigné') . '</span>';
                    $html .= '</div>';
                    $html .= '<div class="mb-2">';
                    $html .= '<strong><i class="fas fa-map-marker-alt"></i> Adresse:</strong><br>';
                    $html .= '<span class="text-muted">' . nl2br(htmlspecialchars($livraison->getFullAddress() ?? 'Non renseignée')) . '</span>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-6">';
                    $html .= '<div class="mb-2">';
                    if ($livraison->getCollectedAt()) {
                        $html .= '<span class="badge bg-success mb-1"><i class="fas fa-calendar-check"></i> Collecté</span><br>';
                        $html .= '<small>' . $livraison->getCollectedAt()->format('d/m/Y à H:i') . '</small>';
                    } else {
                        $html .= '<span class="badge bg-warning"><i class="fas fa-clock"></i> Collecte programmée</span>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="mb-2">';
                    if ($livraison->getLivredAt()) {
                        $html .= '<span class="badge bg-success mb-1"><i class="fas fa-calendar-check"></i> Livré</span><br>';
                        $html .= '<small>' . $livraison->getLivredAt()->format('d/m/Y à H:i') . '</small>';
                    } else {
                        $html .= '<span class="badge bg-info"><i class="fas fa-clock"></i> Livraison en attente</span>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    if ($livraison->getInstructions()) {
                        $html .= '<div class="mt-3 pt-3 border-top">';
                        $html .= '<strong><i class="fas fa-sticky-note text-info"></i> Instructions spéciales:</strong><br>';
                        $html .= '<div class="bg-light p-2 rounded mt-1 small">' . nl2br(htmlspecialchars($livraison->getInstructions())) . '</div>';
                        $html .= '</div>';
                    }
                    $html .= '<div class="mt-2 pt-2 border-top">';
                    $html .= '<small class="text-muted">ID Livraison: ' . $livraison->getId() . ' | ID Commande: ' . $entity->getId() . '</small>';
                    $html .= '</div>';
                    $html .= '</div>';
                    
                    return $html;
                });

            $fields[] = CollectionField::new('items', 'Articles')
                ->setColumns(12)
                ->setFormTypeOption('disabled', true)
                ->formatValue(function ($value) {
                    if (!$value) return '';
                    
                    $html = '<div class="order-items">';
                    foreach ($value as $item) {
                        $html .= '<div class="item-card mb-3 p-3 border rounded">';
                        $html .= '<div class="row">';
                        $html .= '<div class="col-md-2">';
                        if ($item->getImage()) {
                            $html .= '<img src="' . $item->getImage() . '" alt="' . $item->getName() . '" class="img-fluid" style="max-height: 80px;">';
                        }
                        $html .= '</div>';
                        $html .= '<div class="col-md-10">';
                        $html .= '<h6>' . $item->getName() . '</h6>';
                        $html .= '<p class="mb-1 text-muted">' . $item->getDescription() . '</p>';
                        $html .= '<div class="row">';
                        $html .= '<div class="col">Quantité: <strong>' . $item->getQuantity() . '</strong></div>';
                        $html .= '<div class="col">Prix unitaire: <strong>' . number_format($item->getPrice(), 2) . ' €</strong></div>';
                        $html .= '<div class="col">Total: <strong>' . number_format($item->getPrice() * $item->getQuantity(), 2) . ' €</strong></div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                    
                    return $html;
                })
                ->setTemplatePath('admin/fields/order_items.html.twig');

            $fields[] = CollectionField::new('comments', 'Commentaires/Avis')
                ->setColumns(12)
                ->setFormTypeOption('disabled', true)
                ->formatValue(function ($value) {
                    if (!$value || $value->isEmpty()) return '';
                    
                    $html = '<div class="order-comments">';
                    foreach ($value as $comment) {
                        $html .= '<div class="comment-card mb-3 p-3 border rounded">';
                        $html .= '<div class="d-flex justify-content-between align-items-start">';
                        $html .= '<div>';
                        $html .= '<p class="mb-1">' . nl2br(htmlspecialchars($comment->getContent())) . '</p>';
                        $html .= '</div>';
                        $html .= '<div class="text-end">';
                        $html .= '<div class="rating">';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $comment->getRating()) {
                                $html .= '<span class="text-warning">★</span>';
                            } else {
                                $html .= '<span class="text-muted">☆</span>';
                            }
                        }
                        $html .= '</div>';
                        $html .= '<small class="text-muted">' . $comment->getRating() . '/5</small>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                    
                    return $html;
                })
                ->onlyOnDetail();
        }

        return $fields;
    }
}
